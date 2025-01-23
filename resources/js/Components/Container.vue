<script setup>
const props = defineProps({
    spacedMobile: {
        type: Boolean,
        default: true,
        required: false,
    },
    fluid: {
        type: Boolean,
        default: false,
        required: false,
    },
});
</script>

<template>
    <main class="-mt-32 h-full">
        <div class="mx-auto  px-4 pb-2 sm:px-6 lg:px-8 h-full">
            <div class="rounded-lg bg-white dark:bg-surface-900 px-2 py-6 shadow sm:px-6 h-full">
                <slot />
            </div>
        </div>
    </main>

</template>
