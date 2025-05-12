<script setup>
import { inject } from "vue";
import { useToggle } from "@vueuse/core";

const isDarkMode = inject("darkMode");
const toggleDark = useToggle(isDarkMode);

const props = defineProps({
  rounded: {
    required: false,
    default: false,
    type: Boolean,
  },
});
</script>

<template>
  <div>
    <Button
      :rounded="rounded"
      :icon="isDarkMode ? 'pi pi-moon' : 'pi pi-sun'"
      @click="toggleDark()"
      size="small"
    />
  </div>
</template>
