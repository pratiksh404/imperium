<template>
  <PageHeader>
    <template #actions>
      <div
        v-if="
          route != null &&
          moduleForm != null &&
          $page.props.can.create?.[name.toLowerCase()]
        "
      >
        <ModuleFormOverlay
          :name="'Create ' + name"
          :key="'module-create-' + name"
          v-model:visible="createResourceDrawer"
        >
          <template #trigger>
            <Button
              size="large"
              icon="pi pi-pencil"
              v-tooltip.left="
                'shortcut: ' +
                (isMac ? '⌘' : 'CTRL') +
                '+' +
                createResourceDrawerShortcut
              "
              :label="'Create ' + name"
            />
          </template>
          <template #form>
            <component :is="moduleForm" :name="name" method="post" :url="url">
            </component>
          </template>
        </ModuleFormOverlay>
      </div>
    </template>
  </PageHeader>
  <slot name="table"></slot>
</template>
<script setup>
import { defineProps, ref, computed } from "vue";
import ModuleFormOverlay from "@/Imperium/Components/Modules/FormOverlay.vue";
import ResourceForm from "@/Imperium/Components/Form/ResourceForm.vue";
import PageHeader from "@/Imperium/Components/PageHeader.vue";
import { useShortcut } from "@/Imperium/Composables/shortcut";
defineProps({
  name: {
    required: true,
    type: String,
  },
  url: {
    required: false,
    type: String,
    default: null,
  },
  moduleForm: {
    required: false,
    type: Object,
    default: ResourceForm,
  },
});

const createResourceDrawer = ref(false);
const createResourceDrawerShortcut = ref("\\");

useShortcut(createResourceDrawerShortcut.value, () => {
  createResourceDrawer.value = !createResourceDrawer.value;
});

const isMac = computed(() => navigator.userAgent.toUpperCase().includes("MAC"));
</script>
<script>
export default {
  name: "ModuleDataListPage",
};
</script>