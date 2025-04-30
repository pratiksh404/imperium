<template>
  <div>
    <form @submit.prevent="submit">
      <TextField
        label="Name"
        name="name"
        v-model="form.name"
        :error="form.errors.name"
        placeholder="Role Name"
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
import TextField from "@/Imperium/Components/Form/Fields/TextField.vue";
import SubmitButton from "@/Imperium/Components/Form/SubmitButton.vue";
import { useToast } from "primevue/usetoast";
const toast = useToast();

// Form Success State Management
const eventsStore = useEventsStore();

const props = defineProps({
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
        detail: "Role created",
        life: 3000,
      });
      form.reset();
      eventsStore.triggerFormSuccess();
    },
    onError: () => {
      toast.add({
        severity: "error",
        summary: "Error",
        detail: "Role not created",
        life: 3000,
      });
    },
  });
};
</script>
<script>
export default {
  name: "RoleForm",
};
</script>
