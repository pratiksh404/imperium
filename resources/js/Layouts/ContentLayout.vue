<template>
    <!-- Page Header -->
    <PageHeader :title="title" :nav="nav" />
    <!-- Page Content -->
    <section id="page-content" class="grow">
        <slot />
    </section>
</template>
<script setup>
import PageHeader from '@/Layouts/Partials/PageHeader.vue';

const props = defineProps({
    title: {
        type: String,
        required: false,
    },
    nav: {
        type: Array,
        required: false,
        default: () => [],
    },
});

</script>
