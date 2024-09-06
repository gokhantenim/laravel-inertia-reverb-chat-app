<script setup>
import ChatBubble from '@/Components/Chat/Icons/ChatBubble.vue'

const props = defineProps(['room'])

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