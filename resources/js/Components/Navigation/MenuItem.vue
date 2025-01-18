<template>
    <!-- Menu Item -->
    <li v-if="item.items">
        <MenuDropdownItems :item="item" :active="active" :collapsed="collapsed" />
    </li>
    <li v-else>
        <MenuLinkItem :item="item" :active="active" :collapsed="collapsed" />
    </li>

</template>

<script setup>
import { defineProps } from 'vue';
import MenuLinkItem from '@/Components/Navigation/MenuLinkItem.vue';
import MenuDropdownItems from '@/Components/Navigation/MenuDropdownItems.vue';
import { computed } from 'vue';
const props = defineProps({
    item: {
        type: Object,
        required: true
    },
    collapsed: {
        type: Boolean,
        required: false,
        default: false
    }
})

const hasActiveChild = (item) => {
    if (!item.items) return false;
    return item.items.some(child => child.active || hasActiveChild(child));
}

const active = computed(() => {
    return props.item.active || hasActiveChild(props.item);
})


</script>
