<script setup>
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { computed } from 'vue';

const props = defineProps(['show', 'users', 'room'])
const emit = defineEmits(['close'])

const roomUsersByKey = computed(() => {
    if(!props.room || !props.room.users) return {}
    return props.room.users
        .reduce((result, roomUser) => {
            result[roomUser.id] = roomUser
            return result
        }, {})
})

function addUser(user){
    axios.post(`/rooms/${props.room.id}/add-user`, user)
        .then(() => {
            emit('close')
        })
}
</script>
<template>
    <Modal :show="show" @close="$emit('close')">
        <div class="p-6">
            <div>
                <h1>Add user to {{ room.name }}</h1>
            </div>
            <div>
                <table class="w-full">
                    <thead>
                        <tr>
                            <th class="border border-slate-300">Name</th>
                            <th class="border border-slate-300">
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users">
                            <td class="border border-slate-300">{{ user.name }}</td>
                            <td class="border border-slate-300">
                                <span v-if="roomUsersByKey[user.id]">Already in room</span>
                                <PrimaryButton
                                    v-else
                                    @click="addUser(user)"
                                >
                                    Add
                                </PrimaryButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-end mt-4">
                <SecondaryButton class="ms-4" @click="$emit('close')">
                    Cancel
                </SecondaryButton>
            </div>
        </div>
    </Modal>
</template>