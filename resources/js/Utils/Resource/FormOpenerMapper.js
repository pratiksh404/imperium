import { Drawer, Dialog } from "primevue";

export function resolveFormOpenerComponent(openerType) {
    const componentMap = {
        drawer: Drawer,
        dialog: Dialog
    };
    return componentMap[openerType] || Drawer;
}