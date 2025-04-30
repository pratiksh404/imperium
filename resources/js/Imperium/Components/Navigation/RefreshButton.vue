<template>
    <div>
        <Button :rounded="rounded" @click="refreshPage" :loading="loading" icon="pi pi-refresh"
            v-tooltip.left="'Refresh Page'" size="small" />
    </div>
</template>
<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const loading = ref(false);

const props = defineProps({
    rounded: {
        required: false,
        default: false,
        type: Boolean
    }
});

const refreshPage = () => {
    loading.value = true;
    router.reload({
        preserveState: true,
        onFinish: () => {
            loading.value = false;
        }
    });
};
</script>
