<script setup>
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps(['show'])
const emit = defineEmits(['close'])

</script>
<template>
    <Modal :show="show" @close="$emit('close')">
        <div class="p-6">
            <div>
                <h1>Add user to test room</h1>
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
                        <tr v-for="i in 5">
                            <td class="border border-slate-300">Test User</td>
                            <td class="border border-slate-300">
                                <PrimaryButton>Add</PrimaryButton>
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