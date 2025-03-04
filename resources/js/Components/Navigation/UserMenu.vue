<template>
  <div v-if="user">
    <div v-if="expanded">
      <div class="flex items-center px-5">
        <div class="flex-shrink-0">
          <img
            class="h-10 w-10 rounded-full"
            :src="user.avatar"
            :alt="user.name"
          />
        </div>
        <div class="ml-3">
          <div class="text-base font-medium leading-none text-white">
            {{ user.name }}
          </div>
          <div class="text-sm font-medium leading-none text-gray-400">
            {{ user.email }}
          </div>
        </div>
        <!-- TODO: Add User Notification Bell -->
        <!-- <button type="button"
                class="relative ml-auto flex-shrink-0 rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                <span class="absolute -inset-1.5" />
                <span class="sr-only">View notifications</span>
                <BellIcon class="h-6 w-6" aria-hidden="true" />
            </button> -->
      </div>
      <div class="mt-3 space-y-1 px-2">
        <Link
          v-for="item in items"
          :key="'expanded-' + item.label"
          as="a"
          :href="item.route"
          class="flex items-center gap-1 justify-start rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white"
        >
          <span :class="item.icon" />
          <span>{{ item.label }}</span>
          <Badge v-if="item.badge" class="ml-auto" :value="item.badge" />
        </Link>
      </div>
    </div>
    <Menu as="div" class="relative ml-3" v-else>
      <div>
        <MenuButton
          class="cursor-pointer relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
        >
          <span class="absolute -inset-1.5" />
          <span class="sr-only">Open user menu</span>
          <img
            class="h-8 w-8 rounded-full"
            :src="user.avatar"
            :alt="user.name"
          />
        </MenuButton>
      </div>
      <transition
        enter-active-class="transition ease-out duration-100"
        enter-from-class="transform opacity-0 scale-95"
        enter-to-class="transform opacity-100 scale-100"
        leave-active-class="transition ease-in duration-75"
        leave-from-class="transform opacity-100 scale-100"
        leave-to-class="transform opacity-0 scale-95"
      >
        <MenuItems
          class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
        >
          <MenuItem v-for="item in items" :key="'user-menu-' + item.label">
            <component
              :is="linkComponentResolver(item.type)"
              :key="item.key"
              :href="item.url"
              class="px-4 py-2 text-sm text-gray-700 flex items-center gap-1 justify-start"
            >
              <span :class="item.icon" class="mr-2" />
              <span>{{ item.label }}</span>
              <Badge v-if="item.badge" class="ml-auto" :value="item.badge" />
            </component>
          </MenuItem>
        </MenuItems>
      </transition>
    </Menu>
  </div>
</template>
<script setup>
import { ref, computed } from "vue";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { useLinkComponentResolver } from "@/Composables/useLinkComponentResolver";
import { usePage } from "@inertiajs/vue3";
const props = defineProps({
  items: {
    type: Object,
    required: true,
  },
  expanded: {
    required: false,
    default: false,
    type: Boolean,
  },
});

const user = computed(() => usePage().props.auth.user);

const linkComponentResolver = (type) => useLinkComponentResolver(type);
</script>
