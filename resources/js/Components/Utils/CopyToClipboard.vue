<template>
  <Button @click="copyToClipboard" :label="label" />
</template>
<script setup>
import { ref, defineProps } from "vue";
import { useClipboard } from "@vueuse/core";
import { useToast } from "primevue/usetoast";
import { useIntervalFn } from "@vueuse/core";

const toast = useToast();
const props = defineProps({
  copyText: {
    type: String,
    required: true,
  },
  beforeCopyLabel: {
    type: String,
    default: "Copy",
  },
  afterCopyLabel: {
    type: String,
    default: "Copied",
  },
  successToastMessage: {
    type: String,
    default: "Copied to clipboard!",
  },
});

const label = ref(props.beforeCopyLabel);

const copyToClipboard = () => {
  const { copy, isSupported } = useClipboard();
  if (isSupported) {
    copy(props.copyText);

    toast.add({
      severity: "success",
      summary: "Success",
      detail: props.successToastMessage,
      life: 3000,
    });

    // Displaying Copied to clipboard for 3 seconds
    label.value = props.afterCopyLabel;

    useIntervalFn(() => {
      label.value = props.beforeCopyLabel;
    }, 2000);
  } else {
    toast.add({
      severity: "error",
      summary: "Error",
      detail: "Clipboard not supported",
      life: 3000,
    });
  }
};
</script>
