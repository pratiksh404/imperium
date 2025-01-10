<script setup>
import { ref, useTemplateRef, onMounted, onUnmounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

import MobileSidebarNavDrawer from './Partials/MobileSidebarNavDrawer.vue';
import SideMenu from './Partials/SideMenu.vue';
import Header from './Partials/Header.vue';


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

    <div class="h-screen flex flex-col bg-gray-100 dark:bg-neutral-900">

        <main class="flex-1">
            <!-- Desktop Sidebar -->
            <aside :class="[
                'w-[18rem] inset-0 hidden lg:block fixed overflow-y-auto overflow-x-hidden dynamic-bg border-r dynamic-border',
            ]">
                <div class="w-full px-8 py-6">
                    <SideMenu />
                </div>
            </aside>

            <!-- Scrollable Content -->
            <div :class="[
                'flex flex-col h-full lg:pl-[18rem]',
            ]">
                <!-- Page Content -->

                <!-- Page Header -->
                <header class="sticky top-0 z-30 flex h-8 items-center   sm:static sm:h-auto sm:border-0  p-6 md:p-1">
                    <Header :title="title" :nav="nav" @open-nav="navDrawerOpen = true" />
                </header>

                <!-- Page Content -->
                <section id="page-content" class="grow px-4">
                    <slot />
                </section>

                <!-- <footer class="">
                    <Footer />
                </footer> -->
            </div>
        </main>
    </div>
</template>
