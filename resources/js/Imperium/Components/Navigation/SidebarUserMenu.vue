<template>
  <!-- User Button -->
  <a
    @click="toggleMenu"
    :class="[
      'cursor-pointer flex items-center py-3 text-sm/6 font-semibold text-gray-900 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800',
      collapsed ? 'justify-center px-3' : 'gap-x-4 px-6',
    ]"
  >
    <img
      class="size-8 rounded-md bg-gray-50 dark:bg-gray-800"
      :src="user.avatar"
      :alt="user.name"
    />

    <span v-if="!collapsed" class="sr-only">Your profile</span>
    <span v-if="!collapsed" aria-hidden="true">Tom Cook</span>

    <ChevronUpDownIcon
      v-if="!collapsed"
      class="ml-auto size-5"
      aria-hidden="true"
    />
  </a>

  <div class="pl-4">
    <Popover ref="menu">
      <div class="flex flex-col gap-4 w-[15rem]">
        <div class="flex items-center gap-2">
          <img
            class="size-8 rounded-md bg-gray-50 dark:bg-gray-800"
            :src="user.avatar"
            :alt="user.name"
          />
          <div>
            <span class="font-medium">{{ user.name }}</span>
            <div class="text-sm text-surface-500 dark:text-surface-400">
              {{ user.email }}
            </div>
          </div>
          <div
            class="flex items-center gap-2 text-surface-500 dark:text-surface-400 ml-auto text-sm"
          >
            <span
              class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-gray-500/10 ring-inset"
              >{{ user?.role.name ?? "" }}</span
            >
          </div>
        </div>
        <Menu
          :model="userMenuItems"
          :pt="{
            root: {
              class: 'border-none',
            },
          }"
        >
          <template #item="{ item, props }">
            <component
              :is="linkComponentResolver(item.type)"
              :key="item.key"
              :href="item.url"
              v-ripple
              >{{ item.label }}</component
            >
          </template>
        </Menu>
      </div>
    </Popover>
  </div>
</template>
  
  <script setup>
import { ref, computed, defineProps } from "vue";
import { usePage } from "@inertiajs/vue3";
import { ChevronUpDownIcon } from "@heroicons/vue/20/solid";
import { useMenu } from "@/Imperium/Composables/useMenu";
import { useLinkComponentResolver } from "@/Imperium/Composables/useLinkComponentResolver";

const props = defineProps({
  collapsed: {
    type: Boolean,
    default: false,
  },
});
const menu = ref(null);

const toggleMenu = (event) => {
  menu.value.toggle(event);
};

const user = computed(() => usePage().props.auth.user);

const appHeader = computed(() => usePage().props.appHeader);
const appHeaderNavigation = computed(() => appHeader.value.navigation ?? []);
const appProfileMenuItems = computed(() =>
  Object.values(appHeaderNavigation.value).length > 0
    ? appHeaderNavigation.value.profileMenuItems ?? {}
    : {}
);
const { menuItems: userMenuItems } = useMenu(appProfileMenuItems.value);
const linkComponentResolver = (type) => useLinkComponentResolver(type);
console.log(userMenuItems.value);
</script>
