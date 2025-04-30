<script setup>
import GuestLayout from "@/Imperium/Layouts/GuestLayout.vue";
import InputError from "@/Imperium/Components/InputError.vue";
import InputLabel from "@/Imperium/Components/InputLabel.vue";
import PrimaryButton from "@/Imperium/Components/PrimaryButton.vue";
import TextInput from "@/Imperium/Components/TextInput.vue";
import { Head, useForm } from "@inertiajs/vue3";

const form = useForm({
  password: "",
});

const submit = () => {
  form.post(route("password.confirm"), {
    onFinish: () => form.reset(),
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Confirm Password" />

    <div class="mb-4 text-sm text-gray-600">
      This is a secure area of the application. Please confirm your password
      before continuing.
    </div>

    <form @submit.prevent="submit">
      <div>
        <FloatLabel variant="on">
          <Password
            type="password"
            id="password"
            v-model="form.password"
            autocomplete="off"
            :invalid="Boolean(form.errors.password)"
            size="large"
            :feedback="false"
            fluid
            toggleMask
          />
          <label for="password">Password</label>
        </FloatLabel>

        <InputError
          v-if="form.errors.password"
          class="mt-2"
          :message="form.errors.password"
        />
      </div>

      <div class="mt-4 flex justify-end">
        <Button
          type="submit"
          :loading="form.processing"
          class="ms-4"
          label="Confirm"
          :disabled="form.processing"
        />
      </div>
    </form>
  </GuestLayout>
</template>
