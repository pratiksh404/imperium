<script setup>
import { ref, useTemplateRef, onMounted, onUnmounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

import MobileSidebarNavDrawer from './Partials/MobileSidebarNavDrawer.vue';
import Footer from './Partials/Footer.vue';
import SideMenu from './Partials/SideMenu.vue';
import { useEventBus } from "@/Composables/useEventBus";
const { on, off } = useEventBus();

const page = usePage();

// Drawer menus
const navDrawerOpen = ref(false);

// Dynamic header height for arbitrary class styling
const headerHeight = ref('');
const siteHeader = useTemplateRef('site-header');
onMounted(() => {
    if (siteHeader.value) {
        headerHeight.value = `${siteHeader.value.offsetHeight}px`;
    }

    on('open-nav', () => {
        navDrawerOpen.value = true;
    });
});

onUnmounted(() => {
    off('open-nav');
});
</script>

<template>
    <Teleport to="body">
        <Toast position="bottom-left" />
        <MobileSidebarNavDrawer v-model="navDrawerOpen">
            <SideMenu />
        </MobileSidebarNavDrawer>
    </Teleport>

    <div class="h-screen flex flex-col bg-gray-100">

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

                <slot />

                <!-- <footer class="">
                    <Footer />
                </footer> -->
            </div>
        </main>
    </div>
</template>
