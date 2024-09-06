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
import { ref } from 'vue'

const showUsersDialog = ref(false)
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
                            <tr v-for="i in 3">
                                <td class="border border-slate-300">
                                    🟢 Test User
                                </td>
                                <td class="border border-slate-300">admin</td>
                                <td class="border border-slate-300">
                                    <PrimaryButton>Kick</PrimaryButton>
                                    <PrimaryButton>Set Admin</PrimaryButton>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ms-4" @click="showUsersDialog = false">
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
                        Test room
                    </p>
                    <p class="text-grey-darker text-xs mt-1">
                        User 1, User 2
                    </p>
                </div>
            </div>

            <div class="flex">
                <div class="ml-6">
                    <button class="mr-4">
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

                <MyMessage :message="{message: 'test message', created_at: '2024-09-06 15:56:11'}" />
                <OtherMessage :message="{message: 'test message', user: {name: 'Test User'}, created_at: '2024-09-06 15:56:11'}" />

            </div>
        </div>

        <!-- Input -->
        <div class="bg-grey-lighter px-4 py-4 flex items-center">
            <div class="flex-1 mx-4">
                <form>
                    <input  class="w-full border rounded px-2 py-2" type="text"/>
                </form>
            </div>
            <button>
                <PaperAirplane class="stroke-grey-500 size-6" />
            </button>
        </div>
    </div>
</template>