<template>
    <Button icon="pi pi-user" variant="text" rounded aria-label="User" @click="toggleUserMenu($event)" />
    <Popover ref="userMenu" :pt="{ root: { class: 'p-0 m-0' }, content: { class: 'p-0 m-0' } }">
        <Menu :pt="{ root: { class: 'border-none' } }" :model="items">
            <template #item="{ item, props }">
                <Link :href="item.route" v-ripple class="flex items-center" v-bind="props.action">
                <span :class="item.icon" />
                <span>{{ item.label }}</span>
                <Badge v-if="item.badge" class="ml-auto" :value="item.badge" />
                <span v-if="item.shortcut"
                    class="ml-auto border border-surface rounded bg-emphasis text-muted-color text-xs p-1">{{
                        item.shortcut }}</span>
                </Link>
            </template>
        </Menu>

    </Popover>
</template>
<script setup>
import { ref } from 'vue';
const props = defineProps({
    items: {
        type: Object,
        required: true
    }
})

const userMenu = ref();

const toggleUserMenu = (event) => {
    userMenu.value.toggle(event);
};
</script>
<style></style>