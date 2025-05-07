<template>
  <ConfirmPopup></ConfirmPopup>
  <div class="flex justify-end" v-if="data.deleted_at === null">
    <!-- Edit -->
    <ModuleFormOverlay
      :name="name"
      :label="'Edit ' + name"
      :key="name + 'module-edit' + data.id"
      v-if="data.can.update"
    >
      <template #trigger>
        <Button
          class="h-full"
          size="small"
          icon="pi pi-pencil"
          severity="secondary"
          variant="text"
          raised
          v-tooltip.top="'Edit'"
        />
      </template>
      <template #form>
        <component
          :is="moduleForm"
          :name="name"
          method="patch"
          :url="route(url + '.update', data.id)"
          :form-data="data"
        >
        </component>
      </template>
    </ModuleFormOverlay>
    <!-- Show -->
    <Button
      icon="pi pi-eye"
      class="mx-2"
      variant="text"
      severity="info"
      raised
      size="small"
      @click="visibleRight = true"
      v-tooltip.top="'Show'"
      v-if="data.can.view"
    />
    <Drawer
      v-model:visible="visibleRight"
      :header="name"
      position="right"
      :key="name + 'module-show' + data.id"
      v-if="data.can.view"
      class="w-1/4"
    >
      <FieldPresentationPanel :data="data" :name="name" />
    </Drawer>

    <Button
      size="small"
      @click="deleteEvent($event)"
      icon="pi pi-times"
      severity="danger"
      v-if="data.can.delete"
      variant="text"
      raised
      v-tooltip.top="'Delete'"
    />
  </div>
  <template v-if="data.deleted_at !== null">
    <Button
      class="mx-2"
      size="small"
      @click="restoreEvent($event)"
      icon="pi pi-refresh"
      severity="danger"
      v-if="data.can.restore"
      variant="text"
      raised
      v-tooltip.top="'Restore'"
    />
  </template>
</template>
<script setup>
import { defineProps, ref } from "vue";
import { router } from "@inertiajs/vue3";
import ModuleFormOverlay from "@/Imperium/Components/Modules/FormOverlay.vue";
import FieldPresentationPanel from "@/Imperium/Components/Presentation/FieldPresentationPanel.vue";
import { useToast } from "primevue/usetoast";
import { useServerRequest } from "@/Imperium/Composables/useServerRequest";
const toast = useToast();

import { useConfirm } from "primevue/useconfirm";

const props = defineProps({
  name: {
    required: true,
    type: String,
  },
  data: {
    required: true,
    type: Object,
  },
  url: {
    required: true,
    type: String,
  },
  moduleForm: {
    required: false,
    type: Object,
    default: null,
  },
});

const showToast = () => {
  toast.add({
    severity: "info",
    summary: "Info",
    detail: "Message Content",
    life: 3000,
  });
};
const visibleRight = ref(false);

const confirm = useConfirm();

const deleteEvent = (event) => {
  confirm.require({
    target: event.currentTarget,
    message: "Do you want to delete this record?",
    icon: "pi pi-info-circle",
    rejectProps: {
      label: "Cancel",
      severity: "secondary",
      outlined: true,
    },
    acceptProps: {
      label: "Delete",
      severity: "danger",
    },
    accept: () => {
      router.delete(route(props.url + ".destroy", props.data.id));
      toast.add({
        severity: "success",
        summary: "Success",
        detail: "Data deleted",
        life: 3000,
      });
    },
    reject: () => {
      toast.add({
        severity: "info",
        summary: "Info",
        detail: "Data delete cancelled",
        life: 3000,
      });
    },
  });
};

const restoreEvent = (event) => {
  confirm.require({
    target: event.currentTarget,
    message: "Do you want to restore this record?",
    icon: "pi pi-info-circle",
    rejectProps: {
      label: "Cancel",
      severity: "secondary",
      outlined: true,
    },
    acceptProps: {
      label: "Restore",
      severity: "success",
    },
    accept: () => {
      const { update } = useServerRequest(toast);
      update(route("restore", [props.name.toLowerCase(), props.data.id]));
    },
    reject: () => {
      toast.add({
        severity: "info",
        summary: "Info",
        detail: "Data restore cancelled",
        life: 3000,
      });
    },
  });
};
</script>
<style></style>