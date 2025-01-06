<template>
    <!-- Page Header -->
    <header
        class="sticky top-0 z-30 flex h-14 items-center gap-4 border-b px-4 sm:static sm:h-auto sm:border-0 sm:px-6 ">
        <Header :title="title" :nav="nav" />
    </header>

    <!-- Page Content -->
    <section id="page-content" class="grow p-4">
        <slot />
    </section>
</template>
<script setup>
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
