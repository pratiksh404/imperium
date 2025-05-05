<template>
  <!-- Dropdown Item -->
  <button
    @click="() => toggleSubMenu()"
    :class="[
      active
        ? 'bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-white'
        : 'hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-400',
      'cursor-pointer bg-transparent flex w-full items-center gap-x-3 rounded-md p-2 text-left text-sm/6 font-semibold',
      collapsed ? 'justify-center' : '',
    ]"
  >
    <!-- Icon Component Start -->
    <IconComponent
      :includeIcon="includeIcon"
      :label="item.label"
      :icon="item.icon"
    />
    <!-- Icon Component End -->
    <span v-if="!collapsed">{{ item.label }}</span>
    <ChevronRightIcon
      v-if="!collapsed"
      :class="[
        openSubmenu
          ? 'rotate-90 text-gray-500 dark:text-gray-400'
          : 'text-gray-400 dark:text-gray-600',
        'ml-auto size-5 shrink-0',
      ]"
      aria-hidden="true"
    />
  </button>
  <transition
    enter-active-class="transition duration-200 ease-out"
    enter-from-class="transform scale-95 opacity-0"
    enter-to-class="transform scale-100 opacity-100"
    leave-active-class="transition duration-150 ease-in"
    leave-from-class="transform scale-100 opacity-100"
    leave-to-class="transform scale-95 opacity-0"
  >
    <ul v-if="openSubmenu && !collapsed" class="pl-3">
      <MenuItem
        v-for="subitem in item.items"
        :includeIcon="includeIcon"
        :item="subitem"
        :key="subitem.label"
      />
    </ul>
  </transition>
</template>
<script setup>
import MenuItem from "@/Imperium/Components/Navigation/MenuItem.vue";
import { ChevronRightIcon } from "@heroicons/vue/24/outline";
import IconComponent from "@/Imperium/Components/Utils/IconComponent.vue";
import { ref } from "vue";
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
    required: false,
    default: false,
  },
  includeIcon: {
    type: Boolean,
    default: true,
  },
});

const openSubmenu = ref(props.active);
const toggleSubMenu = () => {
  openSubmenu.value = !openSubmenu.value;
  console.log(openSubmenu.value);
};
</script>
