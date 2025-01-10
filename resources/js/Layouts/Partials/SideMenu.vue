<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import MenuItem from '@/Components/MenuItem.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

// Current Route
const currentRoute = route().current();

// Computed Menu Items
const menuItems = computed(() => {
    const data = usePage().props.menuItems ?? [];
    return data.map(menuItem => ({
        label: menuItem.label,
        icon: menuItem.icon,
        route: menuItem.url, // Ensure compatibility with PrimeVue
        active: route(currentRoute) === menuItem.url,
        items: menuItem.items ?? null,
    }));
});

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
                <MenuItem :model="menuItems" class="w-full" />
            </div>
        </div>
    </div>
</template>
