import { defineStore } from "pinia";
import api from "@/api";
export const useMenusStore = defineStore("menus", {
    state: () => ({
        items: [
            menuItem("Imperium"),
            menuItem("Dashboard", "bx bx-home-circle", "dashboard"),
            menuItem("Roles", "bx bx-user", "roles.index"),
        ],
    }),
    getters: {
        all: (state) => state.items,
        byName: (state) => (name) => state.menus.find((m) => m.name === name),
    },
    actions: {
        async fetchMenus() {
            try {
                const response = await api.get("/menus");
                this.items = response.data.each((menu) => menuItem(menu.name, 'bx bx-radio-circle', menu.route,));
            } catch (error) {
                console.error(error);
            }
        }
    }
})

function menuItem(name, icon = 'bx bx-radio-circle', route = null, children = null) {
    return {
        name: name,
        icon: icon,
        route: route,
        class: route !== null ? "menu-item" : "menu-title",
        children: children !== null ? children.map(child =>
            createMenuItem(child.label, child.icon, child.route, child.children)
        ) : null,
    }
}