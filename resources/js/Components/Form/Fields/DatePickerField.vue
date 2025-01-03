<template>
    <DatePicker :invalid="hasError" :dateFormat="format" showIcon :showOnFocus="showOnFocus"
        v-bind="{ ...(iconDisplay ? { iconDisplay: 'input' } : {}), ...(minDate ? { minDate: minDate } : {}), ...(maxDate ? { maxDate: maxDate } : {}), ...(selectionMode ? { selectionMode: selectionMode } : {}), ...(hourFormat ? { hourFormat: hourFormat } : {}), ...(view ? { view: view } : {}) }"
        :showButtonBar="showButtonBar" :manualInput="manualInput" :showTime="showTime" :timeOnly="timeOnly"
        :numberOfMonths="numberOfMonths" :inline="inline" :value="modelValue" v-model="model" :class="class" :id="id"
        :required="required" :readonly="readOnly" :disabled="disabled" :size="size" fluid
        :variant="required ? 'filled' : 'outlined'">
        <template v-if="timeOnly" #inputicon="slotProps">
            <i class="pi pi-clock" @click="slotProps.clickCallback" />
        </template>
    </DatePicker>
</template>

<script setup>
import { defineProps, computed, defineEmits, defineModel } from 'vue';
const model = defineModel({
    default: true
});
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

const format = computed(() => {
    return props.field.format ?? 'yy-mm-dd';
});

const showOnFocus = computed(() => {
    return props.field.showOnFocus ?? true;
});


const iconDisplay = computed(() => {
    return props.field.iconDisplay ?? true;
});

const minDate = computed(() => {
    const min = props.field.minDate ?? null;
    return min ? new Date(min) : null;
});

const maxDate = computed(() => {
    const max = props.field.maxDate ?? null;
    return max ? new Date(max) : null;
});

const showButtonBar = computed(() => {
    return props.field.showButtonBar ?? false;
});

const hourFormat = computed(() => {
    return props.field.hourFormat ?? 12;
});

const timeOnly = computed(() => {
    return props.field.timeOnly ?? false;
});

const view = computed(() => {
    return props.field.view ?? null;
});

const selectionMode = computed(() => {
    return props.field.selectionMode ?? null;
});

const inline = computed(() => {
    return props.field.inline ?? false;
});

const numberOfMonths = computed(() => {
    return props.field.numberOfMonths ?? 1;
});

const manualInput = computed(() => {
    return props.field.manualInput ?? false;
});

const showTime = computed(() => {
    return props.field.showTime ?? false;
});

const updateValue = (value) => {
    emit('update:modelValue', value);
};
</script>
