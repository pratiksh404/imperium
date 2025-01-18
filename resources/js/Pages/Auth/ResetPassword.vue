<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Reset Password" />

        <form @submit.prevent="submit">
            <div>
                <FloatLabel variant="on">
                    <InputText type="email" id="email" v-model="form.email" autocomplete="off"
                        :invalid="Boolean(form.errors.email)" size="large" fluid />
                    <label for="email">Email</label>
                </FloatLabel>
                <InputError v-if="form.errors.email" class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <FloatLabel variant="on">
                    <Password type="password" id="password" v-model="form.password" autocomplete="off"
                        :invalid="Boolean(form.errors.password)" size="large" :feedback="false" fluid toggleMask />
                    <label for="password">Password</label>
                </FloatLabel>

                <InputError v-if="form.errors.password" class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <FloatLabel variant="on">
                    <Password type="password" id="password_confirmation" v-model="form.password_confirmation"
                        autocomplete="off" :invalid="Boolean(form.errors.password_confirmation)" size="large"
                        :feedback="false" fluid toggleMask />
                    <label for="password_confirmation">Confirm Password</label>
                </FloatLabel>

                <InputError v-if="form.errors.password_confirmation" class="mt-2"
                    :message="form.errors.password_confirmation" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Button type="submit" :loading="form.processing" label="Reset Password" :disabled="form.processing" />
            </div>
        </form>
    </GuestLayout>
</template>
