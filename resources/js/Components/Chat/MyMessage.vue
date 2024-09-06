<script setup>
const props = defineProps(['message'])

const createdAt = new Date(props.message.created_at).toLocaleTimeString()
</script>
<template>
    <div class="flex justify-end mb-2">
        <div class="rounded py-2 px-3" style="background-color: #E2F7CB">
            <p class="text-sm mt-1">
                {{ message.message }}
            </p>
            <p class="text-right text-xs text-grey-dark mt-1">
                {{ createdAt }}
            </p>
        </div>
    </div>
</template>