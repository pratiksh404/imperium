<template>
  <div class="hidden sm:block">
    <div class="border-b border-gray-200 dark:border-gray-700">
      <nav
        ref="sortableRoot"
        class="-mb-px flex space-x-4 overflow-x-auto"
        aria-label="Tabs"
      >
        <div
          v-for="tab in tabStore.tabs"
          :key="tab.url"
          :data-id="tab.url"
          class="group inline-flex items-center border-b-2 px-1 py-4 text-sm font-medium whitespace-nowrap cursor-pointer"
          :class="[
            isActive(tab.url)
              ? 'border-indigo-500 text-indigo-600 dark:text-white'
              : 'border-transparent text-gray-700 dark:text-gray-200 hover:border-black dark:hover:border-white hover:text-black dark:hover:text-white',
          ]"
          @click.prevent="switchTab(tab.url)"
        >
          <span>{{ tab.label }}</span>
          <XMarkIcon
            class="ml-2 size-4 text-gray-400 hover:text-red-500"
            @click.stop="tabStore.closeTab(tab.url)"
          />
        </div>
      </nav>
    </div>
  </div>
</template>

<script setup>
import { XMarkIcon } from "@heroicons/vue/24/outline";
import { useMenuTabStore } from "@/Imperium/Store/menu_tabs";
import { router, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { useSortable } from "@vueuse/integrations/useSortable";

const tabStore = useMenuTabStore();
const sortableRoot = ref();

const switchTab = (url) => {
  tabStore.setActive(url);
  router.visit(url, {
    preserveState: true,
    preserveScroll: true,
  });
};

const isActive = (url) => tabStore.activeTab === url;

// Hook up useSortable
useSortable(sortableRoot, tabStore.tabs, {
  animation: 150,
  ghostClass: "drag-ghost", // ✅ only a single class
});
</script>

<style>
.drag-ghost {
  background-color: #e5e7eb; /* gray-200 */
  opacity: 0.7;
}
</style>
