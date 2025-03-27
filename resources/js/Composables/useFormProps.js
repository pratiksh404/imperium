export function useFormProps() {
    return {
        name: {
            required: true,
            type: String,
          },
          method: {
            required: true,
            type: String,
            default: "post",
          },
          url: {
            required: true,
            type: String,
          },
          formData: {
            type: Object,
            default: () => {},
          },
    };
  }
  