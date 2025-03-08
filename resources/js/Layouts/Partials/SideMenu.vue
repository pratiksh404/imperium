<script setup>
import { computed, ref, defineEmits } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useMenu } from "@/Composables/useMenu";
import MenuItem from "@/Components/Navigation/MenuItem.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

const collapsed = ref(false);

const initialCollapsed = ref(false);

const emit = defineEmits(["isCollapsed"]);

const page = usePage();

const menu = computed(() => page.props.menuItems ?? []);

const user = computed(() => page.props.auth.user ?? null);

const { menuItems, menuGroups } = useMenu(menu);

const initialCollapseToggle = () => {
  collapseToggle(!initialCollapsed.value);
  initialCollapsed.value = collapsed.value;
};
const collapseToggle = (collapse) => {
  collapsed.value = collapse ?? !collapsed.value;
  emit("isCollapsed", collapsed.value);
};

const collapseMouseOver = () => {
  if (initialCollapsed.value && collapsed.value) {
    collapseToggle(false);
  }
};

const collapseMouseLeave = () => {
  if (initialCollapsed.value && !collapsed.value) {
    collapseToggle(true);
  }
};
</script>
<template>
  <div class="flex flex-col" :class="{ 'w-16': collapsed }" @mouseover="collapseMouseOver"
    @mouseleave="collapseMouseLeave">
    <div class="overflow-y-auto">
      <div class="hidden lg:block">
        <div class="flex w-full py-4 shrink-0" :class="collapsed ? 'px-4 justify-center' : 'justify-between px-6'">
          <Link :href="route('welcome')">
          <ApplicationLogo class="h-10 w-auto fill-current text-surface-900 dark:text-surface-0" />
          </Link>
          <Button :icon="'pi pi-arrow-' + (initialCollapsed ? 'right' : 'left')" text @click="initialCollapseToggle"
            v-if="!collapsed" />
        </div>
      </div>
      <template v-if="menuGroups.length > 0">
        <ul class="list-none px-2 mt-2" v-for="(group, index) in menuGroups" :key="'group-' + index">
          <li>
            <div
              class="px-4 mb-2 flex items-center justify-between text-surface-500 dark:text-surface-400 cursor-pointer p-ripple">
              <i class="pi pi-ellipsis-h p-2" v-tooltip="group.label" v-if="collapsed"></i>
              <span v-else class="font-medium">{{ group.label }}</span>
            </div>
            <ul class="list-none ml-4 m-0 overflow-hidden" v-if="group.group.length > 0">
              <MenuItem :collapsed="collapsed" v-for="(item, group_item_key) in group.group"
                :key="'group-' + index + '-item-' + group_item_key" :item="item" />
            </ul>
          </li>
        </ul>
      </template>
      <ul class="list-none ml-2 px-2 m-0 overflow-hidden" v-if="menuItems.length > 0">
        <MenuItem :collapsed="collapsed" v-for="(item, item_key) in menuItems" :key="'menuitem-' + item_key"
          :item="item" />
      </ul>
    </div>
    <div v-if="user" class="mt-auto fixed bottom-0 bg-white dark:bg-surface-900 flex justify-between"
      :class="{ 'w-16': collapsed }">
      <Link :href="route('profile.edit')" v-ripple
        class="mx-3 my-1 flex items-center cursor-pointer p-4 gap-2 rounded text-surface-700 dark:text-surface-0 duration-150 transition-colors p-ripple no-underline">
      <Avatar class="mr-2" :image="user.avatar" shape="circle" size="small" />
      <div v-if="!collapsed">
        <span class="font-bold">{{ user.name }} -
          <span class="font-light text-sm">{{
            user.role?.name ?? "Guest"
            }}</span></span>
        <div class="text-sm text-surface-500 dark:text-surface-400">
          {{ user.email }}
        </div>
      </div>
      </Link>
      <Link v-if="!collapsed" :href="route('logout')" method="post" as="button" v-ripple v-tooltip="'Logout'"
        class="mx-3 my-1 flex items-center cursor-pointer p-4 gap-2 rounded duration-150 transition-colors p-ripple no-underline bg-transparent">
      <i class="pi pi-sign-out"></i>
      </Link>
    </div>
  </div>
</template>
