<template>
  <template v-if="mobileMode">
    <template v-if="menuGroups.length > 0">
      <ul class="list-none px-2 mt-2" v-for="(group, index) in menuGroups" :key="'group-' + index">
        <li>
          <div
            class="px-4 mb-2 flex items-center justify-between text-surface-500 dark:text-surface-400 cursor-pointer p-ripple">
            <span class="font-medium">{{ group.label }}</span>
          </div>
          <ul class="list-none ml-4 m-0 overflow-hidden" v-if="group.group.length > 0">
            <MobileMenuItem :includeIcon="false" :collapsed="collapsed" v-for="(item, group_item_key) in group.group"
              :key="'group-' + index + '-item-' + group_item_key" :item="item" />
          </ul>
        </li>
      </ul>
    </template>
    <ul class="list-none ml-2 px-2 m-0 overflow-hidden" v-if="menuItems.length > 0">
      <MobileMenuItem :includeIcon="false" :collapsed="collapsed" v-for="(item, item_key) in menuItems"
        :key="'menuitem-' + item_key" :item="item" />
    </ul>
  </template>
  <template v-else>
    <template v-if="menuItems.length > 0">
      <div v-for="(item, menuIndex) in menuItems" :key="item.key">
        <Menu as="div" v-if="item.items">
          <div>
            <MenuButton @click="dropdownActive(menuIndex)" :class="[
              dropdownActiveStates[menuIndex]
                ? 'bg-gray-900 text-white'
                : 'text-gray-300 hover:bg-gray-700 hover:text-white bg-transparent',
              'rounded-md px-3 py-2 text-sm font-medium cursor-pointer',
            ]">
              {{ item.label }}
              <i class="pi pi-angle-down text-[10px]"></i>
            </MenuButton>
          </div>
          <transition v-click-outside="() => (dropdownActiveStates[menuIndex] = false)"
            enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <MenuItems class="absolute top-22 z-10 mt-2 w-48 origin-top-right">
              <TieredMenu :model="item.items">
                <template #item="{ item, hasSubmenu }">
                  <div class="flex item-between">
                    <MenuLinkItem :item="item" :active="active" :includeIcon="false" />
                    <i v-if="hasSubmenu" class="pi pi-angle-right ml-auto p-3"></i>
                  </div>
                </template>
              </TieredMenu>
            </MenuItems>
          </transition>
        </Menu>

        <template v-else>
          <component :is="linkComponentResolver(item.type)" :key="item.label" :href="item.url" :v-if="item.authorize"
            v-bind="{ ...(item.type === 'url' ? { target: '_blank' } : {}) }" :class="[
              item.active
                ? 'bg-gray-900 text-white'
                : 'text-gray-300 hover:bg-gray-700 hover:text-white',
              'rounded-md px-3 py-2 text-sm font-medium',
            ]" :aria-current="item.active ? 'page' : undefined">{{ item.label }}</component>
        </template>
      </div>
    </template>
    <template v-if="menuGroups.length">
      <div v-for="(group, groupIndex) in menuGroups" :key="'header-group-' + groupIndex">
        <div class="flex items-center">
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
              <HeaderLinkItems :key="'header-group-' + groupIndex + '-item-' + groupIndex" :items="group.group" />
            </div>
          </div>
        </div>
      </div>
    </template>
  </template>
</template>
<script setup>
import { defineProps, ref } from "vue";
import { useMenu } from "@/Composables/useMenu";
import MobileMenuItem from "@/Components/Navigation/MenuItem.vue";
import {
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  DisclosureButton,
} from "@headlessui/vue";
import { useLinkComponentResolver } from "@/Composables/useLinkComponentResolver";
import vClickOutside from "@/Directives/v-click-outside";
import MenuLinkItem from "../Navigation/MenuLinkItem.vue";

const props = defineProps({
  items: {
    type: Object,
    required: true,
  },
  mobileMode: {
    type: Boolean,
    default: false,
  },
});

const dropdownActiveStates = ref({});

const dropdownActive = (index) => {
  dropdownActiveStates.value[index] = !dropdownActiveStates.value[index];
};

const { menuItems, menuGroups } = useMenu(props.items);

const linkComponentResolver = (type) => useLinkComponentResolver(type);
</script>

<script>
export default {
  name: "HeaderLinkItems",
};
</script>
