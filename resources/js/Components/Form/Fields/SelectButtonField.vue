<template>
    <SelectButton :options="options" optionLabel="label" :multiple="multiple" :invalid="hasError"
        :placeholder="placeholder" :value="modelValue" v-model="model" :class="class" :id="id" :required="required"
        :readonly="readOnly" :disabled="disabled" :size="size" fluid :variant="required ? 'filled' : 'outlined'">
        <template #option="slotProps">
            <img v-if="slotProps.option.image" :alt="slotProps.option.label" :src="slotProps.option.image"
                style="width: 18px" />
            <i v-else-if="slotProps.option.icon" :class="slotProps.option.icon"></i>
            <span v-else>{{ slotProps.option.label }}</span>
        </template>
    </SelectButton>
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

const options = computed(() => {
    if (props.field.options) {
        return props.field.options;
    }
    return [];
});

const label = computed(() => {
    return props.field.label ?? null;
});

const multiple = computed(() => {
    return props.field.multiple ?? false;
})

const updateValue = (value) => {
    emit('update:modelValue', value);
};
</script>
