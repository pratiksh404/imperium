<template>
  <div v-if="user">
    <Menu as="div" class="relative">
      <MenuButton class="-m-1.5 flex items-center p-1.5 dark:bg-black bg-white">
        <span class="sr-only">Open user menu</span>
        <img
          class="size-8 rounded-full bg-gray-50 dark:bg-gray-800"
          :src="user.avatar"
          :alt="user.name"
        />
        <span class="hidden lg:flex lg:items-center">
          <span
            class="ml-4 text-sm/6 font-semibold text-gray-900 dark:text-gray-200"
            aria-hidden="true"
            >{{ user.name }}</span
          >
          <ChevronDownIcon
            class="ml-2 size-5 text-gray-400 dark:text-gray-400"
            aria-hidden="true"
          />
        </span>
      </MenuButton>
      <transition
        enter-active-class="transition ease-out duration-100"
        enter-from-class="transform opacity-0 scale-95"
        enter-to-class="transform opacity-100 scale-100"
        leave-active-class="transition ease-in duration-75"
        leave-from-class="transform opacity-100 scale-100"
        leave-to-class="transform opacity-0 scale-95"
      >
        <MenuItems
          class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-hidden dark:bg-black dark:shadow-gray-800 dark:ring-gray-700"
        >
          <MenuItem v-for="item in items" :key="item.label" v-slot="{ active }">
            <component
              :is="linkComponentResolver(item.type)"
              :key="item.key"
              :href="item.url"
              :class="[
                item.active ? 'bg-gray-50 dark:bg-gray-800 outline-hidden' : '',
                'block px-3 py-1 text-sm/6 text-gray-700 dark:text-gray-200',
              ]"
              >{{ item.label }}</component
            >
          </MenuItem>
        </MenuItems>
      </transition>
    </Menu>
  </div>
</template>
<script setup>
import { computed } from "vue";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { usePage } from "@inertiajs/vue3";
import { useLinkComponentResolver } from "@/Imperium/Composables/useLinkComponentResolver";
import { ChevronDownIcon } from "@heroicons/vue/20/solid";
const props = defineProps({
  items: {
    type: Object,
    required: true,
  },
});

const user = computed(() => usePage().props.auth.user);

const linkComponentResolver = (type) => useLinkComponentResolver(type);
</script>
