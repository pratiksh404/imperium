import { ref } from "vue";
import axios from "axios";
import { router } from '@inertiajs/vue3'

export function useServerRequest(toast) {
    const data = ref(null);
    const error = ref(null);
    const loading = ref(false);

    const api = axios.create({
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
        },
    });

    const handleResponse = (response) => {
        if (response.data?.success) {
            return response.data;
        } else {
            throw new Error(response.data?.message || "Unknown error");
        }
    };

    const serverRequest = async (
        promiseOrFn,
        {
            onSuccess,
            onError,
            toastSuccess = true,
            toastError = true,
            redirectTo,
        } = {}
    ) => {
        loading.value = true;
        error.value = null;

        try {
            const finalRedirectTo = redirectTo || route().current();
            const promise = typeof promiseOrFn === "function" ? promiseOrFn(api) : promiseOrFn;
            const response = await promise;
            const responseData = handleResponse(response);
            data.value = responseData;

            if (toastSuccess && toast) {
                toast.add({
                    severity: "success",
                    summary: "Success",
                    detail: responseData.message || "Action completed successfully",
                    life: 3000,
                });
            }

            if (responseData.redirect) {
                const inertiaOptions = {
                    preserveScroll: true,
                    preserveState: true,
                    replace: false,
                    ...(responseData.inertia || {}),
                };

                router.visit(responseData.redirect, inertiaOptions);
            } else if (responseData.redirect === undefined) {
                router.visit(finalRedirectTo, {
                    preserveScroll: true,
                    preserveState: true,
                    replace: false,
                });
            }

            if (onSuccess) {
                onSuccess(responseData);
            }
        } catch (err) {
            console.error(err);
            error.value = err;

            if (toastError && toast) {
                toast.add({
                    severity: "error",
                    summary: "Error",
                    detail: err.response?.data?.message || err.message || "Something went wrong",
                    life: 3000,
                });
            }

            if (onError) {
                onError(err);
            }
        } finally {
            loading.value = false;
        }
    };

    const index = (url, config = {}) => serverRequest(() => api.get(url, config));
    const show = (url, config = {}) => serverRequest(() => api.get(url, config));
    const store = (url, payload, config = {}) => serverRequest(() => api.post(url, payload, config));
    const update = (url, payload, config = {}) => serverRequest(() => api.put(url, payload, config));
    const destroy = (url, config = {}) => serverRequest(() => api.destroy(url, config));

    const post = (url, payload, config = {}) => serverRequest(() => api.post(url, payload, config));
    const put = (url, payload, config = {}) => serverRequest(() => api.put(url, payload, config));
    const patch = (url, payload, config = {}) => serverRequest(() => api.patch(url, payload, config));
    const get = (url, config = {}) => serverRequest(() => api.get(url, config));
    return {
        data,
        error,
        loading,
        serverRequest,
        index,
        show,
        store,
        update,
        destroy,
        api,
        post,
        put,
        patch,
        get,
    };
}
