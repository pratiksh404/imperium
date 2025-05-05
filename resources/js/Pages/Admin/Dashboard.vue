<template>
  <div>
    <!-- Mobile sidebar start -->
    <TransitionRoot as="div" :show="sidebarOpen">
      <Dialog class="relative z-50 lg:hidden" @close="sidebarOpen = false">
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0"
          enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
          leave-to="opacity-0">
          <div class="fixed inset-0 bg-gray-500/75 dark:bg-black/75" />
        </TransitionChild>

        <div class="fixed inset-0 flex">
          <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
            enter-from="-translate-x-full" enter-to="translate-x-0"
            leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
            leave-to="-translate-x-full">
            <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
              <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0"
                enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
                <div class="absolute top-0 left-full flex w-16 justify-center pt-5">
                  <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                    <span class="sr-only">Close sidebar</span>
                    <XMarkIcon class="size-6 text-white dark:text-white" aria-hidden="true" />
                  </button>
                </div>
              </TransitionChild>
              <!-- Sidebar component -->
              <div
                class="flex grow flex-col gap-y-5 overflow-y-auto bg-white dark:bg-black px-6 pb-4 ring-1 ring-gray-200 dark:ring-white/10">
                <div class="flex h-16 shrink-0 items-center">
                  <ApplicationLogo />
                </div>
                <nav class="flex flex-1 flex-col">
                  <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                      <ul role="list" class="-mx-2 space-y-1">
                        <li v-for="(item, index) in navigation" :key="item.name">
                          <a v-if="!item.children" :href="item.href"
                            :class="[item.current ? 'bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-white' : 'hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-400', 'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold']">
                            <component :is="item.icon" class="size-6 shrink-0 text-gray-400 dark:text-gray-500"
                              aria-hidden="true" />
                            {{ item.name }}
                          </a>
                          <Disclosure as="div" v-else v-slot="{ open }">
                            <DisclosureButton
                              :class="[item.current ? 'bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-white' : 'hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-400', 'flex w-full items-center gap-x-3 rounded-md p-2 text-left text-sm/6 font-semibold']">
                              <component :is="item.icon" class="size-6 shrink-0 text-gray-400 dark:text-gray-500"
                                aria-hidden="true" />
                              {{ item.name }}
                              <ChevronRightIcon
                                :class="[open ? 'rotate-90 text-gray-500 dark:text-gray-400' : 'text-gray-400 dark:text-gray-600', 'ml-auto size-5 shrink-0']"
                                aria-hidden="true" />
                            </DisclosureButton>
                            <DisclosurePanel as="ul" class="mt-1 px-2">
                        <li v-for="subItem in item.children" :key="subItem.name">
                          <!-- 44px -->
                          <DisclosureButton as="a" :href="subItem.href"
                            :class="[subItem.current ? 'bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-white' : 'hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-400', 'block rounded-md py-2 pr-2 pl-9 text-sm/6']">
                            {{ subItem.name }}</DisclosureButton>
                        </li>
                        </DisclosurePanel>
                        </Disclosure>
                    </li>
                  </ul>
                  </li>
                  <li>
                    <div class="text-xs/6 font-semibold text-gray-400 dark:text-gray-500">Your teams</div>
                    <ul role="list" class="-mx-2 mt-2 space-y-1">
                      <li v-for="team in teams" :key="team.name">
                        <a :href="team.href"
                          :class="[team.current ? 'bg-gray-50 dark:bg-gray-800 text-indigo-600' : 'text-gray-700 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-indigo-600 dark:hover:text-indigo-500', 'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold']">
                          <span
                            :class="[team.current ? 'border-indigo-600 text-indigo-600' : 'border-gray-200 dark:border-gray-700 text-gray-400 dark:text-gray-500 group-hover:border-indigo-600 dark:group-hover:border-indigo-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-500', 'flex size-6 shrink-0 items-center justify-center rounded-lg border bg-white dark:bg-gray-900 text-[0.625rem] font-medium']">
                            {{ team.initial }}
                          </span>
                          <span class="truncate">{{ team.name }}</span>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="-mx-6 mt-auto">
                    <a href="#"
                      class="flex items-center gap-x-4 px-6 py-3 text-sm/6 font-semibold text-gray-900 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800">
                      <img class="size-8 rounded-full bg-gray-50 dark:bg-gray-800"
                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt="" />
                      <span class="sr-only">Your profile</span>
                      <span aria-hidden="true">Tom Cook</span>
                    </a>
                  </li>
                  </ul>
                </nav>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </Dialog>
    </TransitionRoot>
    <!-- Mobile sidebar end -->

    <!-- Static sidebar for desktop -->
    <div :class="[
      'hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:flex-col',
      collapsed ? 'lg:w-20' : 'lg:w-72',
      'transition-all duration-300'
    ]">
      <!-- Sidebar component -->
      <div
        class="flex grow flex-col gap-y-5 overflow-y-auto bg-white dark:bg-black px-6 pb-4 border-r border-gray-200 dark:border-gray-800">
        <div class="flex h-16 my-1 shrink-0 items-center justify-between">
          <ApplicationLogo v-if="!collapsed" class="w-full object-cover" />
          <button @click="toggleCollapsed"
            class="rounded-md p-1.5 text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800"
            :class="collapsed ? 'ml-auto' : ''">
            <span class="sr-only">{{ collapsed ? 'Expand' : 'Collapse' }} sidebar</span>
            <ChevronRightIcon v-if="collapsed" class="size-5" aria-hidden="true" />
            <ChevronLeftIcon v-else class="size-5" aria-hidden="true" />
          </button>
        </div>
        <nav class="flex flex-1 flex-col">
          <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <li>
              <ul role="list" class="-mx-2 space-y-1">
                <li v-for="(item, index) in navigation" :key="item.name">
                  <a v-if="!item.children" :href="item.href" :class="[
                    item.current ? 'bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-white' : 'hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-400',
                    'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold',
                    collapsed ? 'justify-center' : ''
                  ]">
                    <component :is="item.icon" class="size-6 shrink-0 text-gray-400 dark:text-gray-500"
                      aria-hidden="true" />
                    <span v-if="!collapsed">{{ item.name }}</span>
                  </a>
                  <div v-else>
                    <button @click="() => toggleSubMenu(index)" :class="[
                      item.current ? 'bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-white' : 'hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-400',
                      'bg-transparent flex w-full items-center gap-x-3 rounded-md p-2 text-left text-sm/6 font-semibold',
                      collapsed ? 'justify-center' : ''
                    ]">
                      <component :is="item.icon" class="size-6 shrink-0 text-gray-400 dark:text-gray-500"
                        aria-hidden="true" />
                      <span v-if="!collapsed" class="flex-1">{{ item.name }}</span>
                      <ChevronRightIcon v-if="!collapsed"
                        :class="[openSubmenu === index ? 'rotate-90 text-gray-500 dark:text-gray-400' : 'text-gray-400 dark:text-gray-600', 'ml-auto size-5 shrink-0']"
                        aria-hidden="true" />
                    </button>
                    <transition enter-active-class="transition duration-200 ease-out"
                      enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100"
                      leave-active-class="transition duration-150 ease-in"
                      leave-from-class="transform scale-100 opacity-100" leave-to-class="transform scale-95 opacity-0">
                      <ul v-if="openSubmenu === index && !collapsed" class="mt-1 px-2">
                        <li v-for="subItem in item.children" :key="subItem.name">
                          <a :href="subItem.href"
                            :class="[subItem.current ? 'bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-white' : 'hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-400', 'block rounded-md py-2 pr-2 pl-9 text-sm/6']">
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
              <div class="text-xs/6 font-semibold text-gray-400 dark:text-gray-500">Your teams</div>
              <ul role="list" class="-mx-2 mt-2 space-y-1">
                <li v-for="team in teams" :key="team.name">
                  <a :href="team.href"
                    :class="[team.current ? 'bg-gray-50 dark:bg-gray-800 text-indigo-600' : 'text-gray-700 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-indigo-600 dark:hover:text-indigo-500', 'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold']">
                    <span
                      :class="[team.current ? 'border-indigo-600 text-indigo-600' : 'border-gray-200 dark:border-gray-700 text-gray-400 dark:text-gray-500 group-hover:border-indigo-600 dark:group-hover:border-indigo-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-500', 'flex size-6 shrink-0 items-center justify-center rounded-lg border bg-white dark:bg-gray-900 text-[0.625rem] font-medium']">
                      {{ team.initial }}
                    </span>
                    <span class="truncate">{{ team.name }}</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="-mx-6 mt-auto">
              <a href="#" :class="[
                'flex items-center py-3 text-sm/6 font-semibold text-gray-900 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800',
                collapsed ? 'justify-center px-3' : 'gap-x-4 px-6'
              ]">
                <img class="size-8 rounded-full bg-gray-50 dark:bg-gray-800"
                  src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                  alt="" />
                <span v-if="!collapsed" class="sr-only">Your profile</span>
                <span v-if="!collapsed" aria-hidden="true">Tom Cook</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>

    <div :class="['lg:pl-72 transition-all duration-300', collapsed ? 'lg:pl-20' : '']">
      <div
        class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8 dark:border-gray-700 dark:bg-black">
        <button type="button" class="-m-2.5 p-2.5 text-gray-700 dark:text-gray-200 lg:hidden"
          @click="sidebarOpen = true">
          <span class="sr-only">Open sidebar</span>
          <Bars3Icon class="size-6" aria-hidden="true" />
        </button>

        <!-- Separator -->
        <div class="h-6 w-px bg-gray-200 lg:hidden dark:bg-gray-700" aria-hidden="true" />

        <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
          <form class="grid flex-1 grid-cols-1" action="#" method="GET">
            <input type="search" name="search" aria-label="Search"
              class="col-start-1 row-start-1 block size-full bg-white pl-8 text-base text-gray-900 outline-hidden placeholder:text-gray-400 dark:bg-black dark:text-gray-200 sm:text-sm/6"
              placeholder="Search" />
            <MagnifyingGlassIcon class="pointer-events-none col-start-1 row-start-1 size-5 self-center text-gray-400"
              aria-hidden="true" />
          </form>
          <div class="flex items-center gap-x-4 lg:gap-x-6">
            <NavigationPalette />

            <RefreshButton />

            <ToggleDarkModeButton />
            <button type="button"
              class="-m-2.5 p-2.5 text-gray-500 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white dark:bg-black bg-white">
              <span class="sr-only">View notifications</span>
              <BellIcon class="size-6" aria-hidden="true" />
            </button>

            <!-- Separator -->
            <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-200 dark:lg:bg-gray-700" aria-hidden="true" />

            <!-- Profile dropdown -->
            <Menu as="div" class="relative">
              <MenuButton class="-m-1.5 flex items-center p-1.5 dark:bg-black bg-white">
                <span class="sr-only">Open user menu</span>
                <img class="size-8 rounded-full bg-gray-50 dark:bg-gray-800"
                  src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                  alt="" />
                <span class="hidden lg:flex lg:items-center">
                  <span class="ml-4 text-sm/6 font-semibold text-gray-900 dark:text-gray-200" aria-hidden="true">Tom
                    Cook</span>
                  <ChevronDownIcon class="ml-2 size-5 text-gray-400 dark:text-gray-400" aria-hidden="true" />
                </span>
              </MenuButton>
              <transition enter-active-class="transition ease-out duration-100"
                enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95">
                <MenuItems
                  class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-hidden dark:bg-black dark:shadow-gray-800 dark:ring-gray-700">
                  <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                  <a :href="item.href"
                    :class="[active ? 'bg-gray-50 dark:bg-gray-800 outline-hidden' : '', 'block px-3 py-1 text-sm/6 text-gray-700 dark:text-gray-200']">{{
                      item.name }}</a>
                  </MenuItem>
                </MenuItems>
              </transition>
            </Menu>
          </div>
        </div>
      </div>

      <main class="py-10">
        <div class="px-4 sm:px-6 lg:px-8">
          <!-- Your content -->
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import ApplicationLogo from "@/Imperium/Components/ApplicationLogo.vue";
import ToggleDarkModeButton from "@/Imperium/Components/ToggleDarkModeButton.vue";
import NavigationPalette from "@/Imperium/Components/Navigation/NavigationPalette.vue";
import RefreshButton from "@/Imperium/Components/Navigation/RefreshButton.vue";
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
  DisclosurePanel
} from '@headlessui/vue'
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
} from '@heroicons/vue/24/outline'
import { ChevronDownIcon, MagnifyingGlassIcon } from '@heroicons/vue/20/solid'

const navigation = [
  { name: 'Dashboard', href: '#', icon: HomeIcon, current: true },
  {
    name: 'Teams',
    icon: UsersIcon,
    current: false,
    children: [
      { name: 'Engineering', href: '#' },
      { name: 'Human Resources', href: '#' },
      { name: 'Customer Success', href: '#' },
    ],
  },
  {
    name: 'Projects',
    icon: FolderIcon,
    current: false,
    children: [
      { name: 'GraphQL API', href: '#' },
      { name: 'iOS App', href: '#' },
      { name: 'Android App', href: '#' },
      { name: 'New Customer Portal', href: '#' },
    ],
  },
  { name: 'Calendar', href: '#', icon: CalendarIcon, current: false },
  { name: 'Documents', href: '#', icon: DocumentDuplicateIcon, current: false },
  { name: 'Reports', href: '#', icon: ChartPieIcon, current: false },
]
const teams = [
  { id: 1, name: 'Heroicons', href: '#', initial: 'H', current: false },
  { id: 2, name: 'Tailwind Labs', href: '#', initial: 'T', current: false },
  { id: 3, name: 'Workcation', href: '#', initial: 'W', current: false },
]
const userNavigation = [
  { name: 'Your profile', href: '#' },
  { name: 'Sign out', href: '#' },
]

const sidebarOpen = ref(false)
const collapsed = ref(false)
const openSubmenu = ref(null)

const toggleCollapsed = () => {
  collapsed.value = !collapsed.value
}

const toggleSubMenu = (index) => {
  openSubmenu.value = openSubmenu.value === index ? null : index
}
</script>