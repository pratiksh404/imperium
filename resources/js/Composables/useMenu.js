import { computed, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

export function useMenu(initialMenu = []) {
    // Current Route
const currentRoute = route().current();
    const menu = ref(initialMenu); // Reactive menu data
    const memoizedMenuItem = new Map();
    const memoizedGroupItems = new Map();

    // Function to create a menu item
    const menuItem = (label, icon, url, type, badge, shortcut, items, authorize) => {
        const nodeKey = label;
        if (memoizedMenuItem.has(nodeKey)) {
            return memoizedMenuItem.get(nodeKey);
        }

        const nodeItems =
            items && items.length
                ? items.map((item) =>
                      menuItem(
                          item.label,
                          item.icon,
                          item.url,
                          item.type,
                          item.badge,
                          item.shortcut,
                          item.items,
                          item.authorize
                      )
                  )
                : null;

        const isActive = route(currentRoute) === url;

        const menuItemObj = {
            key: nodeKey,
            label,
            icon,
            url,
            type,
            badge,
            shortcut,
            active: isActive,
            items: nodeItems,
            authorize,
        };

        memoizedMenuItem.set(nodeKey, menuItemObj);
        return menuItemObj;
    };

    // Function to filter groups with items
    const filterGroups = (data) => {
        return data.filter((grp) => (grp.group ?? []).length > 0);
    };

    // Function to map group items
    const mapGroupItems = (group) => {
        const groupKey = group.label;
        if (memoizedGroupItems.has(groupKey)) {
            return memoizedGroupItems.get(groupKey);
        }

        const newGroup = {
            ...group,
            group: group.group.map((item) =>
                menuItem(
                    item.label,
                    item.icon,
                    item.url,
                    item.type,
                    item.badge,
                    item.shortcut,
                    item.items,
                    item.authorize
                )
            ),
        };

        memoizedGroupItems.set(groupKey, newGroup);
        return newGroup;
    };

    // Function to filter data based on authorization
    const authorizationFilter = (data) => {
        const authorizedData = data.filter((item) => item.authorize);
        authorizedData.forEach((item) => {
            if (item.items) {
                item.items = authorizationFilter(item.items);
            }
            if (item.group) {
                item.group = authorizationFilter(item.group);
            }
        });
        return authorizedData;
    };

    // Computed menu groups
    const menuGroups = computed(() => {
        const data = menu.value;
        return authorizationFilter(filterGroups(data).map(mapGroupItems));
    });

    // Computed menu items
    const menuItems = computed(() => {
        const data = menu.value;
        return authorizationFilter(
            data
                .filter((item) => (item.group ?? []).length === 0)
                .map((item) =>
                    menuItem(
                        item.label,
                        item.icon,
                        item.url,
                        item.type,
                        item.badge,
                        item.shortcut,
                        item.items,
                        item.authorize
                    )
                )
        );
    });

    return {
        menu,
        menuGroups,
        menuItems,
    };
}
