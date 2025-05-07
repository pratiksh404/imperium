<template>
  <Drawer
    v-model:visible="visible"
    header="BREAD Permission"
    position="right"
    class="w-1/4"
  >
    <div
      v-if="Object.keys(modulesWithNoBread).length > 0"
      class="flex justify-end mb-2"
    >
      <Button
        class="mx-2"
        variant="text"
        size="small"
        raised
        label="Generate BREAD"
        @click="toggleModuleBreadGenerator"
      />

      <Popover ref="moduleBreadGenerator">
        <div class="flex flex-col gap-4">
          <div style="width: 20vw">
            <span class="font-medium block mb-2">Modules</span>
            <ul
              class="list-none p-0 m-0 flex flex-col"
              style="list-style: none"
            >
              <li
                v-for="(
                  moduleNamespace, moduleWithNoBread
                ) in modulesWithNoBread"
                :key="moduleWithNoBread"
                class="d-flex justify-content-between gap-2 px-2 py-3 hover:bg-emphasis cursor-pointer rounded-border"
                @click="generateBreadForModule(moduleNamespace)"
              >
                <div>
                  <span class="font-medium">{{ moduleWithNoBread }}</span>
                  <div class="text-sm text-surface-500 dark:text-surface-400">
                    {{ moduleNamespace }}
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </Popover>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full divide-y-2 divide-gray-200 text-sm">
        <thead class="ltr:text-left rtl:text-right">
          <tr>
            <th class="whitespace-nowrap px-4 py-2 font-medium">M</th>
            <th class="whitespace-nowrap px-4 py-2 font-medium">B</th>
            <th class="whitespace-nowrap px-4 py-2 font-medium">R</th>
            <th class="whitespace-nowrap px-4 py-2 font-medium">E</th>
            <th class="whitespace-nowrap px-4 py-2 font-medium">A</th>
            <th class="whitespace-nowrap px-4 py-2 font-medium">D</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
          <tr
            v-if="Object.keys(data.bread_for_modules).length > 0"
            v-for="(module, module_name) in data.bread_for_modules"
            :key="module"
          >
            <td class="whitespace-nowrap px-4 py-2 font-medium">
              {{ module_name }}
            </td>
            <td class="whitespace-nowrap px-4 py-2">
              <span
                style="cursor: pointer"
                :class="`pi pi-${
                  module['Browse']['active'] ? 'check' : 'times'
                } text-${module['Browse']['active'] ? 'success' : 'danger'}`"
                @click="toggleBreadPermission(module['Browse']['id'])"
              ></span>
            </td>
            <td class="whitespace-nowrap px-4 py-2">
              <span
                style="cursor: pointer"
                :class="`pi pi-${
                  module['Read']['active'] ? 'check' : 'times'
                } text-${module['Read']['active'] ? 'success' : 'danger'}`"
                @click="toggleBreadPermission(module['Read']['id'])"
              ></span>
            </td>
            <td class="whitespace-nowrap px-4 py-2">
              <span
                style="cursor: pointer"
                :class="`pi pi-${
                  module['Edit']['active'] ? 'check' : 'times'
                } text-${module['Edit']['active'] ? 'success' : 'danger'}`"
                @click="toggleBreadPermission(module['Edit']['id'])"
              ></span>
            </td>
            <td class="whitespace-nowrap px-4 py-2">
              <span
                style="cursor: pointer"
                :class="`pi pi-${
                  module['Add']['active'] ? 'check' : 'times'
                } text-${module['Add']['active'] ? 'success' : 'danger'}`"
                @click="toggleBreadPermission(module['Add']['id'])"
              ></span>
            </td>
            <td class="whitespace-nowrap px-4 py-2">
              <span
                style="cursor: pointer"
                :class="`pi pi-${
                  module['Delete']['active'] ? 'check' : 'times'
                } text-${module['Delete']['active'] ? 'success' : 'danger'}`"
                @click="toggleBreadPermission(module['Delete']['id'])"
              ></span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </Drawer>
  <Button
    variant="text"
    severity="info"
    raised
    size="small"
    @click="visible = true"
    v-tooltip.top="'BREAD Permission'"
  >
    <img src="@assets/images/bread.png" alt="bread permission" width="20"
  </Button>
</template>
<script setup>
import { defineProps, ref, computed } from "vue";
import { router } from "@inertiajs/vue3";
import { useToast } from "primevue/usetoast";
const toast = useToast();

const visible = ref(false);
const moduleBreadGenerator = ref();
const props = defineProps({
  data: {
    required: true,
    type: Object,
  },
});

const toggleBreadPermission = (id) => {
  router.post(route("roles.permission-toggle", [props.data.id, id]));
};

const modulesWithNoBread = computed(() => {
  return props.data.modules_with_no_bread ?? [];
});

const toggleModuleBreadGenerator = (event) => {
  moduleBreadGenerator.value.toggle(event);
};

const generateBreadForModule = (moduleNamespace) => {
  router.post(
    route("roles.generate-bread-for-module", [props.data.id]),
    {
      module_namespace: moduleNamespace,
    },
    {
      onSuccess: () => {
        toast.add({
          severity: "success",
          summary: "Success",
          detail: "BREAD generated",
          life: 3000,
        });
        moduleBreadGenerator.value.hide();
      },
      onError: () => {
        toast.add({
          severity: "error",
          summary: "Error",
          detail: "BREAD not generated",
          life: 3000,
        });
      },
    }
  );
};
</script>