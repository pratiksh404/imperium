<template>
  <template v-if="isMobile">
    <Button
      label="Menu"
      icon="pi pi-bars"
      @click="showHeaderMenu = true"
      size="small"
      iconPos="right"
    />
    <Drawer
      v-model:visible="showHeaderMenu"
      header="Header Menu"
      position="top"
      style="height: auto"
    >
      <template v-if="menuGroups.length > 0">
        <ul
          class="list-none px-2 mt-2"
          v-for="(group, index) in menuGroups"
          :key="'group-' + index"
        >
          <li>
            <div
              class="px-4 mb-2 flex items-center justify-between text-surface-500 dark:text-surface-400 cursor-pointer p-ripple"
            >
              <span class="font-medium">{{ group.label }}</span>
            </div>
            <ul
              class="list-none ml-4 m-0 overflow-hidden"
              v-if="group.group.length > 0"
            >
              <MobileMenuItem
                :includeIcon="false"
                :collapsed="collapsed"
                v-for="(item, group_item_key) in group.group"
                :key="'group-' + index + '-item-' + group_item_key"
                :item="item"
              />
            </ul>
          </li>
        </ul>
      </template>
      <ul
        class="list-none ml-2 px-2 m-0 overflow-hidden"
        v-if="menuItems.length > 0"
      >
        <MobileMenuItem
          :includeIcon="false"
          :collapsed="collapsed"
          v-for="(item, item_key) in menuItems"
          :key="'menuitem-' + item_key"
          :item="item"
        />
      </ul>
    </Drawer>
  </template>
  <template v-else>
    <template v-if="Object.values(appHeaderLinkMenuItems).length > 0">
      <!-- Header Link Items -->
      <HeaderLinkItems
        :items="appHeaderLinkMenuItems"
        key="header_link_items"
      />
    </template>
    <template v-if="Object.values(appHeaderFlyoutMenuItems).length > 0">
      <!-- Header Flyout Items -->
      <HeaderFlyoutItems
        :items="appHeaderFlyoutMenuItems"
        key="header_flyout_items"
      />
    </template>
  </template>
</template>
<script setup>
import { useMediaQuery } from "@vueuse/core";
import { ref, defineProps } from "vue";
import HeaderLinkItems from "@/Imperium/Components/Header/HeaderLinkItems.vue";
import HeaderFlyoutItems from "@/Imperium/Components/Header/HeaderFlyoutItems.vue";
import { useMenu } from "@/Imperium/Composables/useMenu";
import MobileMenuItem from "@/Imperium/Components/Navigation/MenuItem.vue";
const showHeaderMenu = ref(false);

const isMobile = useMediaQuery("(max-width: 768px)");

const props = defineProps({
  appHeaderLinkMenuItems: {
    type: Object,
    required: true,
  },
  appHeaderFlyoutMenuItems: {
    type: Object,
    required: true,
  },
});

const { menuItems, menuGroups } = useMenu(props.appHeaderLinkMenuItems);
</script>