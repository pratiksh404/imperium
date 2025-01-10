<script setup>
import { computed, ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import MenuItem from '@/Components/MenuItem.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const expandedKeys = ref({});

// Current Route
const currentRoute = route().current();

// Computed Menu Items
const menuItems = computed(() => {
    const data = usePage().props.menuItems ?? [];
    return data.map(item => menuItem(item.label, item.icon, item.url, item.items));
});

const menuItem = (label, icon, url, items) => {
    const nodeKey = label;
    const nodeItems = items != null && !url ? items.map(item => menuItem(item.label, item.icon, item.url, item.items)) : null;
    const isActive = route(currentRoute) === url;

    // Add key to expandedKeys if any of its item field have active true
    if (nodeItems && nodeItems.some(item => item.active)) {
        expandedKeys.value[nodeKey] = true;
    }

    return {
        key: nodeKey,
        label: label,
        icon: icon,
        url: url,
        active: isActive,
        items: nodeItems
    };
}

</script>


<template>
    <div class="h-full">
        <!-- Application Logo -->
        <div class="justify-start mb-4 hidden sm:flex md:flex">
            <Link :href="route('welcome')" class="mr-3">
            <ApplicationLogo class="block h-10 w-auto fill-current text-surface-900 dark:text-surface-0" />
            </Link>
            <Tag value="Primary">ADMIN</Tag>
        </div>

        <!-- Menu Items -->
        <div class="mt-10">
            <div class="mb-5" v-if="menuItems.length > 0">
                <p class="text-muted-color font-bold uppercase text-sm mb-2">
                    Home
                </p>
                <MenuItem :model="menuItems" v-model:expandedKeys="expandedKeys" class="w-full" />
            </div>
        </div>
    </div>
</template>
