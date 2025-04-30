<template>
    <span class="mx-1" v-text="value"></span>
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