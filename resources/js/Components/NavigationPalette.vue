<template>
    <div>
        <!-- Button to trigger the command palette -->
        <button @click="openDialog = true"
            class="flex items-center gap-2 px-6 py-2 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 transition w-full">
            <!-- Search Icon -->
            <i class="pi pi-search text-gray-500"></i>
            <!-- Shortcut -->
            <span class="ml-auto text-gray-400 text-xs font-medium hidden sm:inline">
                ⌘ + K
            </span>
        </button>

        <!-- Command Palette Dialog -->
        <Dialog v-model:visible="openDialog" header="Command Palette" :modal="true" :closable="true" position="top"
            :style="{ width: '35vw' }" @hide="clearSearch">
            <!-- Search Input -->
            <div class="flex items-center gap-2 bg-gray-100 p-2 rounded">
                <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 16l-4-4m0 0l4-4m-4 4h16" />
                </svg>
                <input type="text" v-model="searchQuery" placeholder="Search for a route..." @input="filterRoutes"
                    class="bg-transparent outline-none w-full text-gray-700 placeholder-gray-400"
                    @keydown.up.prevent="highlightPrevious" @keydown.down.prevent="highlightNext"
                    @keydown.enter.prevent="selectRoute" autofocus />
            </div>

            <!-- Filtered Routes -->
            <ul v-if="filteredRoutes.length" class="mt-4 max-h-48 overflow-y-auto">
                <li v-for="(route, index) in filteredRoutes" :key="index" @mouseover="selectedIndex = index"
                    @click="navigateTo(route.url)"
                    :class="{ 'bg-black text-white': selectedIndex === index, 'hover:bg-black hover:text-white': selectedIndex !== index }"
                    class="py-2 px-4 rounded cursor-pointer transition">
                    {{ route.label }}
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
import { router } from '@inertiajs/vue3'

const page = usePage();

const menu = page.props.menus;

const openDialog = ref(false);
const searchQuery = ref("");
const filteredRoutes = ref([]);
const selectedIndex = ref(-1);

useShortcut("k", () => {
    openDialog.value = true;
});

// Example route list
const routes = computed(() => {
    return Object.keys(menu ?? {}).length > 0 ? menu.filter((item) => item.url || item.children) // Keep items with a URL or children
        .flatMap((item) =>
            item.url
                ? [{ label: item.label, icon: item.icon, url: item.url }]
                : extractWithUrl(item.children || [])
        ) : [];
})


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
    if (selectedIndex.value >= 0 && selectedIndex.value < filteredRoutes.value.length) {
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