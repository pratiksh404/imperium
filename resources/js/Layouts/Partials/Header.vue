<template>
    <header
        class="sticky top-0 z-30 flex h-auto items-center sm:static sm:h-auto sm:border-0 px-4  pb-6 md:pb-1 md:px-4">
        <div class="flex justify-between w-full">
            <div class="flex justify-start gap-1 w-3/5">
                <Button class="flex lg:hidden mr-4" severity="secondary" icon="pi pi-bars" @click="$emit('open-nav')"
                    :pt="{
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
            <div class="flex justify-end mt-3 w-2/5 gap-1">

                <NavigationPalette />

                <RefreshButton />

                <ToggleDarkModeButton text severity="secondary" rounded />

                <UserMenu :items="userMenuItems" />
            </div>
        </div>
    </header>

</template>
<script setup>
import ToggleDarkModeButton from '@/Components/ToggleDarkModeButton.vue';
import NavigationPalette from '@/Components/Navigation/NavigationPalette.vue';
import RefreshButton from '@/Components/Navigation/RefreshButton.vue';
import UserMenu from '@/Components/Navigation/UserMenu.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';


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

</script>
