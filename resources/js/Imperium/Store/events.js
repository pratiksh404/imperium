import { defineStore } from "pinia";
export const useEventsStore = defineStore("events", {
    state: () => ({
        formSuccess: false, // Tracks if the form was successfully submitted
    }),
    actions: {
        triggerFormSuccess() {
            this.formSuccess = true;
        },
        resetFormStatus() {
            this.formSuccess = false;
        },
    },
})