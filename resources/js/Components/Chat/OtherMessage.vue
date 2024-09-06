<script setup>
const props = defineProps(['message'])

const createdAt = new Date(props.message.created_at).toLocaleTimeString()
</script>
<template>
    <div class="flex mb-2">
        <div class="rounded py-2 px-3" style="background-color: #F2F2F2">
            <p class="text-sm text-purple">
                {{ message.user?.name }}
            </p>
            <p class="text-sm mt-1">
                {{ message.message }}
            </p>
            <p class="text-right text-xs text-grey-dark mt-1">
                {{ createdAt }}
            </p>
        </div>
    </div>
</template>