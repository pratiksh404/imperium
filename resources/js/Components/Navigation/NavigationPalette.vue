<template>
  <div class="hidden md:block">
    <!-- Button to trigger the command palette -->
    <Button
      @click="openDialog = true"
      icon="pi pi-compass"
      iconPos="left"
      label="⌘ + K"
      size="small"
    />
    <!-- Command Palette Dialog -->
    <Dialog
      v-model:visible="openDialog"
      header="Command Palette"
      :modal="true"
      :closable="true"
      position="top"
      @hide="clearSearch"
      :pt="{
        root: {
          class: 'w-3/4 md:w-1/3',
        },
      }"
    >
      <!-- Search Input -->
      <div class="flex items-center gap-2 bg-gray-100 p-2 rounded">
        <!-- Navigate icon svg -->
        <i class="pi pi-compass text-gray-500"></i>
        <input
          type="text"
          v-model="searchQuery"
          placeholder="Search for a route..."
          @input="filterRoutes"
          class="bg-transparent outline-none w-full text-gray-700 placeholder-gray-400"
          @keydown.up.prevent="highlightPrevious"
          @keydown.down.prevent="highlightNext"
          @keydown.enter.prevent="selectRoute"
          autofocus
        />
      </div>

      <!-- Filtered Routes -->
      <ul v-if="filteredRoutes.length" class="mt-4 max-h-48 overflow-y-auto">
        <template v-for="(route, index) in filteredRoutes" :key="index">
          <li
            v-if="route.authorize"
            @mouseover="selectedIndex = index"
            @click="navigateTo(route.url)"
            :class="{
              'bg-black text-white': selectedIndex === index,
              'hover:bg-black hover:text-white': selectedIndex !== index,
            }"
            class="py-2 px-4 rounded cursor-pointer transition"
          >
            {{ route.label }}
          </li>
        </template>
      </ul>

      <ul v-else-if="recentRoutes.length" class="mt-4 max-h-48 overflow-y-auto">
        <li
          v-for="(route, index) in recentRoutes"
          :key="index"
          @mouseover="selectedIndex = index"
          @click="navigateTo(route.url)"
          :class="{
            'bg-black text-white': selectedIndex === index,
            'hover:bg-black hover:text-white': selectedIndex !== index,
          }"
          class="py-2 px-4 rounded cursor-pointer transition"
        >
          <i class="pi pi-history mr-2"></i> {{ route.label }}
        </li>
      </ul>

      <!-- No Results Found -->
      <div v-else class="mt-4 text-gray-500 text-center">No routes found.</div>
    </Dialog>
  </div>
</template>

<script setup>
import { computed, ref, watch } from "vue";
import { useShortcut } from "@/Composables/shortcut";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";

const page = usePage();

const menu = page.props.menuItems ?? [];

const openDialog = ref(false);
const searchQuery = ref("");
const filteredRoutes = ref([]);
const selectedIndex = ref(-1);
const recentRoutes = ref(
  JSON.parse(localStorage.getItem("recentRoutes")) || []
);

useShortcut("k", () => {
  openDialog.value = true;
});

// Example route list
const routes = computed(() => {
  return extractLabelsAndUrls(menu);
});

const extractLabelsAndUrls = (items, result = []) => {
  items.forEach((item) => {
    if (item.label && item.url) {
      result.push({
        label: item.label,
        url: item.url,
        authorize: item.authorize,
      });
    }
    if (item.group) {
      extractLabelsAndUrls(item.group, result);
    }
    if (item.items) {
      extractLabelsAndUrls(item.items, result);
    }
  });
  return result;
};

// Filter function
const filterRoutes = () => {
  if (searchQuery.value.trim()) {
    filteredRoutes.value = routes.value.filter((route) =>
      route.label.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
    selectedIndex.value = filteredRoutes.value.length ? 0 : -1;
  } else {
    filteredRoutes.value = [];
    selectedIndex.value = -1;
  }
};

// Navigation function
const navigateTo = (path) => {
  openDialog.value = false; // Close the dialog
  router.visit(path);
  saveRecentRoute(path);
};

// Save recent route to local storage
const saveRecentRoute = (path) => {
  const route = routes.value.find((route) => route.url === path);
  if (route) {
    recentRoutes.value = [
      route,
      ...recentRoutes.value.filter((r) => r.url !== path),
    ].slice(0, 8);
    localStorage.setItem("recentRoutes", JSON.stringify(recentRoutes.value));
  }
};

// Clear search when dialog closes
const clearSearch = () => {
  searchQuery.value = "";
  filteredRoutes.value = [];
  selectedIndex.value = -1;
};

// Highlight previous route
const highlightPrevious = () => {
  if (selectedIndex.value > 0) {
    selectedIndex.value--;
  }
};

// Highlight next route
const highlightNext = () => {
  if (selectedIndex.value < filteredRoutes.value.length - 1) {
    selectedIndex.value++;
  }
};

// Select highlighted route
const selectRoute = () => {
  if (
    selectedIndex.value >= 0 &&
    selectedIndex.value < filteredRoutes.value.length
  ) {
    navigateTo(filteredRoutes.value[selectedIndex.value].url);
  }
};

// Watch for dialog open to focus input
watch(openDialog, (newVal) => {
  if (newVal) {
    setTimeout(() => {
      document.querySelector('input[type="text"]').focus();
    }, 100);
  }
});
</script>

<style scoped>
/* Scoped styles can be minimized as Tailwind provides most of the utility */
</style>