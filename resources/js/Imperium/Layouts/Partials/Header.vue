<template>
  <div class="bg-gray-800 pb-32">
    <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
      <div class="px-2 py-2 sm:px-3 flex justify-between md:items-center">
        <div class="flex items-center justify-between">
          <div class="flex justify-start gap-1">
            <Button
              class="flex lg:hidden mr-4"
              severity="secondary"
              icon="pi pi-bars"
              @click="$emit('open-nav')"
              :pt="{
                icon: {
                  class: 'text-xl',
                },
              }"
            />
            <div class="mx-auto sm:px-6 lg:px-8">
              <nav class="sm:hidden" aria-label="Back">
                <Button
                  @click="back"
                  label="Back"
                  text
                  icon="pi pi-arrow-left"
                  icon-pos="left"
                  :pt="{
                    icon: { class: 'text-white' },
                    label: { class: 'text-white' },
                  }"
                />
              </nav>
              <nav
                v-if="navItems"
                class="hidden sm:flex"
                aria-label="Breadcrumb"
              >
                <ol role="list" class="flex items-center space-x-4">
                  <li>
                    <div class="flex items-center">
                      <HomeIcon
                        class="h-5 w-5 flex-shrink-0 text-gray-500"
                        aria-hidden="true"
                      />
                      <Link
                        :href="route('dashboard')"
                        class="ml-4 text-sm font-medium text-gray-400 hover:text-gray-200"
                      >
                        Dashboard</Link
                      >
                    </div>
                  </li>
                  <li
                    v-for="(navItem, index) in navItems"
                    :key="'breadcrumb-item-' + index"
                  >
                    <div class="flex items-center">
                      <ChevronRightIcon
                        class="h-5 w-5 flex-shrink-0 mr-2 text-gray-500"
                        aria-hidden="true"
                      />
                      <Link
                        v-if="navItem.route"
                        :href="navItem.route"
                        class="text-sm font-medium text-gray-400 hover:text-gray-200 flex justify-start gap-1"
                      >
                        {{ navItem.label }}
                        <i
                          class="h-5 w-5 flex-shrink-0 text-gray-500"
                          v-if="navItem.icon"
                          :class="navItem.icon"
                        />
                      </Link>
                      <div v-else>
                        <span
                          class="text-sm font-medium text-gray-400 hover:text-gray-200 flex justify-start gap-1"
                        >
                          {{ navItem.label }}
                          <span
                            class="h-5 w-5 flex-shrink-0 text-gray-500"
                            v-if="navItem.icon"
                            :class="navItem.icon"
                          />
                        </span>
                      </div>
                    </div>
                  </li>
                </ol>
              </nav>
            </div>
          </div>
          <!-- Mobile menu button -->
          <div class="md:hidden">
            <div
              class="absolute right-3 top-0 z-50 w-max flex-col items-center gap-1 pt-2 group-hover:flex"
            >
              <Button
                icon="pi pi-arrow-down"
                rounded
                @click="toggleMobileMenu"
                type="button"
              />

              <transition name="fade">
                <div v-if="headerMobileMenu">
                  <RefreshButton :rounded="md" class="my-2" />

                  <ToggleDarkModeButton :rounded="md" class="my-2" />
                </div>
              </transition>
            </div>
          </div>
        </div>

        <!-- Mobile Menu -->
        <div class="hidden md:flex">
          <div class="flex flex-col md:flex-row gap-1">
            <NavigationPalette />

            <RefreshButton />

            <ToggleDarkModeButton />
          </div>
        </div>
      </div>
      <div class="mx-auto sm:px-6 lg:px-8">
        <div class="border-b border-gray-700">
          <div class="flex h-16 items-center justify-between px-4 sm:px-0">
            <div class="flex items-center">
              <div class="flex-shrink-0 md:hidden">
                <ApplicationLogo class="block h-9 w-auto" />
              </div>
              <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4">
                  <template
                    v-if="Object.values(appHeaderLinkMenuItems).length > 0"
                  >
                    <HeaderLinkItems
                      :items="appHeaderLinkMenuItems"
                      key="header_link_items"
                    />
                  </template>
                  <template
                    v-if="Object.values(appHeaderFlyoutMenuItems).length > 0"
                  >
                    <HeaderFlyoutItems
                      :items="appHeaderFlyoutMenuItems"
                      key="header_flyout_items"
                    />
                  </template>
                </div>
              </div>
            </div>
            <div class="hidden md:block">
              <div class="ml-4 flex items-center md:ml-6">
                <!-- TODO: Add User Notification Bell -->
                <!-- <button type="button"
                                    class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                    <span class="absolute -inset-1.5" />
                                    <span class="sr-only">View notifications</span>
                                    <BellIcon class="h-6 w-6" aria-hidden="true" />
                                </button> -->

                <!-- Profile dropdown -->
                <UserMenu :items="userMenuItems" />
              </div>
            </div>
            <div class="-mr-2 flex md:hidden">
              <!-- Mobile menu button -->
              <DisclosureButton
                class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
              >
                <span class="absolute -inset-0.5" />
                <span class="sr-only">Open main menu</span>
                <Bars3Icon
                  v-if="!open"
                  class="block h-6 w-6"
                  aria-hidden="true"
                />
                <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
              </DisclosureButton>
            </div>
          </div>
        </div>
      </div>

      <DisclosurePanel class="border-b border-gray-700 md:hidden">
        <div class="space-y-1 px-2 py-3 sm:px-3">
          <template v-if="Object.values(appHeaderLinkMenuItems).length > 0">
            <HeaderLinkItems
              :items="appHeaderLinkMenuItems"
              :mobile-mode="true"
            />
          </template>
          <DisclosureButton
            v-for="item in navigation"
            :key="item.name"
            as="a"
            :href="item.href"
            :class="[
              item.current
                ? 'bg-gray-900 text-white'
                : 'text-gray-300 hover:bg-gray-700 hover:text-white',
              'block rounded-md px-3 py-2 text-base font-medium',
            ]"
            :aria-current="item.current ? 'page' : undefined"
            >{{ item.name }}</DisclosureButton
          >
        </div>
        <div class="border-t border-gray-700 pb-3 pt-4">
          <UserMenu :items="userMenuItems" :expanded="true" />
        </div>
      </DisclosurePanel>
    </Disclosure>
  </div>
</template>
<script setup>
import ApplicationLogo from "@/Imperium/Components/ApplicationLogo.vue";
import ToggleDarkModeButton from "@/Imperium/Components/ToggleDarkModeButton.vue";
import NavigationPalette from "@/Imperium/Components/Navigation/NavigationPalette.vue";
import RefreshButton from "@/Imperium/Components/Navigation/RefreshButton.vue";
import UserMenu from "@/Imperium/Components/Navigation/UserMenu.vue";
import { usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { useWindowSize } from "@/Imperium/Composables/useWindowSize";
import HeaderLinkItems from "@/Imperium/Components/Header/HeaderLinkItems.vue";
import { useMenu } from "@/Imperium/Composables/useMenu";
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { Bars3Icon, XMarkIcon } from "@heroicons/vue/24/outline";
import HeaderFlyoutItems from "@/Imperium/Components/Header/HeaderFlyoutItems.vue";
import { ChevronRightIcon, HomeIcon } from "@heroicons/vue/24/outline";

const { windowSize, currentBreakpoint } = useWindowSize();

const props = defineProps({
  title: {
    type: String,
    required: false,
  },
  nav: {
    type: Array,
    required: false,
    default: () => [],
  },
});

const md = computed(() => windowSize.value.width <= 768);

const header = computed(() => usePage().props.header);
const headerTitle = computed(() => header.value?.title ?? "");
const breadcrumb = computed(() => header.value?.breadcrumb ?? null);
const breadcrumbItems = computed(() => breadcrumb.value?.items ?? []);
const headerPoints = computed(() => header.value?.points ?? []);

const pageTitle = computed(() => props.title ?? headerTitle.value ?? null);
const navItems = computed(() =>
  props.nav.length > 0 ? props.nav : breadcrumbItems.value
);

const appHeader = computed(() => usePage().props.appHeader);
const appHeaderNavigation = computed(() => appHeader.value.navigation ?? []);
const appHeaderLinkMenuItems = computed(() =>
  Object.values(appHeaderNavigation.value).length > 0
    ? appHeaderNavigation.value.headerLinkMenuItems ?? {}
    : {}
);
const appProfileMenuItems = computed(() =>
  Object.values(appHeaderNavigation.value).length > 0
    ? appHeaderNavigation.value.profileMenuItems ?? {}
    : {}
);
const appHeaderFlyoutMenuItems = computed(() =>
  Object.values(appHeaderNavigation.value).length > 0
    ? appHeaderNavigation.value.headerFlyoutMenuItems ?? {}
    : {}
);

const { menuItems: userMenuItems } = useMenu(appProfileMenuItems.value);

const headerMobileMenu = ref(false);

const toggleMobileMenu = () => {
  headerMobileMenu.value = !headerMobileMenu.value;
};

const back = () => {
  window.history.back();
};
</script>
