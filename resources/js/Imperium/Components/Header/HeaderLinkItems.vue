<template>
  <template v-if="menuItems.length > 0">
    <div v-for="(item, menuIndex) in menuItems" :key="item.key">
      <Menu as="div" v-if="item.items">
        <div>
          <MenuButton
            @click="dropdownActive(menuIndex)"
            :class="[
              dropdownActiveStates[menuIndex] ? 'font-bold' : '',
              'rounded-md px-3 py-2 text-sm font-medium cursor-pointer text-gray-700 dark:text-gray-200 dark:bg-transparent',
            ]"
          >
            {{ item.label }}
            <i class="pi pi-angle-down text-[10px]"></i>
          </MenuButton>
        </div>
        <transition
          v-click-outside="() => (dropdownActiveStates[menuIndex] = false)"
          enter-active-class="transition ease-out duration-100"
          enter-from-class="transform opacity-0 scale-95"
          enter-to-class="transform opacity-100 scale-100"
          leave-active-class="transition ease-in duration-75"
          leave-from-class="transform opacity-100 scale-100"
          leave-to-class="transform opacity-0 scale-95"
        >
          <MenuItems class="absolute top-22 z-10 mt-2 w-48 origin-top-right">
            <TieredMenu :model="item.items">
              <template #item="{ item, hasSubmenu }">
                <div class="flex item-between">
                  <MenuLinkItem
                    :item="item"
                    :active="active"
                    :includeIcon="false"
                  />
                  <i
                    v-if="hasSubmenu"
                    class="pi pi-angle-right ml-auto p-3"
                  ></i>
                </div>
              </template>
            </TieredMenu>
          </MenuItems>
        </transition>
      </Menu>

      <template v-else>
        <component
          :is="linkComponentResolver(item.type)"
          :key="item.label"
          :href="item.url"
          :v-if="item.authorize"
          v-bind="{ ...(item.type === 'url' ? { target: '_blank' } : {}) }"
          :class="[
            item.active ? 'font-bold' : '',
            'rounded-md px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200',
          ]"
          :aria-current="item.active ? 'page' : undefined"
          >{{ item.label }}</component
        >
      </template>
    </div>
  </template>
  <template v-if="menuGroups.length">
    <div
      v-for="(group, groupIndex) in menuGroups"
      :key="'header-group-' + groupIndex"
    >
      <div class="flex items-center">
        <div class="hidden md:block">
          <div class="ml-10 flex items-baseline space-x-4">
            <HeaderLinkItems
              :key="'header-group-' + groupIndex + '-item-' + groupIndex"
              :items="group.group"
            />
          </div>
        </div>
      </div>
    </div>
  </template>
</template>
<script setup>
import { defineProps, ref } from "vue";
import { useMenu } from "@/Imperium/Composables/useMenu";
import MobileMenuItem from "@/Imperium/Components/Navigation/MenuItem.vue";
import {
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  DisclosureButton,
} from "@headlessui/vue";
import { useLinkComponentResolver } from "@/Imperium/Composables/useLinkComponentResolver";
import vClickOutside from "@/Imperium/Directives/v-click-outside";
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
