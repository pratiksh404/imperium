<template>
    <!-- Page Header -->
    <PageHeader :page-title="pageTitle" :breadcrumbs="breadcrumbs" />
    <!-- Page Content -->
    <section id="page-content" class="grow">
        <slot />
    </section>
</template>
<script setup>
import PageHeader from '@/Layouts/Partials/PageHeader.vue';

const props = defineProps({
    pageTitle: {
        type: String,
        required: false,
    },
    breadcrumbs: {
        type: Array,
        required: false,
        default: () => [],
    },
});

</script>
