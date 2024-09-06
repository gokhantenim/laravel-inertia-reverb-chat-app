<script setup>
import { Link } from '@inertiajs/vue3';
import Room from '@/Components/Chat/Room.vue'
import RoomDetails from '@/Components/Chat/RoomDetails.vue'
import PowerIcon from '@/Components/Chat/Icons/Power.vue'
import UserCircleIcon from '@/Components/Chat/Icons/UserCircle.vue'
import ChatBubbleIcon from '@/Components/Chat/Icons/ChatBubble.vue'

import CreateRoom from '@/Components/Chat/CreateRoom.vue';
import AddUserToRoom from '@/Components/Chat/AddUserToRoom.vue';
import { ref } from 'vue';

const openCreateRoom = ref(false)
const openAddUser = ref(false)
</script>
<template>
    <div>
        <CreateRoom :show="openCreateRoom" @close="openCreateRoom = false" />
        <AddUserToRoom :show="openAddUser" @close="openAddUser = false" /> 
        
        <div class="w-full h-32" style="background-color: #449388"></div>

        <div class="container mx-auto" style="margin-top: -128px;">
            <div class="py-6 h-screen">
                <div class="flex border border-grey rounded shadow-lg h-full">

                    <!-- Left -->
                    <div class="w-1/3 border flex flex-col">

                        <!-- Header -->
                        <div class="py-2 px-3 bg-grey-lighter flex flex-row justify-between items-center">
                            <div class="flex">
                                <div class="h-10 w-10 rounded-full bg-indigo-500 mr-6">
                                    <UserCircleIcon class="stroke-cyan-500" />
                                </div>
                                <div>
                                    <p>Test User</p>
                                    <p>Role: normal</p>
                                </div>
                            </div>

                            <div class="flex">
                                <div>
                                    <button>
                                        <ChatBubbleIcon @click="openCreateRoom=true" class="stroke-slate-700 size-6" />
                                    </button>
                                </div>
                                <div class="ml-4">
                                    <Link
                                        href="logout"
                                        method="post"
                                        as="button"
                                    >
                                        <PowerIcon class="stroke-slate-700 size-6" />
                                    </Link>
                                </div>
                            </div>
                        </div>

                        <!-- Contacts -->
                        <div class="bg-grey-lighter flex-1 overflow-auto">
                            <Room v-for="i in 3" :room="{name: 'test'}" />
                        </div>

                    </div>


                    <!-- Right -->
                    <RoomDetails />

                </div>
            </div>
        </div>
    </div>
</template>