<template>
  <component
    :is="linkComponentResolver(item.type)"
    :href="item.url"
    v-ripple
    v-bind="{ ...(item.type === 'url' ? { target: '_blank' } : {}) }"
    :class="[
      active
        ? 'bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-white'
        : 'hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-400',
      'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold',
      collapsed ? 'justify-center' : '',
    ]"
    @contextmenu="menuRightClick"
  >
    <!-- Icon Component Start -->
    <IconComponent
      :includeIcon="includeIcon"
      :label="item.label"
      :icon="item.icon"
    />
    <!-- Icon Component End -->
    <span v-if="!collapsed">{{ item.label }}</span>
    <span
      v-if="!collapsed && item.badge"
      class="ml-auto w-9 min-w-max rounded-full bg-black dark:bg-white px-2.5 py-0.5 text-center text-xs/5 font-medium whitespace-nowrap text-gray-200 dark:text-gray-700 ring-1 ring-gray-200 ring-inset"
      aria-hidden="true"
      >{{ item.badge }}</span
    >
  </component>
  <!-- Context Menu -->
  <ContextMenu ref="contextMenu" :model="contextMenuItems" />
</template>

<script setup>
import { ref } from "vue";
import { useLinkComponentResolver } from "@/Imperium/Composables/useLinkComponentResolver";
import IconComponent from "@/Imperium/Components/Utils/IconComponent.vue";
import { usePage } from "@inertiajs/vue3";
import { useMenuTabStore } from "@/Imperium/Store/menu_tabs";

const props = defineProps({
  item: {
    type: Object,
    required: true,
  },
  active: {
    type: Boolean,
    default: false,
  },
  collapsed: {
    type: Boolean,
    default: false,
  },
  includeIcon: {
    type: Boolean,
    default: true,
  },
});

const linkComponentResolver = (type) => useLinkComponentResolver(type);
const page = usePage();
const tabStore = useMenuTabStore();

const contextMenu = ref();
const rightClickedItem = ref(null);

const contextMenuItems = ref([
  {
    label: "Open In New Tab",
    icon: "pi pi-external-link",
    command: () => {
      if (rightClickedItem.value) {
        tabStore.openTab({
          key: rightClickedItem.value.label,
          label: rightClickedItem.value.label,
          url: rightClickedItem.value.url,
          icon: rightClickedItem.value.icon,
        });
      }
    },
  },
]);

const menuRightClick = (event) => {
  rightClickedItem.value = props.item;
  contextMenu.value.show(event);
};
</script>
