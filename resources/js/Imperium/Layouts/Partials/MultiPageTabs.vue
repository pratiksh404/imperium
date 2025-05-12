<template>
  <div class="hidden sm:block">
    <div class="border-b border-gray-200 dark:border-gray-700">
      <nav class="-mb-px flex space-x-4 overflow-x-auto" aria-label="Tabs">
        <a
          v-for="tab in tabStore.tabs"
          :key="tab.url"
          href="#"
          @click.prevent="switchTab(tab.url)"
          :class="[
            'group inline-flex items-center border-b-2 px-1 py-4 text-sm font-medium whitespace-nowrap',
            isActive(tab.url)
              ? 'border-indigo-500 text-indigo-600 dark:text-white'
              : 'border-transparent text-gray-700 dark:text-gray-200 hover:border-black dark:hover:border-white hover:text-black dark:hover:text-white',
          ]"
        >
          <span>{{ tab.label }}</span>
          <XMarkIcon
            class="ml-2 size-4 text-gray-400 hover:text-red-500"
            @click.stop="tabStore.closeTab(tab.url)"
          />
        </a>
      </nav>
    </div>
  </div>
</template>

<script setup>
import { XMarkIcon } from "@heroicons/vue/24/outline";
import { useMenuTabStore } from "@/Imperium/Store/menu_tabs";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";

const tabStore = useMenuTabStore();
const page = usePage();

const switchTab = (url) => {
  tabStore.setActive(url);
  router.visit(url, {
    preserveState: true,
    preserveScroll: true,
  });
};

console.log(tabStore.tabs.length);

const isActive = (url) => tabStore.activeTab === url;
</script>
