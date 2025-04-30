<script setup>
import { computed } from "vue";
const props = defineProps({
  error: {
    type: String,
  },
});
const validError = computed(() => {
  return props.error && typeof myVariable != "undefined";
});
</script>

<template v-if="validError">
  <Message
    v-for="(err, index) in error.split(',')"
    severity="error"
    variant="simple"
    class="p-1"
    :key="'input-error-' + index"
  >
    <span style="font-size: 12px"
      ><i class="pi pi-exclamation-triangle mr-2 mt-1"></i> {{ err }}</span
    >
  </Message>
</template>
