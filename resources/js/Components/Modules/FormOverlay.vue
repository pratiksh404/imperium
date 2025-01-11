<template>
    <Drawer v-model:visible="localVisible" :header="label" :position="isMobile ? 'full' : 'right'" class="w-1/4" :pt="{
        title: {
            class: 'text-900 text-xl'
        }
    }">
        <!-- Form -->
        <slot name="form" @form-success="handleFormSuccess"></slot>
    </Drawer>
    <div @click="localVisible = true" class="h-full">
        <slot name="trigger">
            <Button :v-tooltip.top="label.trim()" :label="label.trim()" />
        </slot>
    </div>
</template>
<script setup>
import { computed, defineProps, ref, watch, onMounted, onUnmounted, toRefs } from 'vue';
import { useEventsStore } from '@/Store/events';
const eventsStore = useEventsStore();
const props = defineProps({
    name: {
        required: true,
        type: String
    },
    visible: {
        type: Boolean,
        default: false
    },

});
const emit = defineEmits(['update:visible']);

const { visible } = toRefs(props);
const localVisible = ref(visible.value);

watch(visible, (newVal) => {
    localVisible.value = newVal;
});

watch(localVisible, (newVal) => {
    emit('update:visible', newVal);
});

const label = computed(() => props.name.replace('', ' '));

watch(
    () => eventsStore.formSuccess,
    (fs) => {
        try {
            if (fs) {
                localVisible.value = false; // Close overlay
                // Wait for the overlay to close before emitting the form reset
                setTimeout(() => {
                    eventsStore.resetFormStatus();
                }, 500);
            }
        } catch (error) {
            console.error('Error during form success handling:', error);
        }
    }
);

const isMobile = ref(false);

const checkIfMobile = () => {
    isMobile.value = window.innerWidth <= 768; // Adjust breakpoint as needed
};

onMounted(() => {
    checkIfMobile(); // Check on initial load
    window.addEventListener("resize", checkIfMobile); // Listen for window resize
});

onUnmounted(() => {
    window.removeEventListener("resize", checkIfMobile); // Cleanup event listener
});

</script>
<script>
export default {
    name: "ModuleFormOverlay"
}
</script>