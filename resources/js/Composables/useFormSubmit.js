import { useToast } from "primevue/usetoast";
import { useEventsStore } from "@/Store/events";

export function useFormSubmit(form,props) {
    const toast = useToast();
  const eventsStore = useEventsStore();

  const submit = () => {
    form[props.method](props.url, {
      preserveScroll: true,
      onSuccess: () => {
        toast.add({
          severity: "success",
          summary: "Success",
          detail: props.name + " saved successfully",
          life: 3000,
        });
        form.reset();
        eventsStore.triggerFormSuccess();
      },
      onError: (errors) => {
        if (Object.keys(errors).length > 0) {
          Object.values(errors).forEach((error) => {
            toast.add({
              severity: "error",
              summary: "Error",
              detail: error,
              life: 5000,
            });
          });
        } else {
          toast.add({
            severity: "error",
            summary: "Error",
            detail: "Something went wrong",
            life: 3000,
          });
        }
      },
    });
  };

  return {
    submit,
  };
}