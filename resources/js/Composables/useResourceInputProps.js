export function useResourceInputProps() {
    return {
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
    };
  }
  