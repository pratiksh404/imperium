import { useForm as inertiaUseForm } from "@inertiajs/vue3";
import { useForm as precognitionUseForm } from "laravel-precognition-vue-inertia";

export function useDynamicForm(precognitionEnabled = false) {
    return precognitionEnabled ? precognitionUseForm : inertiaUseForm;
}
