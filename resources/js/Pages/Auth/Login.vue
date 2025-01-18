<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
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
</script>

<template>
    <GuestLayout>

        <Head title="Log in" />

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

            <div class="mt-4">
                <FloatLabel variant="on">
                    <Password type="password" id="password" v-model="form.password" autocomplete="off"
                        :invalid="Boolean(form.errors.password)" size="large" :feedback="false" fluid toggleMask />
                    <label for="password">Password</label>
                </FloatLabel>

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4 block">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                </label>
            </div>

            <div class="mt-4 flex items-center justify-between">
                <Link v-if="canResetPassword" :href="route('password.request')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800">
                Forgot your password?
                </Link>

                <Button class="ms-4" :disabled="form.processing" type="submit" :loading="form.processing"
                    label="Log in" />
            </div>
        </form>
    </GuestLayout>
</template>