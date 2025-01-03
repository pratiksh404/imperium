<template>
    <InputNumber :invalid="hasError" :placeholder="placeholder" :value="modelValue"
        @input="updateValue($event.target.value)" :class="class" :id="id" :required="required" :readonly="readOnly"
        :disabled="disabled" :size="size" fluid :variant="required ? 'filled' : 'outlined'" :useGrouping="withGrouping"
        :min="min" :max="max" :minFractionDigits="minFractionDigits" :maxFractionDigits="maxFractionDigits"
        :prefix="prefixForNumber" :suffix="suffixForNumber"
        v-bind="{ ...(currency !== null ? { currency: currency, mode: 'currency' } : {}), ...(stepperLayout ? { buttonLayout: stepperLayout } : {}) }"
        :showButtons="stepper" :step="step" />
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

const withGrouping = computed(() => {
    return props.field.withGrouping ?? false;
});

const min = computed(() => {
    return props.field.min ?? 0;
});

const max = computed(() => {
    return props.field.max ?? null;
});

const minFractionDigits = computed(() => {
    return props.field.minFractionDigits ?? 2;
});

const maxFractionDigits = computed(() => {
    return props.field.maxFractionDigits ?? 4;
});

const prefixForNumber = computed(() => {
    return props.field.prefixForNumber ?? null;
});

const suffixForNumber = computed(() => {
    return props.field.suffixForNumber ?? null;
});

const currency = computed(() => {
    return props.field.currency ?? null;
});

const stepper = computed(() => {
    return props.field.stepper ?? false;
});

const stepperLayout = computed(() => {
    return props.field.stepperLayout ?? null;
});

const step = computed(() => {
    return props.field.step ?? 1;
});


console.log(suffixForNumber.value)
const updateValue = (value) => {
    emit('update:modelValue', value);
};
</script>