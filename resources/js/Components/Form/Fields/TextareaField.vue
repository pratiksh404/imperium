<template>
    <Textarea :autoResize="autoResize" :rows="rows" :cols="cols" :invalid="hasError" :placeholder="placeholder"
        :value="modelValue" v-model="model" :class="class" :id="id" :required="required" :readonly="readOnly"
        :disabled="disabled" :size="size" fluid :variant="required ? 'filled' : 'outlined'" />
</template>

<script setup>
import { defineProps, computed, defineEmits } from 'vue';
const model = defineModel();
const props = defineProps({
    modelValue: {
        type: String,
        default: null,
    },
    placeholder: { type: String, default: '' },
    required: { type: Boolean, default: false },
    readOnly: { type: Boolean, default: false },
    disabled: { type: Boolean, default: false },
    class: { type: String },
    id: { type: String, default: () => `input-${Math.random().toString(36).substr(2, 9)}` },
    size: { type: String, default: null },
    error: { type: String, default: null },
    field: { type: Object, default: () => ({}) },
});

const emit = defineEmits(['update:modelValue']);

const hasError = computed(() => !!props.error);

const autoResize = computed(() => {
    return props.field.autoResize ?? true;
});

const rows = computed(() => {
    return props.field.rows ?? 5;
});

const cols = computed(() => {
    return props.field.cols ?? 30;
});

const updateValue = (value) => {
    emit('update:modelValue', value);
};
</script>
