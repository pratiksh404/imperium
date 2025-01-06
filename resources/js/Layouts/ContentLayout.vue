<template>
    <!-- Page Header -->
    <header
        class="sticky top-0 z-30 flex h-14 items-center gap-4 border-b bg-background px-4 sm:static sm:h-auto sm:border-0 sm:bg-transparent sm:px-6">
        <Header @open-nav="$emit('open-nav')" :title="title" :nav="nav" />
    </header>

    <!-- Page Content -->
    <section id="page-content" class="grow">
        <slot />
    </section>
</template>
<script setup>
import PageHeader from '@/Layouts/Partials/PageHeader.vue';
import Header from './Partials/Header.vue';

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
