<template>
  <nav class="flex" aria-label="Breadcrumb">
    <ol role="list" class="flex items-center space-x-4">
      <li>
        <div>
          <Link
            :href="route('dashboard')"
            class="text-gray-400 hover:text-gray-500"
          >
            <HomeIcon class="size-5 shrink-0" aria-hidden="true" />
            <span class="sr-only">Home</span>
          </Link>
        </div>
      </li>
      <li v-for="(navItem, index) in navItems" :key="'breadcrumb-' + index">
        <div class="flex items-center">
          <ChevronRightIcon
            class="size-5 shrink-0 text-gray-400"
            aria-hidden="true"
          />
          <Link
            v-if="navItem.route"
            :href="navItem.route"
            class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"
            :aria-current="navItem.active ? 'page' : undefined"
            >{{ navItem.label }}</Link
          >
          <div class="flex items-center" v-else>
            <ChevronRightIcon
              class="size-5 shrink-0 text-gray-400"
              aria-hidden="true"
            />
            <span
              class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"
            >
              {{ navItem.label }}
            </span>
          </div>
        </div>
      </li>
    </ol>
  </nav>
</template>
  
  <script setup>
import { ChevronRightIcon, HomeIcon } from "@heroicons/vue/20/solid";
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { defineProps } from "vue";

const props = defineProps({
  nav: {
    type: Array,
    required: false,
    default: () => [],
  },
});

const header = computed(() => usePage().props.header);
const breadcrumb = computed(() => header.value?.breadcrumb ?? null);
const breadcrumbItems = computed(() => breadcrumb.value?.items ?? []);

const navItems = computed(() =>
  props.nav.length > 0 ? props.nav : breadcrumbItems.value
);
</script>