<script setup>
import { useHeroOutlineIcon } from "@/Imperium/Composables/useHeroOutlineIcons";

const props = defineProps({
  icon: {
    type: String,
    default: "paper-clip",
  },
  label: String,
  includeIcon: Boolean,
});

// Check if icon string is font awesome icon starting with fa- prefix
const isFontAwesomeIcon = (icon) => icon.startsWith("fa-");
</script>

<template>
  <component
    v-if="!isFontAwesomeIcon(icon) && includeIcon"
    :is="useHeroOutlineIcon(icon)"
    class="size-6 shrink-0 text-gray-400 dark:text-gray-500"
    v-tooltip="label"
  />
  <i v-if="isFontAwesomeIcon(icon) && includeIcon" :class="icon" />
</template>
