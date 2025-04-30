import { ref, computed } from "vue";
import axios from "axios";
import { useToast } from "primevue/usetoast"; // PrimeVue toast

export function useServerAction() {
    const data = ref(null);
    const error = ref(null);
    const loading = ref(false);
    const toast = useToast(); // PrimeVue toast instance

    // Axios instance (optional: set headers, auth, etc.)
    const api = axios.create({
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
        },
    });

    // Computed property to get server action endpoint
    const serverActionRoute = computed(() => route('imperium.action'));

    // Helper function to handle responses
    const handleResponse = (response) => {
        if (response.data.status) {
            return response.data.data;
        } else {
            throw new Error(response.data.message || "Unknown error");
        }
    };

    // API request method with success/error handling
    const serverAction = async (payload, { onSuccess, onError } = {}) => {
        loading.value = true;
        error.value = null;

        try {
            const response = await api.post(serverActionRoute.value, payload);
            data.value = handleResponse(response);
            let summary = "Action Executed";
            let detail = response.data?.message || "Action successful!";
            // ✅ Default Success Toast
            toast.add({
                severity: "success",
                summary: summary,
                detail: detail,
                life: 3000,
            });

            // ✅ Execute custom onSuccess callback if provided
            if (onSuccess) {
                onSuccess(data.value);
            }
        } catch (err) {
            console.error(err);
            let summary = err.message;
            let detail =  err.response?.data.message || "Unknown error";

            // ❌ Default Error Toast
            toast.add({
                severity: "error",
                summary: summary,
                detail: detail,
            });

            // ❌ Execute custom onError callback if provided
            if (onError) {
                onError(error.value);
            }
        } finally {
            loading.value = false;
        }
    };

    return { data, error, loading, serverAction };
}
