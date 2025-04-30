<script setup>
import ApplicationLogo from "@/Imperium/Components/ApplicationLogo.vue";
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import ToggleDarkModeButton from "@/Imperium/Components/ToggleDarkModeButton.vue";

const page = usePage();

const backgroundImage = computed(() => page.props.app.auth.background ?? null);
</script>

<template>
  <div
    class="flex lg:flex-row flex-col gap-4 bg-surface-0 dark:bg-surface-900 h-screen"
  >
    <div class="flex-1 overflow-hidden hidden lg:block" v-if="backgroundImage">
      <img
        :src="backgroundImage"
        alt="hero-1"
        class="h-full w-full object-cover"
      />
    </div>
    <div class="flex-1 flex items-center justify-center">
      <ToggleDarkModeButton class="absolute top-4 right-4" rounded="true" />
      <div
        class="p-6 pt-12 lg:p-12"
        :class="{ 'w-3/4 lg:w-3/5': backgroundImage }"
      >
        <Link href="/" class="flex justify-center">
          <ApplicationLogo
            class="w-12 fill-current text-surface-900 dark:text-surface-0 m-5"
          />
        </Link>

        <slot />
      </div>
    </div>
  </div>
</template>
