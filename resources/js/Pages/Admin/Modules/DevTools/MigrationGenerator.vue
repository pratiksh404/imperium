<template>

    <Head title="Migration Generator" />
    <AuthenticatedLayout title="Migration Generator">
        <div class="flex h-full">
            <div class="w-full h-full p-3">
                <Card :pt="{
                    root: {
                        class: 'h-full p-2'
                    },
                    title: {
                        class: 'bg-black p-4 text-white'
                    }
                }">
                    <template #title>Migration Configuration</template>
                    <template #content>
                        <div class="mt-4">
                            <FloatLabel variant="on">
                                <InputText id="tableName" v-model="tableName" autocomplete="off" fluid size="large" />
                                <label for="tableName">Table Name</label>
                            </FloatLabel>
                        </div>

                        <div class="mt-4 mb-4">
                            <h3>Table Operation</h3>
                            <div class="flex flex-wrap gap-4 mt-4">
                                <div class="flex items-center gap-2">
                                    <RadioButton v-model="tableOperation" inputId="tableOperation1" value="create" />
                                    <label for="tableOperation1">Create</label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <RadioButton v-model="tableOperation" inputId="tableOperation2" value="drop" />
                                    <label for="tableOperation2">Drop</label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <RadioButton v-model="tableOperation" inputId="tableOperation3" value="rename" />
                                    <label for="tableOperation3">Rename</label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <RadioButton v-model="tableOperation" inputId="tableOperation4" value="modify" />
                                    <label for="tableOperation4">Modify</label>
                                </div>
                            </div>
                        </div>
                        <Divider />
                        <div class="mt-4">
                            <div class="flex justify-between">
                                <h3>Fields</h3>
                                <Button label="Add Field" icon="pi pi-plus" size="small"
                                    @click="toggleFieldDrawer = !toggleFieldDrawer" />
                            </div>
                            <DataTable :value="columnFields" tableStyle="min-width: 50rem">
                                <Column field="name" header="Name"></Column>
                                <Column field="type" header="Type"></Column>
                            </DataTable>
                        </div>
                    </template>
                </Card>
            </div>
            <div class="w-2/3 h-full p-3">
                <Card>
                    <template #title>Simple Card</template>
                    <template #content>
                        <p class="m-0">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore sed consequuntur error
                            repudiandae numquam deserunt quisquam repellat libero asperiores earum nam nobis, culpa
                            ratione quam perferendis esse, cupiditate neque
                            quas!
                        </p>
                    </template>
                </Card>
            </div>
        </div>

        <!-- Column Filed Add/Edit Drawer -->
        <Drawer v-model:visible="toggleFieldDrawer" header="Column Field">
            <ColumnFieldForm @save="addField" />
        </Drawer>
    </AuthenticatedLayout>
</template>
<script setup>
import { ref, computed, reactive } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ColumnFieldForm from "@/Components/Modules/DevTools/ColumnFieldForm.vue";

const tableName = ref('');
const tableOperation = ref('create');
const columnFields = reactive([]);

const toggleFieldDrawer = ref(false);

const addField = (field) => {
    console.log(field);
    columnFields.push(field);
}
</script>