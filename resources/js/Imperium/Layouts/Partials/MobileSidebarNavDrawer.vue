<script setup>
import { usePage } from "@inertiajs/vue3";
import ApplicationLogo from "@/Imperium/Components/ApplicationLogo.vue";

const model = defineModel();
const page = usePage();
</script>

<template>
  <Drawer
    v-model:visible="model"
    position="left"
    :pt="{
      content: {
        class: 'p-0',
      },
    }"
  >
    <template #header>
      <div class="flex justify-start">
        <Link :href="route('welcome')" class="mr-3">
          <ApplicationLogo
            class="h-10 w-auto fill-current text-surface-900 dark:text-surface-0"
          />
        </Link>
        <Tag value="Primary">{{ page.props.app.name }}</Tag>
      </div>
    </template>
    <slot />
  </Drawer>
</template>
