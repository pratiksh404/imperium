<script setup>
import { ref, useTemplateRef } from 'vue';
import { usePage } from '@inertiajs/vue3';

import MobileSidebarNavDrawer from './Partials/MobileSidebarNavDrawer.vue';
import SideMenu from './Partials/SideMenu.vue';
import Header from './Partials/Header.vue';
import Container from '@/Components/Container.vue';

const collapsed = ref(false);


const page = usePage();

// Drawer menus
const navDrawerOpen = ref(false);

// Dynamic header height for arbitrary class styling
const headerHeight = ref('');
const siteHeader = useTemplateRef('site-header');

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

</script>

<template>



    <Teleport to="body">
        <Toast position="bottom-left" />
        <MobileSidebarNavDrawer v-model="navDrawerOpen">
            <SideMenu />
        </MobileSidebarNavDrawer>
    </Teleport>

    <div class="min-h-screen flex flex-col bg-gray-100 dark:bg-neutral-900">

        <main class="flex-1">
            <!-- Desktop Sidebar -->
            <aside :class="{ 'w-80': !collapsed, 'w-20': collapsed }"
                class="inset-0 hidden lg:block fixed overflow-y-auto overflow-x-hidden dynamic-bg border-r dynamic-border">
                <div class="px-1 py-2">
                    <SideMenu @isCollapsed="collapsed = $event" />
                </div>
            </aside>

            <!-- Scrollable Content -->
            <div :class="{ 'lg:ml-80': !collapsed, 'lg:ml-20': collapsed }" class="flex flex-col h-screen">
                <!-- Page Content -->

                <!-- Page Header -->
                <Header :title="title" :nav="nav" @open-nav="navDrawerOpen = true" />
                <!-- Page Content -->


                <Container :fluid="true">
                    <slot />
                </Container>

                <!-- <footer class="">
                <Footer />
            </footer> -->
            </div>
        </main>
    </div>
</template>
