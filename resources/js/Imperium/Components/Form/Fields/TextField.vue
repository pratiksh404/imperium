<template>
  <InputText
    type="text"
    :invalid="hasError"
    :placeholder="getProp('placeholder')"
    :value="modelValue"
    v-model="model"
    :class="getProp('class')"
    :id="getProp('id')"
    :required="getProp('required')"
    :readonly="getProp('readOnly')"
    :disabled="getProp('disabled')"
    :size="getProp('size')"
    fluid
    :variant="getProp('required') ? 'filled' : 'outlined'"
  />
</template>

<script setup>
import { defineProps, defineModel, defineEmits } from "vue";
import { useResourceInput } from "@/Imperium/Composables/useResourceInput";
import { useResourceInputProps } from "@/Imperium/Composables/useResourceInputProps";

const model = defineModel();

const emit = defineEmits(["update:modelValue"]);

const props = defineProps({
  ...useResourceInputProps(),
});

const { modelValue, hasError, updateValue, getProp } = useResourceInput(props);
</script>
