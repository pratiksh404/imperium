<template>

    <div v-if="Object.keys(options).length > 0" style="overflow-x: auto;">
        <b :class="`text-${error ? 'danger' : 'dark'}`">{{ label }} <span class="text-danger"
                v-if="required">*</span></b>
        <div class="flex flex-wrap justify-center gap-4">
            <div v-for="(option, key) in options" :key="'checkbox-' + key" class="flex items-center mb-1 gap-2">
                <Checkbox v-model="model" :invalid="hasError" :value="option.value" />
                <span class="mx-2" :class="`text-${error ? 'danger' : 'dark'}`">{{ option.label }}</span>
            </div>
        </div>
    </div>
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

const label = computed(() => {
    return props.field.label ?? null;
});

const options = computed(() => {
    return props.field.options ?? {};
})

</script>
