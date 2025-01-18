<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>

        <Head title="Forgot Password" />

        <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email
            address and we will email you a password reset link that will allow
            you to choose a new one.
        </div>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <FloatLabel variant="on">
                    <InputText type="email" id="email" v-model="form.email" autocomplete="off"
                        :invalid="Boolean(form.errors.email)" size="large" fluid />
                    <label for="email">Email</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Button type="submit" label="Email Password Reset Link" :loading="form.processing"
                    :disabled="form.processing" />
            </div>
        </form>
    </GuestLayout>
</template>
