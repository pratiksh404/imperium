<script setup>
defineProps({
  error: {
    type: String,
  },
});
</script>

<template v-if="error">
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
