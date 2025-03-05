<template>
  <template v-if="(Object, values(items).length > 0)">
    <Popover
      class="relative"
      v-for="(flyover, flyoverIndex) in items"
      :key="'flyover-' + flyoverIndex"
    >
      <PopoverButton
        class="text-gray-300 hover:bg-gray-700 hover:text-white bg-transparent rounded-md px-3 py-2 text-sm font-medium cursor-pointer flex content-between"
      >
        <span>{{ flyover.label }}</span>
        <ChevronDownIcon class="size-5" aria-hidden="true" />
      </PopoverButton>

      <transition
        enter-active-class="transition ease-out duration-200"
        enter-from-class="opacity-0 translate-y-1"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition ease-in duration-150"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 translate-y-1"
      >
        <PopoverPanel class="absolute top-22 z-10 mt-5 flex w-screen max-w-max">
          <div
            class="w-screen max-w-md flex-auto overflow-hidden rounded-3xl bg-white dark:bg-surface-900 text-sm/6 ring-1 shadow-lg ring-gray-900/5"
          >
            <div
              class="p-4"
              v-if="Object.values(flyover?.items ?? {}).length > 0"
            >
              <div
                v-for="item in flyover.items"
                :key="'flyover-item-' + flyoverIndex + '-' + item.label"
                class="group relative flex gap-x-6 rounded-lg p-4"
              >
                <div
                  class="mt-1 flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 dark:bg-surface-900"
                >
                  <i
                    :class="item.icon"
                    class="size-6 p-1 text-gray-600 dark:text-white"
                    aria-hidden="true"
                  >
                  </i>
                </div>
                <div>
                  <component
                    :is="linkComponentResolver(item.type)"
                    :href="item.url"
                    v-bind="{
                      ...(item.type === 'url' ? { target: '_blank' } : {}),
                    }"
                    class="font-semibold text-gray-900 dark:text-white"
                  >
                    {{ item.label }}
                    <span class="absolute inset-0" />
                  </component>
                  <p class="mt-1 text-gray-600 dark:text-zinc-50">
                    {{ item.description }}
                  </p>
                </div>
              </div>
            </div>
            <div
              v-if="Object.values(flyover?.footer.items ?? {}).length > 0"
              class="grid grid-cols-2 divide-x divide-gray-900/5 bg-gray-50"
            >
              <component
                :is="linkComponentResolver(footerItem.type)"
                v-for="footerItem in flyover.footer.items"
                :key="footerItem.label"
                :href="footerItem.url"
                class="flex items-center justify-center gap-x-2.5 p-3 font-semibold text-gray-900"
              >
                <i
                  :class="footerItem.icon"
                  class="size-6 p-1 text-gray-600"
                  aria-hidden="true"
                >
                </i>
                {{ footerItem.label }}
              </component>
            </div>
          </div>
        </PopoverPanel>
      </transition>
    </Popover>
  </template>
</template>
  
  <script setup>
import { defineProps } from "vue";
import { useLinkComponentResolver } from "@/Composables/useLinkComponentResolver";
import { Popover, PopoverButton, PopoverPanel } from "@headlessui/vue";
import {
  ChevronDownIcon,
  PhoneIcon,
  PlayCircleIcon,
} from "@heroicons/vue/20/solid";
import {
  ArrowPathIcon,
  ChartPieIcon,
  CursorArrowRaysIcon,
  FingerPrintIcon,
  SquaresPlusIcon,
} from "@heroicons/vue/24/outline";
import { values } from "lodash";

const props = defineProps({
  items: {
    type: Object,
    required: true,
  },
});
console.log(props.items);
const linkComponentResolver = (type) => useLinkComponentResolver(type);
const solutions = [
  {
    label: "Analytics",
    description: "Get a better understanding of your traffic",
    href: "#",
    icon: ChartPieIcon,
  },
  {
    label: "Engagement",
    description: "Speak directly to your customers",
    href: "#",
    icon: CursorArrowRaysIcon,
  },
  {
    label: "Security",
    description: "Your customers' data will be safe and secure",
    href: "#",
    icon: FingerPrintIcon,
  },
  {
    label: "Integrations",
    description: "Connect with third-party tools",
    href: "#",
    icon: SquaresPlusIcon,
  },
  {
    label: "Automations",
    description: "Build strategic funnels that will convert",
    href: "#",
    icon: ArrowPathIcon,
  },
];
const callsToAction = [
  { label: "Watch demo", href: "#", icon: PlayCircleIcon },
  { label: "Contact sales", href: "#", icon: PhoneIcon },
];
</script>