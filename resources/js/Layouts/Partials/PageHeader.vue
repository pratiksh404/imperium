<template>
    <div class="px-4 pb-4 w-full">
        <div class="flex items-start flex-col lg:justify-between lg:flex-row">
            <div>
                <div class="font-medium text-3xl text-surface-900 dark:text-surface-0" v-if="pageTitle">
                    {{ pageTitle }}
                </div>
                <div class="flex items-center text-surface-700 dark:text-surface-100 flex-wrap"
                    v-if="resourcePoints.length > 0">
                    <div class="mr-8 flex items-center mt-4" v-for="(point, index) in resourcePoints"
                        :key="'page-header-point-' + index">
                        <i :class="point.icon" class="mr-2" />
                        <span>{{ point.information }}</span>
                    </div>
                </div>
            </div>
            <div class="mt-8 lg:mt-0" :class="{ 'pt-4': resourcePoints.length > 0 }">
                <slot name="actions"></slot>
            </div>
        </div>
    </div>
</template>
<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
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

const breadcrumb = computed(() => usePage().props.breadcrumb);
const resourceTitle = computed(() => breadcrumb.value?.title ?? '');
const resourceItems = computed(() => breadcrumb.value?.items ?? []);
const resourcePoints = computed(() => breadcrumb.value?.points ?? []);

const pageTitle = computed(() => props.title ?? resourceTitle.value ?? null);
const breadcrumbs = computed(() => props.nav.length > 0 ? props.nav : resourceItems.value);

</script>
