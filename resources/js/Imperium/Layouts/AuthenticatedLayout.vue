<template>
  <div>
    <!-- Mobile sidebar start -->
    <TransitionRoot as="div" :show="sidebarOpen">
      <Dialog class="relative z-50 lg:hidden" @close="sidebarOpen = false">
        <TransitionChild
          as="template"
          enter="transition-opacity ease-linear duration-300"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="transition-opacity ease-linear duration-300"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <div class="fixed inset-0 bg-gray-500/75 dark:bg-black/75" />
        </TransitionChild>

        <div class="fixed inset-0 flex">
          <TransitionChild
            as="template"
            enter="transition ease-in-out duration-300 transform"
            enter-from="-translate-x-full"
            enter-to="translate-x-0"
            leave="transition ease-in-out duration-300 transform"
            leave-from="translate-x-0"
            leave-to="-translate-x-full"
          >
            <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
              <TransitionChild
                as="template"
                enter="ease-in-out duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="ease-in-out duration-300"
                leave-from="opacity-100"
                leave-to="opacity-0"
              >
                <div
                  class="absolute top-0 left-full flex w-16 justify-center pt-5"
                >
                  <button
                    type="button"
                    class="-m-2.5 p-2.5"
                    @click="sidebarOpen = false"
                  >
                    <span class="sr-only">Close sidebar</span>
                    <XMarkIcon
                      class="size-6 text-white dark:text-white"
                      aria-hidden="true"
                    />
                  </button>
                </div>
              </TransitionChild>
              <!-- Sidebar component -->
              <div
                class="flex grow flex-col gap-y-5 overflow-y-auto bg-white dark:bg-black px-6 pb-4 ring-1 ring-gray-200 dark:ring-white/10"
              >
                <div class="flex h-16 w-100 object-cover shrink-0 items-center">
                  <ApplicationLogo />
                </div>
                <!-- Side Menu Start -->
                <SideMenu :collapsed="collapsed" />
                <!-- Side Menu End -->
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </Dialog>
    </TransitionRoot>
    <!-- Mobile sidebar end -->

    <!-- Static sidebar for desktop -->
    <div
      :class="[
        'hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:flex-col',
        collapsed ? 'lg:w-20' : 'lg:w-72',
        'transition-all duration-300',
      ]"
    >
      <!-- Sidebar component -->
      <div
        class="flex grow flex-col gap-y-5 overflow-y-auto bg-white dark:bg-black px-6 pb-4 border-r border-gray-200 dark:border-gray-800"
      >
        <div class="flex h-16 my-1 shrink-0 items-center justify-between">
          <ApplicationLogo v-if="!collapsed" class="h-12 object-cover" />
          <button
            @click="toggleCollapsed"
            class="rounded-md p-1.5 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700"
            :class="
              collapsed
                ? 'ml-auto bg-gray-50 dark:bg-black group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold justify-center'
                : 'dark:bg-black'
            "
          >
            <span class="sr-only"
              >{{ collapsed ? "Expand" : "Collapse" }} sidebar</span
            >
            <ChevronRightIcon
              v-if="collapsed"
              class="size-5"
              aria-hidden="true"
            />
            <ChevronLeftIcon v-else class="size-5" aria-hidden="true" />
          </button>
        </div>
        <!-- Side Menu Start -->
        <SideMenu :collapsed="collapsed" />
        <!-- Side Menu End -->
      </div>
    </div>

    <div
      :class="[
        'transition-all duration-300',
        collapsed ? 'lg:pl-20' : 'lg:pl-72 ',
      ]"
    >
      <div
        class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8 dark:border-gray-700 dark:bg-black"
      >
        <button
          type="button"
          class="-m-2.5 p-1 text-gray-200 dark:text-gray-700 lg:hidden bg-black dark:bg-gray-200"
          @click="sidebarOpen = true"
        >
          <span class="sr-only">Open sidebar</span>
          <Bars3Icon class="size-6" aria-hidden="true" />
        </button>

        <!-- Separator -->
        <div
          class="h-6 w-px bg-gray-200 lg:hidden dark:bg-gray-700"
          aria-hidden="true"
        />
        <Header />
      </div>

      <main class="py-2">
        <div class="px-4 sm:px-6 lg:px-8">
          <MultiPageTabs />
          <Toast position="bottom-right" />
          <slot />
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Imperium/Components/ApplicationLogo.vue";
import SideMenu from "@/Imperium/Layouts/Partials/SideMenu.vue";
import Toast from "primevue/toast";
import Header from "@/Imperium/Layouts/Partials/Header.vue";
import MultiPageTabs from "@/Imperium/Layouts/Partials/MultiPageTabs.vue";
import {
  ChevronRightIcon,
  ChevronLeftIcon,
  Bars3Icon,
  XMarkIcon,
} from "@heroicons/vue/20/solid";
import {
  Dialog,
  DialogPanel,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";

const sidebarOpen = ref(false);
const collapsed = ref(false);

const toggleCollapsed = () => {
  collapsed.value = !collapsed.value;
};
</script>