<template>
    <!-- Breadcrumbs Nav -->
    <nav v-if="breadcrumbs.length" class="dynamic-bg border-b dynamic-border">
        <Container :fluid="true">
            <div class="flex items-center justify-between flex-wrap">
                <div>
                    <LinksBreadcrumb :model="breadcrumbs" class="py-3 lg:py-5" />
                </div>
                <div>
                    <div v-if="$slots.headerEnd" class="py-3">
                        <slot name="headerEnd" />
                    </div>
                </div>
            </div>
        </Container>
    </nav>

    <!-- Page Title -->
    <section v-if="pageTitle">
        <Container :fluid="true" class="my-4 md:mt-8 md:mb-6">
            <div class="flex items-end justify-between flex-wrap">
                <div>
                    <h1 class="font-bold text-2xl md:text-3xl leading-tight">
                        {{ pageTitle }}
                    </h1>
                </div>
                <div>
                    <div v-if="$slots.titleEnd">
                        <slot name="titleEnd" />
                    </div>
                </div>
            </div>
        </Container>
    </section>

    <!-- Page Content -->
    <section id="page-content" class="grow">
        <slot />
    </section>
</template>
<script setup>
import LinksBreadcrumb from '@/Components/PrimeVue/LinksBreadcrumb.vue';
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
console.log(props);
</script>
