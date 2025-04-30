<template>
  <component
    :is="formOpenerComponent"
    v-model:visible="localVisible"
    :header="label"
    v-bind="{
      ...(formOpensIn === 'dialog'
        ? {
            modal: true,
            maximizable: true,
            breakpoints: { '1199px': '75vw', '575px': '90vw' },
            class: 'w-3/4 md:w-1/3 sm:w-full',
          }
        : {}),
      ...(formOpensIn === 'drawer'
        ? { position: isMobile ? 'full' : 'right', class: 'w-1/4' }
        : {}),
    }"
    :pt="{
      title: {
        class: 'text-900 text-xl',
      },
    }"
  >
    <!-- Form -->
    <slot name="form" @form-success="handleFormSuccess"></slot>
  </component>
  <div @click="localVisible = true" class="h-full">
    <slot name="trigger">
      <Button v-tooltip.top="label.trim()" :label="label.trim()" />
    </slot>
  </div>
</template>
<script setup>
import { computed, defineProps, ref, watch, onMounted, onUnmounted } from "vue";
import { useEventsStore } from "@/Imperium/Store/events";
import { useShortcut } from "@/Imperium/Composables/shortcut";
import { usePage } from "@inertiajs/vue3";
import { resolveFormOpenerComponent } from "@/Imperium/Utils/Resource/FormOpenerMapper";

// Form Resource
const eventsStore = useEventsStore();
// const CREATE_RESOURCE_DRAWER_SHORTCUT = "\\";
const props = defineProps({
  name: {
    required: true,
    type: String,
  },
  label: {
    required: true,
    type: String,
  },
  visible: {
    type: Boolean,
    default: false,
  },
  shortcut: {
    type: String,
    default: null,
  },
});

const emit = defineEmits(["update:visible"]);

const localVisible = ref(props.visible);

const resourceForm = usePage().props.resources[props.name].form;

const formOpensIn = computed(() => {
  return resourceForm.opensIn;
});

const formOpenerComponent = computed(() => {
  return resolveFormOpenerComponent(formOpensIn.value || null);
});

const createResourceDrawerShortcut = props.shortcut;

if (createResourceDrawerShortcut) {
  useShortcut(createResourceDrawerShortcut, () => {
    localVisible.value = !localVisible.value;
  });
}

watch(localVisible, (newVal) => {
  emit("update:visible", newVal);
});

import { debounce } from "lodash";

watch(
  () => eventsStore.formSuccess,
  debounce((fs) => {
    try {
      if (fs) {
        localVisible.value = false; // Close overlay
        // Wait for the overlay to close before emitting the form reset
        setTimeout(() => {
          eventsStore.resetFormStatus();
        }, 500);
      }
    } catch (error) {
      console.error("Error during form success handling:", error);
    }
  }, 300)
);

const isMobile = ref(false);

const handleFormSuccess = () => {
  try {
    localVisible.value = false; // Close overlay
    // Wait for the overlay to close before emitting the form reset
    setTimeout(() => {
      eventsStore.resetFormStatus();
    }, 500);
  } catch (error) {
    console.error("Error during form success handling:", error);
  }
};
const MOBILE_BREAKPOINT = 768;

const checkIfMobile = () => {
  isMobile.value = window.innerWidth <= MOBILE_BREAKPOINT;
};

onMounted(() => {
  checkIfMobile(); // Check on initial load
  window.addEventListener("resize", checkIfMobile); // Listen for window resize
});

onUnmounted(() => {
  window.removeEventListener("resize", checkIfMobile); // Cleanup event listener
});

defineOptions({
  name: "ModuleFormOverlay",
});
</script>