<script setup>
import { Head } from '@inertiajs/vue3';
import ChatApp from '@/Components/Chat/ChatApp.vue';
</script>

<template>
    <Head title="Chat" />

    <ChatApp :user="$page.props.auth.user" />
</template>
