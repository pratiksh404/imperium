<template>
    <!-- Breadcrumbs Nav -->
    <nav v-if="breadcrumbs.length" class="dynamic-bg border-b dynamic-border">

        <div class="flex items-center justify-between flex-wrap">
            <div>
                <Breadcrumb :pt="{
                    root: {
                        class: 'p-0 bg-transparent',
                    },
                }" :home="{
                    icon: 'pi pi-home',
                    route: route('welcome'),
                }" :model="breadcrumbs">
                    <template #item="{ item, props }">
                        <Link v-if="item.route" :href="item.route" class="p-breadcrumb-item-link" custom>
                        <span v-show="item.icon" :class="item.icon" class="p-breadcrumb-item-icon" />
                        <span class="p-breadcrumb-item-label">{{ item.label }}</span>
                        </Link>
                        <a v-else :href="item.url" :target="item.target" v-bind="props.action">
                            <span v-show="item.icon" :class="item.icon" class="p-breadcrumb-item-icon" />
                            <span class="p-breadcrumb-item-label">{{ item.label }}</span>
                        </a>
                    </template>
                    <template #separator> / </template>
                </Breadcrumb>
            </div>
            <div>
                <div v-if="$slots.headerEnd" class="py-3">
                    <slot name="headerEnd" />
                </div>
            </div>
        </div>
    </nav>

    <div class="px-8 py-4 md:px-4 lg:px-8" v-if="pageTitle || resourcePoints.length > 0">
        <div class="flex items-start flex-col lg:justify-between lg:flex-row">

            <div class="font-medium text-2xl text-surface-900 dark:text-surface-0">{{ pageTitle }}</div>
            <div class="mt-4 lg:mt-0">
                <div class="flex items-center text-surface-700 dark:text-surface-100 flex-wrap"
                    v-if="resourcePoints.length > 0">
                    <div class="mr-4 flex items-center mt-2" v-for="point in resourcePoints">
                        <i :class="point.icon" class="mr-2" />
                        <span>{{ point.information }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
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
console.log(breadcrumbs.value);
</script>
