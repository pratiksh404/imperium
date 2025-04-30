import { computed } from "vue";

export function useResourceInput(props) {

  const modelValue = computed({
    get: () => props.modelValue || props.field?.default,
    set: (value) => updateValue(value),
  });

  const hasError = computed(() => !!props.error);

  const getProp = (propName) => {
    return (computed(() => props[propName] ?? props.field?.[propName] ?? null)).value;
  };

  const updateValue = (value) => {
    emit("update:modelValue", value);
  };

  return {
    modelValue,
    hasError,
    updateValue,
    getProp, // Function to dynamically access properties
  };
}
