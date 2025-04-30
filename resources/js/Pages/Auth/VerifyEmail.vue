<script setup>
import { computed } from "vue";
import GuestLayout from "@/Imperium/Layouts/GuestLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
  status: {
    type: String,
  },
});

const form = useForm({});

const submit = () => {
  form.post(route("verification.send"));
};

const verificationLinkSent = computed(
  () => props.status === "verification-link-sent"
);
</script>

<template>
  <GuestLayout>
    <Head title="Email Verification" />

    <div class="mb-4 text-sm text-gray-600">
      Thanks for signing up! Before getting started, could you verify your email
      address by clicking on the link we just emailed to you? If you didn't
      receive the email, we will gladly send you another.
    </div>

    <div
      class="mb-4 text-sm font-medium text-green-600"
      v-if="verificationLinkSent"
    >
      A new verification link has been sent to the email address you provided
      during registration.
    </div>

    <form @submit.prevent="submit">
      <div class="mt-4 flex items-center justify-between">
        <Button
          type="submit"
          label="Resend Verification Email"
          :loading="form.processing"
          :disabled="form.processing"
        />

        <Link
          :href="route('logout')"
          method="post"
          as="button"
          class="p-button p-component"
        >
          <span class="p-button-label">Log Out</span>
        </Link>
      </div>
    </form>
  </GuestLayout>
</template>
