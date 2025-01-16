<template>
    <DataTable :value="showTrash ? (trashedData.length > 0 ? trashedData : data) : data" ref="dt"
        :scrollable="scrollable" :scrollHeight="scrollHeight" :paginator="paginator" :rows="rows"
        :rowsPerPageOptions="rowsPerPageOptions" :loading="loading" filterDisplay="row" :filters="filters"
        :global-filter-fields="globalFilterFields" v-model:selection="selectedData" selectionMode="multiple"
        :metaKeySelection="metaKey" :dataKey="dataKey" @rowReorder="onRowReorder" @dragstart="showActions = false"
        @dragover="showActions = true" tableStyle="min-width: 50rem" :pt="{
            root: {
                class: 'p-datatable-sm h-full',
            }
        }" class="imperium-table">
        <template #header>
            <Menubar :model="menuItems" :pt="{
                root: {
                    class: 'p-0 m-0 border-none flex justify-between',
                },
            }">
                <template #start>

                    <IconField v-if="searchable">
                        <InputIcon>
                            <i class="pi pi-search" />
                        </InputIcon>
                        <InputText v-model="filters['global'].value" placeholder="Keyword Search" fluid
                            class="w-full" />
                    </IconField>

                </template>
                <template #item="{ item, props, hasSubmenu, root }">
                    <a v-ripple class="flex items-center" :class="`text-${item.severity}`" v-bind="props.action"
                        v-if="item.visible">
                        <span :class="item.icon" />
                        <span v-if="item.label">{{ item.label }}</span>
                        <Badge v-if="item.badge" :class="{ 'ml-auto': !root, 'ml-2': root }" :value="item.badge" />
                        <span v-if="item.shortcut"
                            class="ml-auto border border-surface rounded bg-emphasis text-muted-color text-xs p-1">{{
                                item.shortcut }}</span>
                        <i v-if="hasSubmenu"
                            :class="['pi pi-angle-down ml-auto', { 'pi-angle-down': root, 'pi-angle-right': !root }]"></i>
                    </a>
                </template>
            </Menubar>
        </template>
        <template #empty> No {{ pluralize(name).toLowerCase() }} found. </template>

        <Column :rowReorder="canReorder" headerStyle="width: 3rem" />
        <Column v-for="col of columns" :key="col.field" :field="col.field" :header="col.label"></Column>

        <Column v-if="showActions" header="Action" :exportable="false" style="width: 10%">
            <template #body="slotProps">
                <div class="flex justify-end gap-2">
                    <div v-if="actionComponents.length > 0 && slotProps.data.deleted_at === null">
                        <div v-for="(actionComponent, index) of actionComponents">
                            <component :is="actionComponent" :data="slotProps.data"
                                :key="index + '-custom-action-' + slotProps.data.id" />
                        </div>
                    </div>
                    <ActionButtons :data="slotProps.data" :name="name" :url="pluralize(name).toLowerCase()"
                        :module-form="moduleForm" :key="name.toLowerCase() + '-action' + slotProps.data.id" />
                </div>
            </template>
        </Column>
    </DataTable>
</template>

<script>
export default {
    name: "ModuleTable"
}
</script>
<script setup>
import ActionButtons from '@/Components/Modules/ActionButtons.vue';
import { FilterMatchMode } from '@primevue/core/api';
import { router, usePage } from '@inertiajs/vue3';
import { useConfirm } from "primevue/useconfirm";
import { pluralize } from '@/Utils/Resource/Pluralize';
import ResourceForm from '@/Components/Form/ResourceForm.vue';
import { useToast } from "primevue/usetoast";

const toast = useToast();

import { ref, computed, defineProps } from 'vue';

// Data table Properties
const confirm = useConfirm();
const loading = ref(false);
const selectedData = ref();
const showActions = ref(true);
const metaKey = ref(false);
const dt = ref();
const showTrash = ref(false);

const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS }
})


const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    data: {
        type: Object,
        required: true
    },
    trashedData: {
        type: Object,
        required: false,
        default: []
    },
    moduleForm: {
        type: Object,
        required: false,
        default: ResourceForm
    },
    actionComponents: {
        type: Object,
        required: false,
        default: []
    },
    actionLinks: {
        type: Object,
        required: false,
        default: () => ({})
    }
})

// Table Configuration
const resource = computed(() => usePage().props.resources[props.name]);
const configurations = computed(() => Object.keys(resource.value.dataTable).length > 0 ? resource.value.dataTable : []).value;
const configurations_length = computed(() => Object.keys(configurations).length);
const columns = configurations_length.value > 0 ? configurations.columns : [];
const dataKey = configurations_length.value > 0 ? configurations.dataKey : 'id';
const scrollable = configurations_length.value > 0 ? configurations.scrollable : true;
const scrollHeight = configurations_length.value > 0 ? configurations.scrollHeight : '70vh';
const paginator = configurations_length.value > 0 ? configurations.paginator : true;
const rowsPerPageOptions = configurations_length.value > 0 ? configurations.rowsPerPageOptions : [5, 10, 20, 50];
const rows = configurations_length.value > 0 ? rowsPerPageOptions[0] : 5;
const globalFilterFields = Object.keys(columns).length > 0 ? columns.filter(column => column.searchable).map(column => column.field) : [];
const bulkDeletable = configurations_length.value > 0 ? configurations.bulkDeletable : true;
const searchable = configurations_length.value > 0 ? configurations.searchable : true;
const exportable = configurations_length.value > 0 ? configurations.exportable : true;
const canReorder = configurations_length.value > 0 ? configurations.canReorder : true;
const pooling = computed(() => configurations_length.value > 0 ? configurations.pooling : false);
const exportCSV = () => {
    dt.value.exportCSV();
};

const menuItems = computed(() => [
    {
        label: 'Export',
        icon: 'pi pi-download',
        visible: exportable,
        command: () => exportCSV()
    },
    {
        label: showTrash.value ? 'Permanently Delete' : 'Bulk Delete',
        icon: 'pi pi-trash',
        visible: selectedData.value && selectedData.value.length > 0 && bulkDeletable,
        command: (event) => bulkDelete(event)
    }, {
        label: showTrash.value ? 'Back To List' : 'Trash',
        icon: showTrash.value ? 'pi pi-list' : 'pi pi-trash',
        visible: props.trashedData.length > 0,
        command: () => showTrash.value = !showTrash.value
    }
]);



const onRowReorder = (event) => {
    router.patch(route('reorder', props.name.toLowerCase()), {
        ids: event.value.map(data => data.id)
    }, {
        preserveState: false,
        preserveScroll: false,
        onBefore: () => {
            loading.value = true
        },
        onSuccess: page => {
            toast.add({ severity: 'success', summary: 'Success', detail: 'Reordered successfully', life: 3000 });
        },
        onError: errors => {
            toast.add({ severity: 'error', summary: 'Error', detail: 'Error reordering', life: 3000 });
        },
        onFinish: () => {
            loading.value = false
        }
    });
}


const bulkDelete = (event) => {
    confirm.require({
        target: event.currentTarget,
        message: `Are you sure you want to delete these ${selectedData.value.length} records?`,
        icon: 'pi pi-exclamation-triangle',
        rejectProps: {
            label: 'Cancel',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Yes Delete It',
            severity: 'danger'
        },
        accept: () => {
            router.delete(route('bulk-delete', props.name.toLowerCase()), {
                data: {
                    ids: selectedData.value.map(data => data.id)
                },
                preserveState: false,
                preserveScroll: false,
                onBefore: () => {
                    loading.value = true
                },
                onSuccess: page => {
                    toast.add({ severity: 'success', summary: 'Success', detail: `${selectedData.value.length} records deleted successfully`, life: 3000 });
                    selectedData.value = null
                },
                onError: errors => {
                    errors.forEach(error => {
                        toast.add({ severity: 'error', summary: 'Error', detail: error, life: 3000 });
                    })
                },
                onFinish: () => {
                    loading.value = false
                }
            });
        },
        reject: () => {
            toast.add({ severity: 'info', summary: 'Info', detail: props.name + ' delete canceled', life: 3000 });
        }
    });
};

</script>

<style>
.imperium-table .p-paginator {
    position: absolute;
    bottom: 0;
    width: 100%;
}
</style>