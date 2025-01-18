<template>
    <nav class="relative">
        <div class="container px-6 py-4 md:px-2 mx-auto md:flex md:justify-between md:items-center">
            <div class="flex items-center justify-between">

                <div class="flex justify-start gap-1">
                    <Button class="flex lg:hidden mr-4" severity="secondary" icon="pi pi-bars"
                        @click="$emit('open-nav')" :pt="{
                            icon: {
                                class: 'text-xl',
                            }
                        }" />

                    <Breadcrumb :pt="{
                        root: {
                            class: 'bg-transparent',
                        }
                    }" :home="{
                        icon: 'pi pi-home',
                        route: route('welcome'),
                    }" :model="breadcrumbs">
                        <template #item="{ item, props }">
                            <Link v-if="item.route" :href="item.route" class="p-breadcrumb-item-link" custom>
                            <span v-show="item.icon" :class="item.icon" class="p-breadcrumb-item-icon" />
                            <span class="p-breadcrumb-item-label text-sm whitespace-nowrap">{{ item.label }}</span>
                            </Link>
                            <span v-else>
                                <span v-show="item.icon" :class="item.icon" class="p-breadcrumb-item-icon" />
                                <span class="p-breadcrumb-item-label text-sm whitespace-nowrap">{{ item.label }}</span>
                            </span>
                        </template>
                        <template #separator>></template>
                    </Breadcrumb>
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <div class="absolute right-3 top-5 z-50 w-max flex-col items-center gap-1 p-0.5 group-hover:flex ">
                        <Button icon="pi pi-arrow-down" rounded @click="toggleMobileMenu" type="button" />

                        <transition name="fade">
                            <div v-if="headerMobileMenu">
                                <RefreshButton :rounded="md" class="my-2" />

                                <ToggleDarkModeButton :rounded="md" class="my-2" />
                            </div>
                        </transition>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="hidden md:flex ">
                <div class="flex flex-col md:flex-row  gap-1">
                    <NavigationPalette />

                    <RefreshButton />

                    <ToggleDarkModeButton />

                    <UserMenu :items="userMenuItems" />
                </div>
            </div>
        </div>
    </nav>
</template>
<script setup>
import ToggleDarkModeButton from '@/Components/ToggleDarkModeButton.vue';
import NavigationPalette from '@/Components/Navigation/NavigationPalette.vue';
import RefreshButton from '@/Components/Navigation/RefreshButton.vue';
import UserMenu from '@/Components/Navigation/UserMenu.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { useWindowSize } from '@/Composables/useWindowSize';

const { windowSize, currentBreakpoint } = useWindowSize();

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

const md = computed(() => windowSize.value.width <= 768);

const breadcrumb = computed(() => usePage().props.breadcrumb);
const resourceTitle = computed(() => breadcrumb.value?.title ?? '');
const resourceItems = computed(() => breadcrumb.value?.items ?? []);
const resourcePoints = computed(() => breadcrumb.value?.points ?? []);

const pageTitle = computed(() => props.title ?? resourceTitle.value ?? null);
const breadcrumbs = computed(() => props.nav.length > 0 ? props.nav : resourceItems.value);


// User menu
const logoutForm = useForm({});

const userMenuItems = [
    {
        label: 'Profile',
        route: route('profile.edit'),
        icon: 'pi pi-fw pi-user',
    },
    {
        label: 'Log Out',
        icon: 'pi pi-fw pi-sign-out',
        command: () => {
            logoutForm.post(route('logout'));
        },
    },
];

const headerMobileMenu = ref(false);

const toggleMobileMenu = () => {
    headerMobileMenu.value = !headerMobileMenu.value;
};

</script>
