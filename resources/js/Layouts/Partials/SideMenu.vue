<script setup>
import LinksPanelMenu from '@/Components/PrimeVue/LinksPanelMenu.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
// Nav Items
const currentRoute = route().current();
const homeMenuItems = [
    {
        label: 'Welcome',
        icon: 'pi pi-home',
        route: route('welcome'),
        active: currentRoute == 'welcome',
    },
    {
        label: 'Dashboard',
        icon: 'pi pi-th-large',
        route: route('dashboard'),
        active: currentRoute == 'admin.dashboard',
    },
];
const analyticsMenuItems = [

];
const exampleNestedMenuItems = [
    {
        label: 'Files',
        icon: 'pi pi-file',
        items: [
            {
                label: 'Images',
                icon: 'pi pi-image',
                items: [
                    {
                        label: 'Logos',
                        icon: 'pi pi-image',
                    },
                ],
            },
        ],
    },
    {
        label: 'Cloud',
        icon: 'pi pi-cloud',
        items: [
            {
                label: 'Upload',
                icon: 'pi pi-cloud-upload',
                command: () => {
                    alert('Example using programmatic functionality');
                },
            },
            {
                label: 'Download',
                icon: 'pi pi-cloud-download',
            },
            {
                label: 'Sync',
                icon: 'pi pi-refresh',
            },
        ],
    },
];
</script>

<template>
    <div class="h-full">
        <div class="justify-start mb-4 hidden sm:flex md:flex">
            <Link :href="route('welcome')" class="mr-3">
            <ApplicationLogo class="block h-10 w-auto fill-current text-surface-900 dark:text-surface-0" />
            </Link>
            <Tag value="Primary">ADMIN</Tag>
        </div>
        <div class="mb-5">
            <p class="text-muted-color font-bold uppercase text-sm mb-2">
                Home
            </p>
            <LinksPanelMenu :model="homeMenuItems" class="w-full" />
        </div>
        <div class="mb-5">
            <p class="text-muted-color font-bold uppercase text-sm mb-2">
                Analytics
            </p>
            <LinksPanelMenu :model="analyticsMenuItems" class="w-full" />
        </div>
        <div class="mb-5">
            <p class="text-muted-color font-bold uppercase text-sm mb-2">
                Example Nested
            </p>
            <LinksPanelMenu :model="exampleNestedMenuItems" class="w-full" />
        </div>
    </div>
</template>
