<template>
    <Button type="submit" fluid :label="!processing ? buttonText : 'Loading ... '" :loading="processing" />
</template>
<script setup>
import { defineProps } from "vue";

defineProps({
    buttonText: {
        required: true,
        type: String,
    },
    processing: {
        type: Boolean,
        default: false,
    },
});
</script>
<style></style>