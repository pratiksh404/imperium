<template>
    <PanelMenu :pt="{
        root: {
            class: 'p-0 m-0 gap-1',
        },
        panel: {
            class: 'p-0 border-0',
        },
        header: {
            class: 'p-0 border-0',
        },
        itemContent: {
            class: 'gap-1',
        },
    }">
        <template #item="{ item }">
            <a v-ripple class="flex items-center px-4  cursor-pointer group" :class="item.active || hasActiveChild(item)
                ? 'font-bold text-primary'
                : 'text-surface-700 dark:text-surface-0'
                ">
                <Link :href="item.url" v-if="item.url" class="no-underline w-full" :class="item.active
                    ? 'font-bold text-primary'
                    : 'text-surface-700 dark:text-surface-0'
                    ">
                <span :class="[item.icon, 'text-primary group-hover:text-inherit']" />
                <span :class="['ml-2', { 'font-semibold': item.items }]">{{ item.label }}</span>
                <Badge v-if="item.badge" class="ml-auto" :value="item.badge" />
                <span v-if="item.shortcut"
                    class="ml-auto border border-surface rounded bg-emphasis text-muted-color text-xs p-1">{{
                        item.shortcut }}</span>
                </Link>
                <div class="flex justify-between w-full" v-else>
                    <div>
                        <span :class="[item.icon, 'text-primary group-hover:text-inherit']" />

                        <span :class="['ml-2', { 'font-semibold': item.items }]">{{ item.label }}</span>
                    </div>
                    <div class="gap-1">
                        <Badge v-if="item.badge" class="ml-auto" :value="item.badge" />
                        <i class="pi pi-angle-down"></i>
                    </div>

                </div>
            </a>
        </template>
    </PanelMenu>
</template>

<script>
export default {
    methods: {
        hasActiveChild(item) {
            if (!item.items) return false;
            return item.items.some(child => child.active || this.hasActiveChild(child));
        }
    }
}
</script>
