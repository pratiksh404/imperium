<template>
    <div class="flex items-center mb-1 gap-2">
        <div class="mb-2">
            <b :class="`text-${error ? 'danger' : 'dark'}`">{{ label }} <span class="text-danger"
                    v-if="required">*</span>
            </b>
        </div>
        <InputOtp :invalid="hasError" :length="length" :mask="masked" :integerOnly="integerOnly" :value="modelValue"
            @input="updateValue($event.target.value)" :class="class" :id="id" :required="required" :readonly="readOnly"
            :disabled="disabled" :size="size" :variant="required ? 'filled' : 'outlined'" />
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

const length = computed(() => {
    return props.field.length ?? 4;
});

const masked = computed(() => {
    return props.field.masked ?? false;
});

const integerOnly = computed(() => {
    return props.field.integerOnly ?? false;
});

const updateValue = (value) => {
    emit('update:modelValue', value);
};
</script>
