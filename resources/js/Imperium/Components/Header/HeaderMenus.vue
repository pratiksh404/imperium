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
import { computed, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import HeaderLinkItems from "@/Imperium/Components/Header/HeaderLinkItems.vue";
import HeaderFlyoutItems from "@/Imperium/Components/Header/HeaderFlyoutItems.vue";
import { useMenu } from "@/Imperium/Composables/useMenu";
import MobileMenuItem from "@/Imperium/Components/Navigation/MenuItem.vue";
const showHeaderMenu = ref(false);
const appHeader = computed(() => usePage().props.appHeader);
const appHeaderNavigation = computed(() => appHeader.value.navigation ?? []);
const appHeaderLinkMenuItems = computed(() =>
  Object.values(appHeaderNavigation.value).length > 0
    ? appHeaderNavigation.value.headerLinkMenuItems ?? {}
    : {}
);
const appProfileMenuItems = computed(() =>
  Object.values(appHeaderNavigation.value).length > 0
    ? appHeaderNavigation.value.profileMenuItems ?? {}
    : {}
);
const appHeaderFlyoutMenuItems = computed(() =>
  Object.values(appHeaderNavigation.value).length > 0
    ? appHeaderNavigation.value.headerFlyoutMenuItems ?? {}
    : {}
);

const isMobile = useMediaQuery("(max-width: 768px)");

const { menuItems, menuGroups } = useMenu(appHeaderLinkMenuItems.value);
</script>