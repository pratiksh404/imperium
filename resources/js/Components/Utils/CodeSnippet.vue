<template>
    <div class="code-snippet">
        <highlightjs language="php" :code="code" />
        <button @click="copyToClipboard" class="copy-button">Copy</button>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import Clipboard from 'clipboard';
import 'highlight.js/styles/github-dark.css'; // Choose a style for syntax highlighting
import { useToast } from "primevue/usetoast";


const toast = useToast();

const props = defineProps({
    code: {
        type: String,
        required: true,
    },
});
const copyToClipboard = () => {
    const clipboard = new Clipboard('.copy-button', {
        text: () => props.code,
    });

    clipboard.on('success', () => {
        toast.add({
            severity: 'success',
            summary: 'Success',
            detail: 'Code copied to clipboard',
            life: 3000
        })
        clipboard.destroy(); // Clean up the clipboard instance
    });

    clipboard.on('error', () => {
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Failed to copy code',
            life: 3000
        })
        alert('Failed to copy code.');
        clipboard.destroy(); // Clean up the clipboard instance
    });
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