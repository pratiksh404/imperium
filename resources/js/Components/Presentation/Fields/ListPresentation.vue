<template>
    <ul v-if="list.length > 0" class="list-group list-group-flush">
        <li v-for="item in list" class="list-group-item">{{ item.label }}</li>
    </ul>
</template>
<script setup>
import { defineProps, computed } from 'vue';

const props = defineProps({
    field: {
        type: Object,
        required: true
    }
})

const list = computed(() => {
    const options = props.field.options ?? [];
    const values = props.field.value ?? [];
    // Check If values is array/object
    if (typeof data === "object") {
        return options.filter(option => values.includes(option.value));
    }
    return {
        ...options.filter(option => option.value === values)
    };
});
</script>
