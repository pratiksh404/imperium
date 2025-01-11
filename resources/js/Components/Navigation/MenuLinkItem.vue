<template>
    <!-- Menu Link Item -->
    <Link :href="item.url" v-ripple
        class="flex items-center justify-between cursor-pointer px-4 py-3 rounded text-surface-700 0 dark:text-surface-0 no-underline  duration-150 transition-colors p-ripple">
    <div>
        <i :class="item.icon" class="mr-2"></i>
        <span :class="active ? 'font-bold' : 'font-medium'">{{ item.label }}</span>
    </div>
    <span v-if="item.badge"
        class="inline-flex items-center justify-center ml-2 bg-primary text-primary-contrast rounded-full "
        style="min-width: 1.3rem; height: 1.3rem; font-size: 12px;">{{ item.badge }}</span>
    </Link>
</template>
<script setup>
const props = defineProps({
    item: {
        type: Object,
        required: true
    },
    active: {
        type: Boolean,
        default: false
    }
})
</script>
