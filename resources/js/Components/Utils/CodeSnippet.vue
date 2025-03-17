<template>
  <div class="code-snippet h-full">
    <highlightjs language="php" :code="code" />
    <button @click="copyToClipboard" class="copy-button">
      {{ copyToClipboardText }}
    </button>
    <div class="copy-button">
      <CopyToClipboard :copyText="code" />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import "highlight.js/styles/github-dark.css"; // Choose a style for syntax highlighting
import CopyToClipboard from "./CopyToClipboard.vue";

const props = defineProps({
  code: {
    type: String,
    required: true,
  },
});
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
}
</style>