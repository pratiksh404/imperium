<template>
  <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
    <form class="grid flex-1 grid-cols-1" action="#" method="GET">
      <input type="search" name="search" aria-label="Search"
        class="col-start-1 row-start-1 block size-full bg-white pl-8 text-base text-gray-900 outline-hidden placeholder:text-gray-400 dark:bg-black dark:text-gray-200 sm:text-sm/6"
        placeholder="Search" />
      <MagnifyingGlassIcon class="pointer-events-none col-start-1 row-start-1 size-5 self-center text-gray-400"
        aria-hidden="true" />
    </form>
    <div class="flex items-center gap-x-2 lg:gap-x-3">
      <HeaderMenus :appHeaderLinkMenuItems="appHeaderLinkMenuItems"
        :appHeaderFlyoutMenuItems="appHeaderFlyoutMenuItems" />
      <NavigationPalette />

      <RefreshButton />

      <ToggleDarkModeButton />
      <button type="button"
        class="-m-2.5 p-2.5 text-gray-500 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white dark:bg-black bg-white">
        <span class="sr-only">View notifications</span>
        <BellIcon class="size-6" aria-hidden="true" />
      </button>

      <!-- Separator -->
      <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-200 dark:lg:bg-gray-700" aria-hidden="true" />

      <!-- Profile dropdown -->
      <UserMenu :items="userMenuItems" />
    </div>
  </div>
</template>
<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import HeaderMenus from "@/Imperium/Components/Header/HeaderMenus.vue";
import UserMenu from "@/Imperium/Components/Navigation/UserMenu.vue";
import ToggleDarkModeButton from "@/Imperium/Components/ToggleDarkModeButton.vue";
import NavigationPalette from "@/Imperium/Components/Navigation/NavigationPalette.vue";
import RefreshButton from "@/Imperium/Components/Navigation/RefreshButton.vue";
import { useMenu } from "@/Imperium/Composables/useMenu";
import {
  ChevronDownIcon,
  MagnifyingGlassIcon,
  BellIcon,
} from "@heroicons/vue/20/solid";


const appHeader = computed(() => usePage().props.appHeader);
const appHeaderNavigation = computed(() => appHeader.value.navigation ?? []);
const appHeaderLinkMenuItems = computed(() =>
  Object.values(appHeaderNavigation.value).length > 0
    ? appHeaderNavigation.value.headerLinkMenuItems ?? {}
    : {}
);

const appHeaderFlyoutMenuItems = computed(() =>
  Object.values(appHeaderNavigation.value).length > 0
    ? appHeaderNavigation.value.headerFlyoutMenuItems ?? {}
    : {}
);

const appProfileMenuItems = computed(() =>
  Object.values(appHeaderNavigation.value).length > 0
    ? appHeaderNavigation.value.profileMenuItems ?? {}
    : {}
);
const { menuItems: userMenuItems } = useMenu(appProfileMenuItems.value);
</script>
<style></style>