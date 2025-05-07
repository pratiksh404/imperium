<template>
  <DataTable
    ref="dt"
    :pt="{
      root: {
        class: 'p-datatable-sm h-full',
      },
      header: {
        class: 'flex justify-end',
      },
    }"
    :value="
      showTrash
        ? props.trashedData?.length
          ? props.trashedData
          : props.data
        : props.data
    "
    :showGridlines="showGridlines"
    :stripedRows="stripedRows"
    :scrollable="scrollable"
    :scrollHeight="scrollHeight"
    :paginator="paginator"
    :rows="rows"
    :rowsPerPageOptions="rowsPerPageOptions"
    :loading="loading"
    :filterDisplay="'menu'"
    :filters="filters"
    :global-filter-fields="globalFilterFields"
    v-model:selection="selectedData"
    selectionMode="multiple"
    :metaKeySelection="false"
    :dataKey="dataKey"
    @rowReorder="onRowReorder"
    :tableStyle="'min-width: 50rem'"
    class="imperium-table"
  >
    <!-- Toolbar -->
    <template #header>
      <Menubar :model="menuItems" class="border-none p-0 m-0">
        <template #start>
          <IconField v-if="searchable">
            <InputIcon>
              <i class="pi pi-search" />
            </InputIcon>
            <InputText
              v-model="filters.global.value"
              placeholder="Keyword Search"
              class="w-full"
            />
          </IconField>
        </template>
      </Menubar>
    </template>

    <template #empty> No {{ pluralize(name).toLowerCase() }} found. </template>

    <!-- Reorder -->
    <Column v-if="canReorder" rowReorder headerStyle="width: 3rem" />

    <!-- Dynamic Columns -->
    <Column
      v-for="col in columns"
      :key="col.field"
      :field="col.field"
      :header="col.label"
      :sortable="col.sortable"
      style="min-width: 12rem"
    >
      <template #body="{ data }">
        {{ data.name }}
      </template>
      <template #filter="{ filterModel }">
        <InputText
          v-model="filterModel.value"
          type="text"
          :placeholder="'Search by ' + col.label"
        />
      </template>
    </Column>

    <!-- Action Column -->
    <Column
      v-if="showActions"
      header="Actions"
      :exportable="false"
      style="width: 12%"
    >
      <template #body="slotProps">
        <div class="flex justify-end gap-2">
          <component
            v-for="(actionComponent, index) in props.actionComponents"
            :key="index + '-custom-action-' + slotProps.data.id"
            :is="actionComponent"
            :data="slotProps.data"
          />
          <ActionButtons
            :data="slotProps.data"
            :name="props.name"
            :url="pluralize(props.name).toLowerCase()"
            :module-form="props.moduleForm"
            :key="props.name.toLowerCase() + '-action' + slotProps.data.id"
          />
        </div>
      </template>
    </Column>
  </DataTable>
</template>

<script setup>
import { ref, computed, defineProps } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import { FilterMatchMode, FilterOperator } from "@primevue/core";
import Menubar from "primevue/menubar";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import InputText from "primevue/inputtext";
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";
import ActionButtons from "@/Imperium/Components/Modules/ActionButtons.vue";
import { pluralize } from "@/Imperium/Utils/Resource/Pluralize";
import axios from "axios";
import { useServerRequest } from "@/Imperium/Composables/useServerRequest";
const toast = useToast();

const confirm = useConfirm();

const props = defineProps({
  name: String,
  data: Object,
  trashedData: { type: Object, default: () => [] },
  moduleForm: { type: Object, default: () => ({}) },
  actionComponents: { type: Array, default: () => [] },
  actionLinks: { type: Object, default: () => ({}) },
});

const showTrash = ref(false);
const selectedData = ref([]);
const loading = ref(false);
const showActions = ref(true);
const dt = ref();

const resource = computed(() => usePage().props.resources[props.name] || {});
const config = computed(() => resource.value.dataTable || {});

const columns = computed(() => config.value.columns || []);
const dataKey = config.value.dataKey || "id";
const scrollable = config.value.scrollable ?? true;
const scrollHeight = config.value.scrollHeight || "70vh";
const paginator = config.value.paginator ?? true;
const rowsPerPageOptions = config.value.rowsPerPageOptions || [5, 10, 25, 50];
const rows = rowsPerPageOptions[0];
const canReorder = config.value.canReorder ?? true;
const searchable = config.value.searchable ?? true;
const exportable = config.value.exportable ?? true;
const stripedRows = config.value.stripedRows ?? false;
const showGridlines = config.value.showGridlines ?? false;
const bulkDeletable = config.value.bulkDeletable ?? true;

const filters = ref();

const initFilters = (columns) => {
  const dynamicFilters = {
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  };

  columns.value.forEach((col) => {
    if (col.searchable) {
      dynamicFilters[col.field] = {
        operator: FilterOperator.AND,
        constraints: [
          {
            value: null,
            matchMode: FilterMatchMode.STARTS_WITH, // You can customize this per column type if needed
          },
        ],
      };
    }
  });

  filters.value = dynamicFilters;
};
initFilters(columns);

const globalFilterFields = computed(() =>
  columns.value.filter((col) => col.searchable).map((col) => col.field)
);

const exportCSV = () => {
  dt.value.exportCSV();
};

const clearFilter = () => {
  initFilters(columns);
};

const menuItems = computed(() => [
  {
    label: "Clear",
    icon: "pi pi-filter-slash",
    visible: true,
    command: clearFilter,
  },
  {
    label: "Export",
    icon: "pi pi-download",
    visible: exportable,
    command: exportCSV,
  },
  {
    label: showTrash.value ? "Permanently Delete" : "Bulk Delete",
    icon: "pi pi-trash",
    visible: selectedData.value.length > 0 && bulkDeletable,
    command: (event) => bulkDelete(event),
  },
  {
    label: showTrash.value ? "Back To List" : "Trash",
    icon: showTrash.value ? "pi pi-list" : "pi pi-trash",
    visible: props.trashedData.length > 0,
    command: () => (showTrash.value = !showTrash.value),
  },
]);

const refreshPage = () => {
  loading.value = true;
  router.reload({
    onFinish: () => {
      loading.value = false;
    },
  });
};

const onRowReorder = (event) => {
  const { post } = useServerRequest(toast);
  post(route("reorder", props.name.toLowerCase()), {
    ids: event.value.map((d) => d.id),
  });
};

const bulkDelete = (event) => {
  confirm.require({
    target: event.currentTarget,
    message: `Delete ${selectedData.value.length} records?`,
    icon: "pi pi-exclamation-triangle",
    acceptLabel: "Yes",
    rejectLabel: "Cancel",
    acceptClass: "p-button-danger",
    accept: () => {
      const { post } = useServerRequest(toast);
      post(route("bulk-delete", props.name.toLowerCase()), {
        ids: selectedData.value.map((d) => d.id),
      });
    },
    reject: () => {
      toast.add({
        severity: "info",
        summary: "Cancelled",
        detail: "Delete cancelled",
        life: 3000,
      });
    },
  });
};
</script>

<style scoped>
.imperium-table .p-paginator {
  position: absolute;
  bottom: 0;
  width: 100%;
}
</style>
