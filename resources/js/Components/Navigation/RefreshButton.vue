<template>
    <div>
        <Button @click="refreshPage" :loading="loading" icon="pi pi-refresh" label="Refresh" />
    </div>
</template>
<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const loading = ref(false);

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
