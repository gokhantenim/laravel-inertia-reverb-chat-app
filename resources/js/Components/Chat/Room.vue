<script setup>
import ChatBubble from '@/Components/Chat/Icons/ChatBubble.vue'
import { onMounted, onUnmounted } from 'vue';

const props = defineProps(['room'])

onMounted(() => {
    Echo.private(`room.${props.room.id}`)
        .listen('MessageSent', (e) => {
            if(!props.room.messages){
                props.room.messages = []
            }
            props.room.messages.push(e.message)
        })
        .listen('RoomUserAttached', (e) => {
            if(!props.room.users){
                props.room.users = []
            }
            props.room.users.push(e.user)
        })
        .listen('RoomUserDetached', (e) => {
            if(!props.room.users) return
            const userIndex = props.room.users
                .findIndex(roomUser => roomUser.id == e.user.id)
            if(userIndex == -1) return
            props.room.users.splice(userIndex, 1)
        })
        .listen('RoomUserRoleChanged', (e) => {
            const roomUser = props.room.users
                .find(roomUser => roomUser.id == e.userId)
            if(!roomUser) return
            roomUser.pivot.type = e.type
        })
})
onUnmounted(() => {
    Echo.leave(`room.${props.room.id}`)
})
</script>
<template>
    <div class="bg-white px-3 flex items-center bg-grey-light hover:bg-grey-lighter cursor-pointer">
        <div>
            <div class="h-12 w-12 rounded-full bg-indigo-500">
                <ChatBubble class="stroke-cyan-500" />
            </div>
        </div>
        <div class="ml-4 flex-1 border-b border-grey-lighter py-4">
            <div class="flex items-bottom justify-between">
                <p class="text-grey-darkest">
                    {{ room.name }}
                </p>
                <!-- <p class="text-xs text-grey-darkest">
                    12:45 pm
                </p> -->
            </div>
            <!-- <p class="text-grey-dark mt-1 text-sm">
                Lorem ipsum dolor sit amet
            </p> -->
        </div>
    </div>
</template>