<template>
  <nav class="flex flex-1 flex-col">
    <ul role="list" class="flex flex-1 flex-col gap-y-7">
      <template v-if="menuGroups.length > 0">
        <li v-for="(group, index) in menuGroups" :key="'group-' + index">
          <div class="text-xs/6 font-semibold text-gray-400 dark:text-gray-500">
            <span v-if="!collapsed">{{ group.label }}</span>
            <MinusIcon
              v-if="collapsed"
              class="size-6 shrink-0 text-gray-400 dark:text-gray-500"
            />
          </div>
          <ul role="list" class="-mx-2 space-y-1" v-if="group.group.length > 0">
            <ImperiumMenuItem
              :collapsed="collapsed"
              v-for="(item, group_item_key) in group.group"
              :key="'group-' + index + '-item-' + group_item_key"
              :item="item"
            />
          </ul>
        </li>
      </template>
      <template v-if="menuItems.length > 0">
        <li>
          <ul role="list" class="-mx-2 space-y-1">
            <ImperiumMenuItem
              :collapsed="collapsed"
              v-for="(item, item_key) in menuItems"
              :key="'menuitem-' + item_key"
              :item="item"
            />
          </ul>
        </li>
      </template>
      <li>
        <ul role="list" class="-mx-2 space-y-1">
          <li v-for="(item, index) in navigation" :key="item.name">
            <a
              v-if="!item.children"
              :href="item.href"
              :class="[
                item.current
                  ? 'bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-white'
                  : 'hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-400',
                'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold',
                collapsed ? 'justify-center' : '',
              ]"
            >
              <component
                :is="item.icon"
                class="size-6 shrink-0 text-gray-400 dark:text-gray-500"
                aria-hidden="true"
              />
              <span v-if="!collapsed">{{ item.name }}</span>
            </a>
            <div v-else>
              <button
                @click="() => toggleSubMenu(index)"
                :class="[
                  item.current
                    ? 'bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-white'
                    : 'hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-400',
                  'bg-transparent flex w-full items-center gap-x-3 rounded-md p-2 text-left text-sm/6 font-semibold',
                  collapsed ? 'justify-center' : '',
                ]"
              >
                <component
                  :is="item.icon"
                  class="size-6 shrink-0 text-gray-400 dark:text-gray-500"
                  aria-hidden="true"
                />
                <span v-if="!collapsed" class="flex-1">{{ item.name }}</span>
                <ChevronRightIcon
                  v-if="!collapsed"
                  :class="[
                    openSubmenu === index
                      ? 'rotate-90 text-gray-500 dark:text-gray-400'
                      : 'text-gray-400 dark:text-gray-700',
                    'ml-auto size-5 shrink-0',
                  ]"
                  aria-hidden="true"
                />
              </button>
              <transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="transform scale-95 opacity-0"
                enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="transform scale-100 opacity-100"
                leave-to-class="transform scale-95 opacity-0"
              >
                <ul
                  v-if="openSubmenu === index && !collapsed"
                  class="mt-1 px-2"
                >
                  <li v-for="subItem in item.children" :key="subItem.name">
                    <a
                      :href="subItem.href"
                      :class="[
                        subItem.current
                          ? 'bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-white'
                          : 'hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-400',
                        'block rounded-md py-2 pr-2 pl-9 text-sm/6',
                      ]"
                    >
                      {{ subItem.name }}
                    </a>
                  </li>
                </ul>
              </transition>
            </div>
          </li>
        </ul>
      </li>
      <li v-if="!collapsed">
        <div class="text-xs/6 font-semibold text-gray-400 dark:text-gray-500">
          Your teams
        </div>
        <ul role="list" class="-mx-2 mt-2 space-y-1">
          <li v-for="team in teams" :key="team.name">
            <a
              :href="team.href"
              :class="[
                team.current
                  ? 'bg-gray-50 dark:bg-gray-800 text-gray-700'
                  : 'text-gray-700 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-500',
                'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold',
              ]"
            >
              <span
                :class="[
                  team.current
                    ? 'border-gray-700 text-gray-700'
                    : 'border-gray-200 dark:border-gray-700 text-gray-400 dark:text-gray-500 group-hover:border-gray-700 dark:group-hover:border-gray-500 group-hover:text-gray-700 dark:group-hover:text-gray-500',
                  'flex size-6 shrink-0 items-center justify-center rounded-lg border bg-white dark:bg-gray-900 text-[0.625rem] font-medium',
                ]"
              >
                {{ team.initial }}
              </span>
              <span class="truncate">{{ team.name }}</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="-mx-6 mt-auto">
        <a
          href="#"
          :class="[
            'flex items-center py-3 text-sm/6 font-semibold text-gray-900 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800',
            collapsed ? 'justify-center px-3' : 'gap-x-4 px-6',
          ]"
        >
          <img
            class="size-8 rounded-full bg-gray-50 dark:bg-gray-800"
            src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
            alt=""
          />
          <span v-if="!collapsed" class="sr-only">Your profile</span>
          <span v-if="!collapsed" aria-hidden="true">Tom Cook</span>
        </a>
      </li>
    </ul>
  </nav>
</template>
<script setup>
import {
  Dialog,
  DialogPanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
} from "@headlessui/vue";
import {
  Bars3Icon,
  BellIcon,
  CalendarIcon,
  ChartPieIcon,
  Cog6ToothIcon,
  DocumentDuplicateIcon,
  FolderIcon,
  HomeIcon,
  UsersIcon,
  ChevronRightIcon,
  ChevronLeftIcon,
  XMarkIcon,
  MinusIcon,
} from "@heroicons/vue/24/outline";
import { ChevronDownIcon, MagnifyingGlassIcon } from "@heroicons/vue/20/solid";
import { ref, defineProps, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useMenu } from "@/Imperium/Composables/useMenu";
import ImperiumMenuItem from "@/Imperium/Components/Navigation/MenuItem.vue";
const props = defineProps({
  collapsed: {
    type: Boolean,
    default: false,
  },
});
const openSubmenu = ref(null);

const page = usePage();

const menu = computed(() => page.props.menuItems ?? []);

const user = computed(() => page.props.auth.user ?? null);

const { menuItems, menuGroups } = useMenu(menu);

const navigation = [
  { name: "Dashboard", href: "#", icon: HomeIcon, current: true },
  {
    name: "Teams",
    icon: UsersIcon,
    current: false,
    children: [
      { name: "Engineering", href: "#" },
      { name: "Human Resources", href: "#" },
      { name: "Customer Success", href: "#" },
    ],
  },
  {
    name: "Projects",
    icon: FolderIcon,
    current: false,
    children: [
      { name: "GraphQL API", href: "#" },
      { name: "iOS App", href: "#" },
      { name: "Android App", href: "#" },
      { name: "New Customer Portal", href: "#" },
    ],
  },
  { name: "Calendar", href: "#", icon: CalendarIcon, current: false },
  { name: "Documents", href: "#", icon: DocumentDuplicateIcon, current: false },
  { name: "Reports", href: "#", icon: ChartPieIcon, current: false },
];
const teams = [
  { id: 1, name: "Heroicons", href: "#", initial: "H", current: false },
  { id: 2, name: "Tailwind Labs", href: "#", initial: "T", current: false },
  { id: 3, name: "Workcation", href: "#", initial: "W", current: false },
];

const toggleSubMenu = (index) => {
  openSubmenu.value = openSubmenu.value === index ? null : index;
};
</script>
