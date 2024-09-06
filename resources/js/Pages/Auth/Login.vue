<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    users: {},
    password: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

function SetSampleUser(email, password){
    form.email = email
    form.password = password
}
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div class="mb-5">
            <p class="text-base ...">Sample Users ...</p>
            <table class="w-full">
                <thead>
                    <tr>
                        <!-- <th class="border border-slate-300">Name</th> -->
                        <th class="border border-slate-300">Type</th>
                        <th class="border border-slate-300">Email</th>
                        <th class="border border-slate-300">Password</th>
                        <th class="border border-slate-300">
                            
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :class="{'bg-slate-300': user.type == 'admin'}">
                        <!-- <td class="border border-slate-300">{{ user.name }}</td> -->
                        <td class="border border-slate-300">{{ user.type }}</td>
                        <td class="border border-slate-300">{{ user.email }}</td>
                        <td class="border border-slate-300">{{ password }}</td>
                        <td class="border border-slate-300">
                            <PrimaryButton @click="SetSampleUser(user.email, password)">Use</PrimaryButton>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Forgot your password?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
