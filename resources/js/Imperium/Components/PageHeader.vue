<template>
  <div class="flex items-center justify-between">
    <div class="min-w-0 flex-1">
      <h2 class="p-3 text-4xl font-bold leading-7 text-dark dark:text-light sm:truncate sm:text-3xl sm:tracking-tight">
        {{ pageTitle }}
      </h2>
      <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6" v-if="headerPoints.length > 0">
        <div class="p-2 mt-2 flex items-center text-sm text-gray-500 dark:text-light"
          v-for="(point, index) in headerPoints" :key="'page-header-point-' + index">
          <i :class="point.icon" class="mr-1.5 flex-shrink-0 text-gray-500" aria-hidden="true" />
          {{ point.information }}
        </div>
      </div>
    </div>
    <div class="mt-5 flex lg:ml-4 lg:mt-0 mb-1">
      <slot name="actions"></slot>
    </div>
  </div>
</template>
<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
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
  header: {
    type: Object,
    required: false,
    default: () => usePage().props.header,
  },
});

const headerTitle = computed(() => props.header?.title ?? null);
const headerPoints = computed(() => props.header?.points ?? []);

const pageTitle = computed(() => props.title ?? headerTitle.value ?? null);
</script>
