<template>
  <form @submit.prevent="submit">
    <template v-if="resourceForm">
      <template
        v-for="field in resourceForm.fields"
        :key="`input-${field.field}`"
      >
        <ResourceInput
          v-model="form[field.field]"
          :field="field"
          :error="form.errors[field.field]"
        />
      </template>
    </template>
    <Stepper :value="activeStep" v-if="resourceSteppers">
      <StepItem
        v-for="(stepper, step) in resourceSteppers"
        :key="`stepper-${stepper.name}-${step + 1}`"
        :value="step + 1"
      >
        <Step>{{ stepper.title }}</Step>
        <StepPanel v-slot="{ activateCallback }">
          <div class="flex flex-col mb-2">
            <div
              style="
                border: 1px dashed #e0e0e0;
                border-radius: 0.375rem;
                background-color: #f9f9f9;
                padding: 1rem;
              "
            >
              <template
                v-for="field in stepper.fields"
                :key="`input-${field.field}`"
              >
                <ResourceInput
                  v-model="form[field.field]"
                  :field="field"
                  :error="form.errors[field.field]"
                />
              </template>
            </div>
          </div>
          <div class="py-6 d-flex justify-content-end gap-2">
            <Button
              v-if="step - 1 > 0"
              size="small"
              label="Back"
              severity="secondary"
              @click="activateCallback(step - 1)"
            />
            <Button
              v-if="step + 2 <= Object.keys(resourceSteppers ?? {}).length"
              size="small"
              label="Next"
              @click="activateCallback(step + 2)"
            />
          </div>
        </StepPanel>
      </StepItem>
    </Stepper>
    <Tabs :value="activeTab" v-if="resourceTabs">
      <TabList>
        <Tab
          v-for="(tab, index) in resourceTabs"
          :key="`tab-${index}`"
          :value="index"
          >{{ tab.title }}</Tab
        >
      </TabList>
      <TabPanels>
        <TabPanel
          v-for="(tab, index) in resourceTabs"
          :key="`tab-panel-${index}`"
          :value="index"
        >
          <template v-for="field in tab.fields" :key="`input-${field.field}`">
            <ResourceInput
              v-model="form[field.field]"
              :field="field"
              :error="form.errors[field.field]"
            />
          </template>
        </TabPanel>
      </TabPanels>
    </Tabs>
    <SubmitButton
      :processing="form.processing"
      buttonText="Save"
      class="w-full mr-5"
    />
  </form>
</template>
<script setup>
import { defineProps, computed, ref, watch } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { useEventsStore } from "@/Store/events";
import ResourceInput from "@/Components/Form/ResourceInput.vue";
import SubmitButton from "@/Components/Form/SubmitButton.vue";
import { useToast } from "primevue/usetoast";
import axios from "axios";
import { watchDebounced } from "@vueuse/core";

const toast = useToast();

// Form Success State Management
const eventsStore = useEventsStore();

const props = defineProps({
  name: {
    required: true,
    type: String,
  },
  method: {
    required: true,
    type: String,
    default: "post",
  },
  url: {
    required: true,
    type: String,
  },
  formData: {
    type: Object,
    default: () => {},
  },
});

// Form Resource
const resourceForm = usePage().props.resources[props.name].form;

const resourceSteppers = computed(() => {
  return getGroup(resourceForm.steppers);
});

const resourceTabs = computed(() => {
  return getGroup(resourceForm.tabs);
});

const getGroup = (group) => {
  return Object.keys(group).length > 0
    ? group.filter((stepper) => Object.keys(stepper.fields ?? {}).length > 0)
    : {};
};

const activeStep = ref(1);

const activeTab = ref(0);

const form = useForm(
  resourceForm.fields.reduce((acc, key) => {
    acc[key.field] = props.formData?.[key.field] ?? null;
    return acc;
  }, {})
);

const submit = () => {
  form[props.method](props.url, {
    preserveScroll: true,
    onSuccess: () => {
      toast.add({
        severity: "success",
        summary: "Success",
        detail: props.name + " saved successfully",
        life: 3000,
      });
      form.reset();
      eventsStore.triggerFormSuccess();
    },
    onError: () => {
      toast.add({
        severity: "error",
        summary: "Error",
        detail: "Something went wrong",
        life: 3000,
      });
    },
  });
};

// Watching Dependent Fields
watchDebounced(
  () => form, // Watch the entire form object
  (newForm) => {
    resourceForm.fields.forEach(async (field) => {
      if (field.dependsOn) {
        const parentValue = newForm[field.dependsOn];
        axios
          .post(
            route("getDependencies", {
              module_name: props.name,
              dependable_field_name: field.field,
            }),
            { dependent_value: parentValue }
          )
          .then((response) => {
            let data = response.data;
            // Assigning the value
            form[field.field] = data;
          });
      }
    });
  },
  { deep: true, debounce: 1000, maxWait: 2000 } // Deep watch to track nested changes
);
</script>
