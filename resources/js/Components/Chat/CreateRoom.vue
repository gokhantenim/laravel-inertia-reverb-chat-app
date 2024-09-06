<script setup>
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps(['show'])
const form = useForm({
    name: '',
});
const emit = defineEmits(['close'])

function submit(){
    form.post('/rooms/create', {
        onFinish: () => {
            form.name = ''
            emit('created')
            emit('close')
        },
    })
}
</script>
<template>
    <Modal :show="show" @close="$emit('close')">
        <div class="p-6">
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="name" value="Room Name" />
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="username"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Create Room
                    </PrimaryButton>

                    <SecondaryButton class="ms-4" @click="$emit('close')">
                        Cancel
                    </SecondaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>