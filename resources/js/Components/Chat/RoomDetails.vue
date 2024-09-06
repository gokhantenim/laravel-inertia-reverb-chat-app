<script setup>
import MyMessage from '@/Components/Chat/MyMessage.vue'
import OtherMessage from '@/Components/Chat/OtherMessage.vue'
import PaperAirplane from '@/Components/Chat/Icons/PaperAirplane.vue'
import ChatBubble from '@/Components/Chat/Icons/ChatBubble.vue'
import UsersIcon from '@/Components/Chat/Icons/Users.vue'
import XCircleIcon from '@/Components/Chat/Icons/XCircle.vue'
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { computed, onUnmounted, onMounted, ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3';

const props = defineProps(['room', 'user'])

const showUsersDialog = ref(false)

const form = useForm({
    message: '',
});

onMounted(() => {
    entered()
})

onUnmounted(() => {
    left(props.room)
})

watch(() => {
    if(!props.room) return
    return props.room
}, (newRoom, oldRoom) => {
    left(oldRoom)
    entered()
})

const isAdmin = computed(() => {
    if(props.user.type == 'admin') return true
    if(!props.room || !props.room.users) return false
    const me = props.room.users
        .find( roomUser => roomUser.id == props.user.id)
    if(!me) return false
    return me.pivot.type == 'admin'
})

const userNames = computed(() => {
    if(!props.room || !props.room.users || !props.room.onlineUsers) return ''
    const onlineUserNames =  Object.values(props.room.onlineUsers)
        .map((onlineUser) => {
            return '🟢 ' + onlineUser.name
        })
    const offlineUserNames = props.room.users
        .filter(roomUser => !props.room.onlineUsers[roomUser.id])
        .map((roomUser) => {
            return '🔴 ' + roomUser.name
        })
    return [...onlineUserNames, ...offlineUserNames].join(', ')
})

function left(room){
    Echo.leave(`roomonline.${room.id}`)
}

function entered(){
    Echo.join(`roomonline.${props.room.id}`)
        .here((onlineUsers) => {
            onlineUsers.forEach((onlineUser) => {
                setUserOnline(onlineUser, true)
            })
        })
        .joining((onlineUser)=> {
            setUserOnline(onlineUser, true)
        })
        .leaving((onlineUser)=> {
            setUserOnline(onlineUser, false)
        })

    loadDetails()
}

function setUserOnline(user, inRoom){
    if(!props.room.onlineUsers){
        props.room.onlineUsers = {}
    }
    if(inRoom){
        props.room.onlineUsers[user.id] = user
    } else {
        delete props.room.onlineUsers[user.id]
    }
}

function loadDetails(){
    if(props.room.loaded){
        return
    }

    axios.get(`/rooms/${props.room.id}/details`)
        .then((result) => {
            props.room.messages = result.data.messages
            props.room.users = result.data.users
            props.room.loaded = true
        })
}

function submitMessage(){
    form.post(`/rooms/${props.room.id}/send-message`, {
        onFinish: () => {
            form.message = ''
        },
    })
}

function removeUser(user){
    axios.post(`/rooms/${props.room.id}/remove-user`, user)
}

function toggleRole(user){
    axios.post(`/rooms/${props.room.id}/set-role`, {
        id: user.id,
        type: user.pivot.type == 'admin' ? 'normal' : 'admin'
    })
}

function removeRoom(){
    axios.delete(`/rooms/${props.room.id}/remove`)
}
</script>
<template>
    <div class="w-2/3 border flex flex-col">
        <Modal :show="showUsersDialog" @close="showUsersDialog = false">
            <div class="p-6">
                <div>
                    <h1>Room Users</h1>
                </div>
                <div>
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border border-slate-300">Name</th>
                                <th class="border border-slate-300">Type</th>
                                <th class="border border-slate-300">
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="roomUser in room.users" :class="{'bg-slate-300': roomUser.pivot.type == 'admin'}">
                                <td class="border border-slate-300">
                                    {{ room.onlineUsers[roomUser.id] ? '🟢' : '🔴' }} 
                                    {{ roomUser.name }}
                                </td>
                                <td class="border border-slate-300">{{ roomUser.pivot.type }}</td>
                                <td class="border border-slate-300">
                                    <PrimaryButton
                                        v-if="isAdmin && roomUser.id != user.id"
                                        @click="removeUser(roomUser)"
                                    >
                                        Kick
                                    </PrimaryButton>
                                    <PrimaryButton
                                        v-if="isAdmin"
                                        @click="toggleRole(roomUser)"
                                    >
                                        Set {{ roomUser.pivot.type == 'admin' ? 'Normal' : 'Admin' }}
                                    </PrimaryButton>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ms-4" @click="$emit('addUser'); showUsersDialog = false">
                        Add User
                    </PrimaryButton>

                    <SecondaryButton class="ms-4" @click="showUsersDialog = false">
                        Cancel
                    </SecondaryButton>
                </div>
            </div>
        </Modal>

        <!-- Header -->
        <div class="py-2 px-3 bg-grey-lighter flex flex-row justify-between items-center">
            <div class="flex items-center">
                <div>
                    <div class="h-10 w-10 rounded-full bg-indigo-500">
                        <ChatBubble class="stroke-cyan-500" />
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-grey-darkest">
                        {{ room.name }}
                    </p>
                    <p class="text-grey-darker text-xs mt-1">
                        {{ userNames }}
                    </p>
                </div>
            </div>

            <div class="flex">
                <div class="ml-6">
                    <button class="mr-4" v-if="isAdmin" @click="removeRoom()">
                        <XCircleIcon class="size-6" />
                    </button>
                    <button @click="showUsersDialog = true">
                        <UsersIcon class="size-6" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Messages -->
        <div class="flex-1 overflow-auto" style="background-color: #DAD3CC">
            <div class="py-2 px-3">

                <template v-for="message in room.messages">
                    <MyMessage v-if="message.user_id == user.id" :message="message" />
                    <OtherMessage v-else :message="message" />
                </template>

            </div>
        </div>

        <!-- Input -->
        <div class="bg-grey-lighter px-4 py-4 flex items-center">
            <div class="flex-1 mx-4">
                <form @submit.prevent="submitMessage">
                    <input v-model="form.message" class="w-full border rounded px-2 py-2" type="text"/>
                </form>
            </div>
            <button @click="submitMessage()">
                <PaperAirplane class="stroke-grey-500 size-6" />
            </button>
        </div>
    </div>
</template>