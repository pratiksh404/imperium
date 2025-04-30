<template>
  <component
    :is="linkComponentResolver(item.type)"
    :href="item.url"
    v-ripple
    v-bind="{ ...(item.type === 'url' ? { target: '_blank' } : {}) }"
    class="flex items-center justify-between cursor-pointer px-2 py-3 rounded text-surface-700 dark:text-surface-0 no-underline duration-150 transition-colors p-ripple"
  >
    <div class="flex items-start">
      <i
        :class="item.icon"
        class="mr-2"
        v-tooltip="item.label"
        v-if="includeIcon"
      ></i>
      <span :class="active ? 'font-bold' : 'font-medium'" v-if="!collapsed">{{
        item.label
      }}</span>
      <span
        v-if="active"
        class="flex w-2 h-2 ml-1 bg-green-500 rounded-full"
      ></span>
    </div>
    <span
      v-if="item.badge"
      class="inline-flex items-center justify-center ml-2 bg-primary text-primary-contrast rounded-full"
      style="min-width: 1.3rem; height: 1.3rem; font-size: 12px"
    >
      {{ item.badge }}
    </span>
  </component>
</template>

<script setup>
import { useLinkComponentResolver } from "@/Imperium/Composables/useLinkComponentResolver";
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
</script>