<template>
    <div class="d-flex justify-content-start mx-2">
        <i v-for="i in stars" :key="i" :class="value >= i ? 'pi-star-fill' : 'pi-star'"></i>
    </div>
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

const stars = computed(() => {
    return props.field.stars ?? 5;
})
</script>
