<template>
  <div>
    <form @submit.prevent="submit">
      <TextInput
        label="Name"
        name="name"
        v-model="form.name"
        :error="form.errors.name"
        placeholder="User Name"
        :model-value="form.name"
      />
      <SubmitButton :processing="form.processing" buttonText="Save" />
    </form>
  </div>
</template>
<script setup>
import { defineProps } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useEventsStore } from "@/Imperium/Store/events";
import TextInput from "@/Imperium/Components/Form/Fields/TextField.vue";
import SubmitButton from "@/Imperium/Components/Form/SubmitButton.vue";
import { useToast } from "primevue/usetoast";
const toast = useToast();

// Form Success State Management
const eventsStore = useEventsStore();

const props = defineProps({
  errors: Object,
  method: {
    required: true,
    type: String,
    default: "post",
  },
  url: {
    required: true,
    type: String,
  },
  formData: {
    type: Object,
    default: () => {},
  },
});

const form = useForm({
  name: props.formData?.name ?? null,
});

const submit = () => {
  form[props.method](props.url, {
    preserveScroll: true,
    onSuccess: () => {
      toast.add({
        severity: "success",
        summary: "Success",
        detail: "User created",
        life: 3000,
      });
      form.reset();
      eventsStore.triggerFormSuccess();
    },
    onError: () => {
      toast.add({
        severity: "error",
        summary: "Error",
        detail: "User not created",
        life: 3000,
      });
    },
  });
};
</script>
<script>
export default {
  name: "UserForm",
};
</script>
