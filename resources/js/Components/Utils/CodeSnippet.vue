<template>
  <div class="code-snippet h-full">
    <highlightjs language="php" :code="code" />
    <button @click="copyToClipboard" class="copy-button">
      {{ copyToClipboardText }}
    </button>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import "highlight.js/styles/github-dark.css"; // Choose a style for syntax highlighting
import { useToast } from "primevue/usetoast";
import { useIntervalFn } from "@vueuse/core";
import { useClipboard } from "@vueuse/core";

const toast = useToast();

const props = defineProps({
  code: {
    type: String,
    required: true,
  },
});

const copyToClipboardText = ref("copy");
const copyToClipboard = () => {
  const { copy, isSupported } = useClipboard();

  if (isSupported) {
    copy(props.code);

    toast.add({
      severity: "success",
      summary: "Success",
      detail: "Code copied to clipboard",
      life: 3000,
    });

    // Displaying Copied to clipboard for 3 seconds
    copyToClipboardText.value = "Copied to clipboard";

    useIntervalFn(() => {
      copyToClipboardText.value = "Copy";
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

<style scoped>
.code-snippet {
  position: relative;
  padding: 1em;
  border-radius: 4px;
}

pre {
  margin: 0;
}

.copy-button {
  position: absolute;
  top: 0.5em;
  right: 0.5em;
  background-color: #007bff;
  color: white;
  border: none;
  padding: 0.5em 1em;
  border-radius: 4px;
  cursor: pointer;
}

.copy-button:hover {
  background-color: #0056b3;
}
</style>