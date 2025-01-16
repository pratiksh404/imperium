<script setup>
import { inject } from 'vue';
import { useToggle } from '@vueuse/core';

const isDarkMode = inject('darkMode');
const toggleDark = useToggle(isDarkMode);
</script>

<template>
    <div>
        <Button :icon="isDarkMode ? 'pi pi-moon' : 'pi pi-sun'" @click="toggleDark()" size="small" />
    </div>
</template>
