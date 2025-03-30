<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({ errors: Object });

const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("register"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Register" />

    <form @submit.prevent="submit">
      <div>
        <FloatLabel variant="on">
          <InputText
            type="text"
            id="name"
            v-model="form.name"
            autocomplete="off"
            :invalid="Boolean(errors.name)"
            size="large"
            fluid
          />
          <label for="name">Name</label>
        </FloatLabel>
        <InputError v-if="errors.name" class="mt-2" :error="errors.name" />
      </div>

      <div class="mt-4">
        <FloatLabel variant="on">
          <InputText
            type="email"
            id="email"
            v-model="form.email"
            autocomplete="off"
            :invalid="Boolean(errors.email)"
            size="large"
            fluid
          />
          <label for="email">Email</label>
        </FloatLabel>
        <InputError v-if="errors.email" class="mt-2" :error="errors.email" />
      </div>

      <div class="mt-4">
        <FloatLabel variant="on">
          <Password
            type="password"
            id="password"
            v-model="form.password"
            autocomplete="off"
            :invalid="Boolean(errors.password)"
            size="large"
            :feedback="false"
            fluid
            toggleMask
          />
          <label for="password">Password</label>
        </FloatLabel>

        <InputError
          v-if="errors.password"
          class="mt-2"
          :error="errors.password"
        />
      </div>

      <div class="mt-4">
        <FloatLabel variant="on">
          <Password
            type="password"
            id="password_confirmation"
            v-model="form.password_confirmation"
            autocomplete="off"
            :invalid="Boolean(errors.password_confirmation)"
            size="large"
            :feedback="false"
            fluid
            toggleMask
          />
          <label for="password_confirmation">Confirm Password</label>
        </FloatLabel>

        <InputError
          v-if="errors.password_confirmation"
          class="mt-2"
          :error="errors.password_confirmation"
        />
      </div>

      <div class="mt-4 flex items-center justify-between">
        <Link
          :href="route('login')"
          class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
        >
          Already registered?
        </Link>

        <Button
          class="ms-4"
          :disabled="form.processing"
          type="submit"
          :loading="form.processing"
          label="Register"
        />
      </div>
    </form>
  </GuestLayout>
</template>
