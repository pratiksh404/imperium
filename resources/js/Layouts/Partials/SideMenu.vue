<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import MenuItem from '@/Components/Navigation/MenuItem.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const page = usePage();

// Current Route
const currentRoute = route().current();

const menu = computed(() => page.props.menuItems ?? []);

const memoizedMenuItem = new Map();

const menuItem = (label, icon, url, badge, shortcut, items) => {
    const nodeKey = label;
    if (memoizedMenuItem.has(nodeKey)) {
        return memoizedMenuItem.get(nodeKey);
    }

    const nodeItems = items != null && items.length ? items.map(item => menuItem(item.label, item.icon, item.url, item.badge, item.shortcut, item.items)) : null;
    const isActive = route(currentRoute) === url;

    const menuItemObj = {
        key: nodeKey,
        label: label,
        icon: icon,
        url: url,
        badge: badge,
        shortcut: shortcut,
        active: isActive,
        items: nodeItems
    };

    memoizedMenuItem.set(nodeKey, menuItemObj);
    return menuItemObj;
};

const filterGroups = (data) => {
    return data.filter(grp => (grp.group ?? []).length > 0);
};

const memoizedGroupItems = new Map();

const mapGroupItems = (group) => {
    const groupKey = group.label;
    if (memoizedGroupItems.has(groupKey)) {
        return memoizedGroupItems.get(groupKey);
    }

    const newGroup = { ...group, group: group.group.map(item => menuItem(item.label, item.icon, item.url, item.badge, item.shortcut, item.items)) };
    memoizedGroupItems.set(groupKey, newGroup);
    return newGroup;
};

const menuGroups = computed(() => {
    const data = menu.value;
    return filterGroups(data).map(mapGroupItems);
});

const menuItems = computed(() => {
    const data = menu.value;
    return data.filter(grp => (grp.group ?? []).length === 0).map(item => menuItem(item.label, item.icon, item.url, item.badge, item.shortcut, item.items));
});


</script>


<template>
    <div class="flex flex-col">
        <div class="overflow-y-auto">
            <div class="hidden lg:block">
                <div class="flex justify-start px-6 py-4 shrink-0 ">
                    <Link :href="route('welcome')" class="mr-3">
                    <ApplicationLogo class="h-10 w-auto fill-current text-surface-900 dark:text-surface-0" />
                    </Link>
                    <Tag value="Primary">{{ page.props.app.name }}</Tag>
                </div>
            </div>
            <ul class="list-none p-0 mt-2" v-if="menuGroups.length > 0" v-for="(group, index) in menuGroups"
                :key="'group-' + index">
                <li>
                    <div v-ripple v-styleClass="{
                        selector: '@next',
                        enterFromClass: 'hidden',
                        enterActiveClass: 'animate-slideDown',
                        leaveToClass: 'hidden',
                        leaveActiveClass: 'animate-slideUp'
                    }"
                        class="px-4 mb-2 flex items-center justify-between text-surface-500 dark:text-surface-400 cursor-pointer p-ripple">
                        <span class="font-medium">{{ group.label }}</span>
                        <i class="pi pi-chevron-down"></i>
                    </div>
                    <ul class="list-none px-2 m-0 overflow-hidden" v-if="group.group.length > 0">
                        <MenuItem v-for="(item, group_item_key) in group.group"
                            :key="'group-' + index + '-item-' + group_item_key" :item="item" />
                    </ul>
                </li>
            </ul>
            <ul class="list-none px-2 m-0 overflow-hidden" v-if="menuItems.length > 0">
                <MenuItem v-for="(item, item_key) in menuItems" :key="'menuitem-' + item_key" :item="item" />
            </ul>
        </div>
        <div class="mt-auto fixed bottom-0 bg-white dark:bg-surface-900 h-20">
            <a v-ripple
                class="mx-3 my-1 flex items-center cursor-pointer p-4 gap-2 rounded text-surface-700  dark:text-surface-0  duration-150 transition-colors p-ripple">
                <Avatar image="https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png" shape="circle" />
                <span class="font-bold">Amy Elser</span>
            </a>
        </div>
    </div>
</template>
