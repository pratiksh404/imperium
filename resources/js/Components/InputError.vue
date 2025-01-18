<script setup>
defineProps({
    error: {
        type: String,
    },
});
</script>

<template>
    <Message v-if="error" v-for="err in error.split(',')" severity="error" variant="simple" class="p-1">
        <span style="font-size: 12px;"><i class="pi pi-exclamation-triangle mr-2 mt-1"></i> {{ err }}</span>
    </Message>
</template>
