<template>
    <div class="flex items-center mb-1 gap-2">
        <div class="mb-2">
            <b :class="`text-${error ? 'danger' : 'dark'}`">{{ label }} <span class="text-danger"
                    v-if="required">*</span>
            </b>
        </div>
        <Rating :stars="stars" :invalid="hasError" :value="modelValue" v-model="model" :class="class" :id="id"
            :required="required" :readonly="readOnly" :disabled="disabled" :size="size" fluid
            :variant="required ? 'filled' : 'outlined'" />
    </div>
</template>

<script setup>
import { defineProps, computed, defineEmits, defineModel } from 'vue';
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

const label = computed(() => {
    return props.field.label ?? null;
});


const stars = computed(() => {
    return props.field.stars ?? 5;
});

</script>
