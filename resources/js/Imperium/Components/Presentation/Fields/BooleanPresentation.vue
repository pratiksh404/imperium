<template>
    <Tag class="mx-3" v-if="value === null" icon="pi pi-exclamation-triangle" severity="warn" value="Warn"></Tag>
    <Tag class="mx-3" v-else :value="value" :icon="value === 'True' ? 'pi pi-check' : 'pi pi-times'"
        :severity="value === 'True' ? 'success' : 'danger'"></Tag>
</template>
<script setup>
import { defineProps, computed } from 'vue';

const props = defineProps({
    field: {
        type: Object,
        required: true
    }
})

const value = computed(() => {
    const val = props.field.value ?? null;
    return typeof val === 'boolean' ? val ? 'True' : 'False' : null;
});
</script>