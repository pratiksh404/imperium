<template>
  <!-- Dropdown Item -->

  <span
    @click="toggleDropdown"
    v-ripple
    v-styleclass="{
      selector: '@next',
      enterFromClass: 'hidden',
      enterActiveClass: 'animate-slidedown',
      leaveToClass: 'hidden',
      leaveActiveClass: 'animate-slideup',
    }"
    class="flex items-center justify-between cursor-pointer px-2 py-3 rounded text-surface-700 dark:text-surface-0 duration-150 transition-colors p-ripple"
  >
    <div>
      <i class="pi pi-chart-line mr-2"></i>
      <span :class="active ? 'font-bold' : 'font-medium'" v-if="!collapsed">{{
        item.label
      }}</span>
      <span
        v-if="item.badge && !collapsed"
        class="inline-flex items-center justify-center ml-2 bg-primary text-primary-contrast rounded-full"
        style="min-width: 1.3rem; height: 1.3rem; font-size: 12px"
        >{{ item.badge }}</span
      >
    </div>
    <div class="flex justify-end gap-2" v-if="!collapsed">
      <i class="pi pi-chevron-down ml-auto"></i>
    </div>
  </span>
  <ul
    :class="dropDown ? '' : 'hidden'"
    v-if="!collapsed && dropDown"
    class="list-none py-0 pl-4 pr-0 m-0 overflow-y-hidden transition-all duration-[400ms] ease-in-out"
  >
    <MenuItem
      v-for="subitem in item.items"
      :item="subitem"
      :key="subitem.label"
    />
  </ul>
</template>
<script setup>
import MenuItem from "@/Components/Navigation/MenuItem.vue";
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
});

const dropDown = ref(props.active || false);

const toggleDropdown = () => {
  dropDown.value = !dropDown.value;
};
</script>
