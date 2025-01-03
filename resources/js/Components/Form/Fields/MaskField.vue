<template>
    <InputMask type="text" :invalid="hasError" :placeholder="placeholder" :value="modelValue"
        @input="updateValue($event.target.value)" :class="class" :id="id" :required="required" :readonly="readOnly"
        :disabled="disabled" :size="size" fluid :variant="required ? 'filled' : 'outlined'"
        v-bind="{ ...(mask != null ? { mask: mask, } : {}), ...(slotChar != null ? { slotChar: slotChar, } : {}) }" />
</template>

<script setup>
import { defineProps, computed, defineEmits } from 'vue';

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

const mask = computed(() => {
    return props.field.mask ?? null;
})

const slotChar = computed(() => {
    return props.field.slotChar ?? null;
})

const updateValue = (value) => {
    emit('update:modelValue', value);
};
</script>
