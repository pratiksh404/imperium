<template>
    <div class="d-flex justify-content-between mb-1 gap-2" style="width: 100%;">
        <b :class="`text-${error ? 'danger' : 'dark'}`" class="mt-2">{{ label }} <span class="text-danger"
                v-if="required">*</span>
        </b>
        <ToggleButton :onLabel="onLabel" :offLabel="offLabel" v-bind="{ ...(hideIcon ? {} : { onIcon, offIcon }) }"
            :modelValue="modelValue" @update:modelValue="updateValue" :invalid="hasError" :value="modelValue"
            @input="updateValue($event.target.value)" :class="class" :id="id" :required="required" :readonly="readOnly"
            :disabled="disabled" :size="size" fluid :variant="required ? 'filled' : 'outlined'" />
    </div>
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

const label = computed(() => {
    return props.field.label ?? null;
});

const onLabel = computed(() => {
    return props.field.onLabel ?? 'On';
});

const offLabel = computed(() => {
    return props.field.offLabel ?? 'Off';
});

const onIcon = computed(() => {
    return props.field.onIcon ?? 'pi pi-check';
});

const offIcon = computed(() => {
    return props.field.offIcon ?? 'pi pi-times';
});

const hideIcon = computed(() => {
    return props.field.hideIcon ?? false;
});

const updateValue = (value) => {
    emit('update:modelValue', value);
};
</script>
