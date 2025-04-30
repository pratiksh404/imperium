<template>
  <Head title="Migration Generator" />
  <AuthenticatedLayout title="Migration Generator">
    <div class="flex flex-col lg:flex-row h-full w-full">
      <div class="lg:w-2/5 w-full h-full p-3">
        <Card
          :pt="{
            root: {
              class: 'h-full p-2',
            },
            title: {
              class: 'bg-black p-4 text-white',
            },
          }"
        >
          <template #title>Migration Configuration</template>
          <template #content>
            <div class="mt-4">
              <FloatLabel variant="on">
                <InputText
                  id="tableName"
                  v-model="tableName"
                  autocomplete="off"
                  fluid
                  size="large"
                />
                <label for="tableName">Table Name</label>
              </FloatLabel>
            </div>
            <div class="mt-4" v-if="tableOperation === 'rename'">
              <FloatLabel variant="on">
                <InputText
                  id="tableNewName"
                  v-model="tableNewName"
                  autocomplete="off"
                  fluid
                  size="large"
                />
                <label for="tableNewName">Table New Name</label>
              </FloatLabel>
            </div>
            <div class="mt-4" v-if="tableName">
              <InputGroup>
                <InputText
                  placeholder="Migration Command"
                  fluid
                  readonly
                  v-model="migrationCommand"
                />
                <CopyToClipboard :copyText="migrationCommand" />
              </InputGroup>
            </div>
            <div class="mt-4 mb-4">
              <h3>Table Operation</h3>
              <div class="flex flex-wrap gap-4 mt-4">
                <div class="flex items-center gap-2">
                  <RadioButton
                    v-model="tableOperation"
                    inputId="tableOperation1"
                    value="Create"
                  />
                  <label for="tableOperation1">Create</label>
                </div>
                <div class="flex items-center gap-2">
                  <RadioButton
                    v-model="tableOperation"
                    inputId="tableOperation2"
                    value="Drop"
                  />
                  <label for="tableOperation2">Drop</label>
                </div>
                <div class="flex items-center gap-2">
                  <RadioButton
                    v-model="tableOperation"
                    inputId="tableOperation3"
                    value="Rename"
                  />
                  <label for="tableOperation3">Rename</label>
                </div>
                <div class="flex items-center gap-2">
                  <RadioButton
                    v-model="tableOperation"
                    inputId="tableOperation4"
                    value="Modify"
                  />
                  <label for="tableOperation4">Modify</label>
                </div>
              </div>
            </div>
            <Divider />
            <div class="mt-4">
              <div class="flex justify-between">
                <h3>Fields</h3>
                <Button
                  label="Add Field"
                  icon="pi pi-plus"
                  size="small"
                  @click="toggleFieldDrawer = !toggleFieldDrawer"
                />
              </div>
              <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div
                  class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8"
                >
                  <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                      <tr>
                        <th
                          scope="col"
                          class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-0"
                        >
                          Name
                        </th>
                        <th
                          scope="col"
                          class="px-3 py-3.5 text-left text-sm font-semibold"
                        >
                          Type
                        </th>
                        <th
                          scope="col"
                          class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0"
                        >
                          <Button
                            type="button"
                            @click="removeAllField"
                            icon="pi pi-trash"
                            severity="danger"
                            rounded
                            variant="text"
                          ></Button>
                        </th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                      <template
                        v-if="Object.keys(columnFields ?? []).length > 0"
                      >
                        <tr v-for="field in columnFields" :key="field.id">
                          <td class="text-center whitespace-nowrap text-sm">
                            {{ field.name }}
                          </td>
                          <td class="text-center whitespace-nowrap text-sm">
                            {{ field.type }}
                          </td>
                          <td
                            class="relative whitespace-nowrap pl-3 pr-4 text-right text-sm font-medium sm:pr-0"
                          >
                            <Button
                              type="button"
                              @click="removeField($event, field)"
                              icon="pi pi-trash"
                              severity="danger"
                              rounded
                              variant="text"
                            ></Button>
                          </td>
                        </tr>
                      </template>
                      <tr else>
                        <td
                          colspan="3"
                          class="text-center whitespace-nowrap px-3 py-4 text-sm"
                        >
                          No Fields
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </template>
        </Card>
      </div>
      <div class="lg:w-3/5 w-full h-full">
        <ProgressBar
          v-if="loading"
          mode="indeterminate"
          style="height: 6px; width: 100%"
        ></ProgressBar>
        <div class="card flex justify-center gap-2" v-if="!loading">
          <Button
            v-if="tableName && fieldsString"
            @click="confirmGenerateMigration($event)"
            label="Generate Migration"
            icon="pi pi-database"
          />
          <Button
            label="Run Migration"
            icon="pi pi-play"
            @click="confirmRunMigration($event)"
          />
        </div>
        <CodeSnippet :code="code" />
      </div>
    </div>

    <!-- Column Filed Add/Edit Drawer -->
    <Drawer v-model:visible="toggleFieldDrawer" header="Column Field">
      <ColumnFieldForm @save="addField" />
    </Drawer>
    <!-- Confirm Popup -->
    <ConfirmPopup>
      <template #container="{ message, acceptCallback, rejectCallback }">
        <div class="rounded p-4">
          <span>{{ message.message }}</span>
          <div class="flex content-end gap-2 mt-4 w-full">
            <Button
              :label="message.acceptProps.label"
              @click="acceptCallback"
              size="small"
              :severity="message.acceptProps.severity"
            ></Button>
            <Button
              :label="message.rejectProps.label"
              outlined
              @click="rejectCallback"
              :severity="message.rejectProps.severity"
              size="small"
              text
            ></Button>
          </div>
        </div>
      </template>
    </ConfirmPopup>
  </AuthenticatedLayout>
</template>
<script setup>
import { ref, computed, watch } from "vue";
import CodeSnippet from "@/Imperium/Components/Utils/CodeSnippet.vue";
import AuthenticatedLayout from "@/Imperium/Layouts/AuthenticatedLayout.vue";
import ColumnFieldForm from "@/Components/Admin/DevTools/Components/ColumnFieldForm.vue";
import CopyToClipboard from "@/Imperium/Components/Utils/CopyToClipboard.vue";
import { useConfirm } from "primevue/useconfirm";
import { useServerAction } from "@/Imperium/Composables/useServerAction";

const { serverAction, loading, error } = useServerAction();

console.log(loading.value);

const tableName = ref("");
const tableNewName = ref("");
const tableOperation = ref("Create");
const columnFields = ref([]);

const toggleFieldDrawer = ref(false);

const migrationCommand = ref("");
watch(tableName, (newVal) => {
  migrationCommand.value = newVal
    ? "php artisan make:migration create_" +
      newVal +
      "_table --create=" +
      newVal
    : "";
});

const addField = (field) => {
  columnFields.value.push(field);
  toggleFieldDrawer.value = false;
};

const removeField = (event, field) => {
  columnFields.value = columnFields.value.filter((f) => f.id !== field.id);
};

const removeAllField = () => {
  columnFields.value = [];
};

// Migration Actions
const confirm = useConfirm();
const confirmGenerateMigration = (event) => {
  confirm.require({
    target: event.currentTarget,
    message: "Are you sure you want to generate this migration?",
    icon: "pi pi-exclamation-triangle",
    rejectProps: {
      label: "Cancel",
      severity: "secondary",
      outlined: true,
    },
    acceptProps: {
      label: "Generate",
    },
    accept: () => {
      serverAction({
        action: "generateResourceMigration",
        table_name: tableName.value,
        schema: fieldsString.value,
      });
    },
    reject: () => {
      toast.add({
        severity: "error",
        summary: "Rejected",
        detail: "You have rejected",
        life: 3000,
      });
    },
  });
};
const confirmRunMigration = (event) => {
  confirm.require({
    target: event.currentTarget,
    message: "Are you sure you want to run migration?",
    icon: "pi pi-exclamation-triangle",
    rejectProps: {
      label: "Cancel",
      severity: "secondary",
      outlined: true,
    },
    acceptProps: {
      label: "Run",
    },
    accept: () => {
      serverAction({
        action: "runMigration",
      });
    },
    reject: () => {
      toast.add({
        severity: "error",
        summary: "Rejected",
        detail: "You have rejected",
        life: 3000,
      });
    },
  });
};

// Migration Generator
const code = computed(() => {
  return getCode();
});

const getCode = () => {
  if (tableOperation.value == "Drop") {
    return `
    <?php

    use Illuminate\\Support\\Facades\\Schema;
    use Illuminate\\Database\\Schema\\Blueprint;
    use Illuminate\\Database\\Migrations\\Migration;

    class ${
      tableOperation.value.charAt(0).toUpperCase() +
      tableOperation.value.slice(1)
    }${
      tableName.value.charAt(0).toUpperCase() + tableName.value.slice(1)
    }Table extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::drop('${tableName.value.toLowerCase().trim()}');
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::create('${tableName.value.toLowerCase().trim()}');
        }
    }
    `;
  } else if (tableOperation.value == "Rename") {
    return `
    <?php

    use Illuminate\\Support\\Facades\\Schema;
    use Illuminate\\Database\\Schema\\Blueprint;
    use Illuminate\\Database\\Migrations\\Migration;

    class ${
      tableOperation.value.charAt(0).toUpperCase() +
      tableOperation.value.slice(1)
    }${
      tableName.value.charAt(0).toUpperCase() + tableName.value.slice(1)
    }Table extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::rename('${tableName.value
              .toLowerCase()
              .trim()}', '${tableNewName.value.toLowerCase().trim()}');
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::rename('${tableNewName.value
              .toLowerCase()
              .trim()}', '${tableName.value.toLowerCase().trim()}');
        }
    }
    `;
  } else if (tableOperation.value == "Modify") {
    return `
    <?php

    use Illuminate\\Support\\Facades\\Schema;
    use Illuminate\\Database\\Schema\\Blueprint;
    use Illuminate\\Database\\Migrations\\Migration;

    class ${
      tableOperation.value.charAt(0).toUpperCase() +
      tableOperation.value.slice(1)
    }${
      tableName.value.charAt(0).toUpperCase() + tableName.value.slice(1)
    }Table extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::${"table"}('${tableName.value
      .toLowerCase()
      .trim()}', function (Blueprint $table) {
                ${fieldsString.value}
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::${"table"}('${tableName.value
      .toLowerCase()
      .trim()}', function (Blueprint $table) {
                ${dropFieldsString.value}
            });
        }
    }
    `;
  } else {
    return `
    <?php

    use Illuminate\\Support\\Facades\\Schema;
    use Illuminate\\Database\\Schema\\Blueprint;
    use Illuminate\\Database\\Migrations\\Migration;

    class ${
      tableOperation.value.charAt(0).toUpperCase() +
      tableOperation.value.slice(1)
    }${
      tableName.value.charAt(0).toUpperCase() + tableName.value.slice(1)
    }Table extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::${"create"}('${tableName.value
      .toLowerCase()
      .trim()}', function (Blueprint $table) {
                ${fieldsString.value}
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::drop('${tableName.value.toLowerCase().trim()}');
        }
    }
    `;
  }
};

const fieldsString = computed(() => {
  let fieldsString = "";

  if (!Object.keys(columnFields.value ?? []).length) {
    return `// Please add your fields`;
  }

  for (const [index, field] of columnFields.value.entries()) {
    let indent = "";
    let newLine = "\n";
    const unsigned = field.unsigned ? "->unsigned()" : "";
    const nullable = field.nullable ? "->nullable()" : "";
    const unique = field.unique ? "->unique()" : "";
    const autoIncrement = field.autoIncrement ? "->autoIncrement()" : "";
    const cascadeOnDelete =
      field.cascadeOnDelete && !field.nullable && !field.nullOnDelete
        ? "->onDelete('cascade')"
        : "";
    const nullOnDelete =
      field.nullOnDelete && field.nullable && !field.cascadeOnDelete
        ? "->onDelete('set null')"
        : "";
    const constrained = field.constrained ? "->constrained()" : "";

    if (index > 0) {
      indent = "                ";
    }

    if (index === columnFields.value.length - 1) {
      newLine = "";
    }

    fieldsString =
      fieldsString +
      indent +
      `$table->${field.type}('${field.name}')${nullable}${constrained}${unsigned}${autoIncrement}${unique}${cascadeOnDelete}${nullOnDelete};` +
      newLine;
  }

  return fieldsString;
});

const dropFieldsString = computed(() => {
  let fieldsString = "";

  if (!Object.keys(columnFields.value ?? []).length) {
    return `// Please add your fields`;
  }

  for (const [index, field] of columnFields.value.entries()) {
    let indent = "";
    let newLine = "\n";

    if (index > 0) {
      indent = "                ";
    }

    if (index === columnFields.value.length - 1) {
      newLine = "";
    }

    fieldsString =
      fieldsString + indent + `$table->dropColumn('${field.name}');` + newLine;
  }

  return fieldsString;
});
</script>