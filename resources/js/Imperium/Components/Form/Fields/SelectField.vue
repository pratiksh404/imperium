<template>
  <component
    :is="selectComponent"
    v-if="options.length > 0"
    :invalid="hasError"
    :placeholder="placeholder"
    :value="modelValue"
    :options="options"
    optionLabel="label"
    optionValue="value"
    v-bind="{
      ...(hasItemsField
        ? {
            optionGroupLabel: 'label',
            optionGroupChildren: 'items',
            optionGroupValue: 'value',
          }
        : {}),
      ...(multiple ? { display: 'chip' } : {}),
    }"
    :checkmark="checkmark"
    :highlightOnSelect="highlightOnSelect"
    :showClear="showClear"
    :filter="searchable"
    v-model="model"
    :class="class"
    :id="id"
    :required="required"
    :readonly="readOnly"
    :disabled="disabled"
    :size="size"
    fluid
    :variant="required ? 'filled' : 'outlined'"
  >
    <template v-if="dropdownIcon" #dropdownicon>
      <i :class="dropdownIcon" />
    </template>
    <template v-if="header" #header>
      <div class="font-medium p-3">{{ header }}</div>
    </template>
    <template #optiongroup="slotProps">
      <div class="d-flex justify-content-start gap-2">
        <img
          v-if="slotProps.option.image"
          :alt="slotProps.option.label"
          :src="slotProps.option.image"
          style="width: 18px"
        />
        <i v-else-if="slotProps.option.icon" :class="slotProps.option.icon"></i>
        <div>{{ slotProps.option.label }}</div>
      </div>
    </template>
    <template #option="slotProps">
      <div class="d-flex justify-content-start gap-2">
        <img
          v-if="slotProps.option.image"
          :alt="slotProps.option.label"
          :src="slotProps.option.image"
          style="width: 18px"
        />
        <i v-else-if="slotProps.option.icon" :class="slotProps.option.icon"></i>
        <div>{{ slotProps.option.label }}</div>
      </div>
    </template>
  </component>
  <Message v-else severity="error" fluid>Select options are empty</Message>
</template>

<script setup>
import { defineProps, computed, defineEmits } from "vue";
import { resolveFieldComponent } from "@/Imperium/Utils/Resource/FormComponentMapper";

const model = defineModel();

const props = defineProps({
  modelValue: {
    type: String,
    default: null,
  },
  placeholder: { type: String, default: "" },
  required: { type: Boolean, default: false },
  readOnly: { type: Boolean, default: false },
  disabled: { type: Boolean, default: false },
  class: { type: String },
  id: {
    type: String,
    default: () => `input-${Math.random().toString(36).substr(2, 9)}`,
  },
  size: { type: String, default: null },
  error: { type: String, default: null },
  field: { type: Object, default: () => ({}) },
});

const options = computed(() => {
  if (props.field.options) {
    return props.field.options;
  }
  return [];
});

const checkmark = computed(() => {
  return props.field.checkmark ?? true;
});

const highlightOnSelect = computed(() => {
  return props.field.highlightOnSelect ?? false;
});

const showClear = computed(() => {
  return props.field.showClear ?? true;
});

const searchable = computed(() => {
  return props.field.searchable ?? true;
});

const dropdownIcon = computed(() => {
  return props.field.dropdownIcon ?? null;
});

const header = computed(() => {
  return props.field.header ?? null;
});

const multiple = computed(() => {
  return props.field.multiple ?? false;
});

const selectComponent = computed(() => {
  const isMultiple = multiple.value ?? false;
  return isMultiple
    ? resolveFieldComponent("primeMultiSelect")
    : resolveFieldComponent("primeSelect");
});

const hasItemsField = computed(() =>
  options.value.some(
    (item) => Array.isArray(item.items) && item.items.length > 0
  )
);

const emit = defineEmits(["update:modelValue"]);

const hasError = computed(() => !!props.error);
</script>
