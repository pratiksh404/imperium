<template>
  <DataTable ref="dt" :pt="{
    root: {
      class: 'p-datatable-sm h-full',
    },
    header: {
      class: 'flex justify-end',
    },
  }" :value="showTrash
    ? props.trashedData?.length
      ? props.trashedData
      : props.data
    : props.data
    " :showGridlines="showGridlines" :stripedRows="stripedRows" :scrollable="scrollable" :scrollHeight="scrollHeight"
    :paginator="paginator" :rows="rows" :rowsPerPageOptions="rowsPerPageOptions" :loading="loading" filterDisplay="menu"
    :filters="filters" :globalFilterFields="globalFilterFields" v-model:selection="selectedData"
    selectionMode="multiple" :metaKeySelection="false" :dataKey="dataKey" @rowReorder="onRowReorder"
    :tableStyle="'min-width: 50rem'" class="imperium-table">
    <!-- Toolbar -->
    <template #header>
      <div class="flex w-full justify-between">
        <!-- Global Search -->
        <div v-if="searchable" class="w-96">
          <IconField>
            <InputIcon class="pi pi-search" />
            <InputText v-model="filters['global'].value" placeholder="Search..." class="w-full" />
          </IconField>
        </div>

        <!-- Menu Actions -->
        <Menubar :model="menuItems" class="border-none p-0 m-0" />
      </div>
    </template>

    <template #empty> No {{ pluralize(props.name).toLowerCase() }} found. </template>

    <!-- Reorder -->
    <Column v-if="canReorder" rowReorder headerStyle="width: 3rem" />

    <!-- Dynamic Columns -->
    <Column v-for="col in visibleColumns" :key="col.field" :field="col.field" :header="col.label"
      :sortable="col.sortable !== false" :filter="col.searchable !== false" :filterMatchMode="FilterMatchMode.CONTAINS"
      :showFilterMenu="col.searchable !== false" :filterPlaceholder="`Search by ${col.label}`" style="min-width: 12rem">
      <template #body="{ data }">
        {{ data[col.field] }}
      </template>
      <template #filter="{ filterModel, filterCallback }">
        <InputText v-model="filterModel.value" type="text" class="p-column-filter w-full" placeholder="Search by name"
          @keydown.enter="filterCallback()" />
        <div class="flex justify-content-between align-items-center mt-2">
          <Button type="button" icon="pi pi-filter-fill" label="Filter" @click="filterCallback()" class="p-button-sm" />
          <Button type="button" icon="pi pi-times" label="Clear" class="p-button-outlined p-button-sm"
            @click="clearFilter(filterModel, filterCallback)" />
        </div>
      </template>
    </Column>

    <!-- Action Column -->
    <Column v-if="showActions" header="Actions" :exportable="false" style="width: 12%">
      <template #body="slotProps">
        <div class="flex justify-end gap-2">
          <component v-for="(actionComponent, index) in props.actionComponents"
            :key="index + '-custom-action-' + slotProps.data.id" :is="actionComponent" :data="slotProps.data" />
          <ActionButtons :data="slotProps.data" :name="props.name" :url="pluralize(props.name).toLowerCase()"
            :module-form="props.moduleForm" :key="props.name.toLowerCase() + '-action' + slotProps.data.id" />
        </div>
      </template>
    </Column>
  </DataTable>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import { FilterMatchMode, FilterOperator } from "@primevue/core";
import Menubar from "primevue/menubar";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";
import ActionButtons from "@/Imperium/Components/Modules/ActionButtons.vue";
import { pluralize } from "@/Imperium/Utils/Resource/Pluralize";
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

// Refs and state
const dt = ref();
const showTrash = ref(false);
const selectedData = ref([]);
const loading = ref(false);
const showActions = ref(true);
const filters = ref({
  global: { value: null, matchMode: FilterMatchMode.CONTAINS }
});

// Computed resources
const resource = computed(() => usePage().props.resources[props.name] || {});
const config = computed(() => resource.value.dataTable || {});

// Table configuration
const allColumns = computed(() => config.value.columns || []);
const visibleColumns = computed(() => allColumns.value.filter(col => !col.hidden));
const dataKey = computed(() => config.value.dataKey || "id");
const scrollable = computed(() => config.value.scrollable ?? true);
const scrollHeight = computed(() => config.value.scrollHeight || "70vh");
const paginator = computed(() => config.value.paginator ?? true);
const rowsPerPageOptions = computed(() => config.value.rowsPerPageOptions || [5, 10, 25, 50]);
const rows = computed(() => rowsPerPageOptions.value[0]);
const canReorder = computed(() => config.value.canReorder ?? true);
const searchable = computed(() => config.value.searchable ?? true);
const exportable = computed(() => config.value.exportable ?? true);
const stripedRows = computed(() => config.value.stripedRows ?? false);
const showGridlines = computed(() => config.value.showGridlines ?? false);
const bulkDeletable = computed(() => config.value.bulkDeletable ?? true);

// Global filter fields
const globalFilterFields = computed(() => {
  return visibleColumns.value
    .filter(col => col.searchable !== false)
    .map(col => col.field);
});

// Initialize filters
onMounted(() => {
  initFilters();
});

const initFilters = () => {
  const dynamicFilters = {
    global: { value: null, matchMode: FilterMatchMode.CONTAINS }
  };

  visibleColumns.value.forEach(col => {
    if (col.searchable !== false && col.field) {
      dynamicFilters[col.field] = { value: null, matchMode: FilterMatchMode.CONTAINS };
    }
  });

  filters.value = dynamicFilters;
};

// Clear a specific column filter
const clearFilter = (filterModel, callback) => {
  filterModel.value = null;
  callback();
};

// Menu items
const menuItems = computed(() => [
  {
    label: "Clear Filters",
    icon: "pi pi-filter-slash",
    command: () => {
      initFilters();
    },
  },
  {
    label: "Export",
    icon: "pi pi-download",
    visible: exportable.value,
    command: () => {
      if (dt.value) {
        dt.value.exportCSV();
      }
    },
  },
  {
    label: showTrash.value ? "Permanently Delete" : "Bulk Delete",
    icon: "pi pi-trash",
    visible: selectedData.value.length > 0 && bulkDeletable.value,
    command: (event) => bulkDelete(event),
  },
  {
    label: showTrash.value ? "Back To List" : "Trash",
    icon: showTrash.value ? "pi pi-list" : "pi pi-trash",
    visible: props.trashedData?.length > 0,
    command: () => (showTrash.value = !showTrash.value),
  },
]);

// Row reorder handler
const onRowReorder = (event) => {
  const { post } = useServerRequest(toast);
  post(route("reorder", props.name.toLowerCase()), {
    ids: event.value.map((d) => d.id),
  });
};

// Bulk delete handler
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

.imperium-table :deep(.p-column-filter-menu-button) {
  width: 2rem;
  height: 2rem;
}

.imperium-table :deep(.p-column-filter-overlay) {
  min-width: 280px;
}

.imperium-table :deep(.p-column-filter) {
  width: 100%;
}
</style>