<template>
  <Drawer
    v-model:visible="localVisible"
    :header="label"
    :position="isMobile ? 'full' : 'right'"
    class="w-1/4"
    :pt="{
      title: {
        class: 'text-900 text-xl',
      },
    }"
  >
    <!-- Form -->
    <slot name="form" @form-success="handleFormSuccess"></slot>
  </Drawer>
  <div @click="localVisible = true" class="h-full">
    <slot name="trigger">
      <Button v-tooltip.top="label.trim()" :label="label.trim()" />
    </slot>
  </div>
</template>
<script setup>
import {
  computed,
  defineProps,
  ref,
  watch,
  onMounted,
  onUnmounted,
  toRefs,
} from "vue";
import { useEventsStore } from "@/Store/events";
import { useShortcut } from "@/Composables/shortcut";

const eventsStore = useEventsStore();
const CREATE_RESOURCE_DRAWER_SHORTCUT = "\\";
const props = defineProps({
  name: {
    required: true,
    type: String,
  },
  visible: {
    type: Boolean,
    default: false,
  },
  shortcut: {
    type: String,
    default: CREATE_RESOURCE_DRAWER_SHORTCUT,
  },
});
const emit = defineEmits(["update:visible"]);

const localVisible = ref(props.visible);

const createResourceDrawerShortcut = props.shortcut;
useShortcut(createResourceDrawerShortcut, () => {
  localVisible.value = !localVisible.value;
});

watch(props.visible, (newVal) => {
  localVisible.value = newVal;
});

watch(localVisible, (newVal) => {
  emit("update:visible", newVal);
});

const label = computed(() => props.name.replace("", " "));
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