<template>
    <ColorPicker class="mx-3" v-model="value" disabled />
</template>
<script setup>
import { defineProps, computed } from 'vue';

const props = defineProps({
    field: {
        type: Object,
        required: true
    }
})

const value = computed(() => props.field.value ?? null);
</script>
