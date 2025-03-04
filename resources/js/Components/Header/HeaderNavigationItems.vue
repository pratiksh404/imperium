<template v-if="menuItems.length > 0">
  <div v-for="(item, menuIndex) in menuItems" :key="item.key">
    <Menu as="div" v-if="item.items">
      <div>
        <MenuButton
          @click="dropdownActive(menuIndex)"
          :class="[
            dropdownActiveStates[menuIndex]
              ? 'bg-gray-900 text-white'
              : 'text-gray-300 hover:bg-gray-700 hover:text-white bg-transparent',
            'rounded-md px-3 py-2 text-sm font-medium cursor-pointer',
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
                <i v-if="hasSubmenu" class="pi pi-angle-right ml-auto p-3"></i>
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
        :class="[
          item.active
            ? 'bg-gray-900 text-white'
            : 'text-gray-300 hover:bg-gray-700 hover:text-white',
          'rounded-md px-3 py-2 text-sm font-medium',
        ]"
        :aria-current="item.active ? 'page' : undefined"
        >{{ item.label }}</component
      >
    </template>
  </div>
</template>
<script setup>
import { defineProps, ref } from "vue";
import { useMenu } from "@/Composables/useMenu";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { useLinkComponentResolver } from "@/Composables/useLinkComponentResolver";
import vClickOutside from "@/Directives/v-click-outside";
import MenuLinkItem from "../Navigation/MenuLinkItem.vue";

const props = defineProps({
  items: {
    type: Object,
    required: true,
  },
});

const dropdownActiveStates = ref({});

const dropdownActive = (index) => {
  dropdownActiveStates.value[index] = !dropdownActiveStates.value[index];
};

const { menuItems, menuGroups } = useMenu(props.items);

const linkComponentResolver = (type) => useLinkComponentResolver(type);
</script>
