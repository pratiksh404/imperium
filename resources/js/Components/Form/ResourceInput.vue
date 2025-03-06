<template v-if="field.visibility ?? true">
  <div
    v-if="fieldComponent"
    class="mt-1 my-4"
    v-bind="field.attributes.wrapper"
  >
    <component
      :is="inputWrapper.component"
      v-bind="{ ...inputWrapper.props, ...field.attributes.inputGroup }"
    >
      <InputGroupAddon v-if="(field.prefix ?? false) && !field.iconField">
        <i v-if="field.prefixIsIcon ?? false" :class="field.prefix"></i>
        <span v-else>{{ field.prefix }}</span>
      </InputGroupAddon>
      <component
        :is="labelWrapper.component"
        v-bind="labelWrapper.props"
        :v-bind="field.attributes.label"
      >
        <IconField v-if="field.iconField">
          <InputIcon
            v-if="field.prefix && field.iconField"
            :class="field.prefix"
          />
          <component
            :is="fieldComponent"
            v-model="resourceModel"
            :size="field.size"
            :placeholder="
              field.floatedLabel || field.iftaLabel ? null : field.placeholder
            "
            :required="field.required"
            :readOnly="field.readOnly"
            :disabled="field.disabled"
            :class="field.class"
            :v-bind="field.attributes.input"
            :id="field.id"
            :error="error"
            :field="field"
          />
          <InputIcon
            v-if="field.suffix && field.iconField"
            :class="field.suffix"
          />
        </IconField>
        <component
          v-else
          :is="fieldComponent"
          v-model="resourceModel"
          :size="field.size"
          :placeholder="
            field.floatedLabel || field.iftaLabel ? null : field.placeholder
          "
          :required="field.required"
          :readOnly="field.readOnly"
          :disabled="field.disabled"
          :class="field.class"
          :id="field.id"
          :error="error"
          :field="field"
        />
        <label v-if="field.floatedLabel || field.iftaLabel" :for="field.id"
          ><span :class="`text-${error ? 'danger' : 'dark'}`">{{
            field.label
          }}</span>
          <span class="text-danger" v-if="field.required">*</span></label
        >
      </component>
      <InputGroupAddon v-if="(field.suffix ?? false) && !field.iconField">
        <i v-if="field.suffixIsIcon ?? false" :class="field.suffix"></i>
        <span v-else>{{ field.suffix }}</span>
      </InputGroupAddon>
    </component>
    <Message
      v-if="(field.hintText ?? false) && error == null"
      size="small"
      :severity="field.hintColor"
      variant="simple"
      class="p-1"
    >
      <span style="font-size: 12px">{{ field.hintText }}</span>
    </Message>
    <InputError v-if="error" class="mt-2" :error="error" />
  </div>
  <div v-else>
    <Message severity="error" size="small" class="mt-2 mb-2"
      >Component not found for field type : {{ field.type }}
    </Message>
  </div>
</template>
<script setup>
import { defineProps, computed, defineModel } from "vue";
import { resolveFieldComponent } from "@/Utils/Resource/FormComponentMapper";
import InputError from "@/Components/InputError.vue";

const resourceModel = defineModel();

const props = defineProps({
  field: {
    required: true,
    type: Object,
  },
  value: {
    required: false,
    default: null,
  },
  error: {
    type: String,
    default: null, // Validation error message
  },
});

console.log(props.field.attributes);

const inputWrapper = computed(() => {
  return {
    component: props.field.iconField
      ? resolveFieldComponent("defaultInputWrapper")
      : resolveFieldComponent("inputGroup"),
    props: {},
  };
});

const labelWrapper = computed(() => {
  if (props.field.floatedLabel) {
    return {
      component: resolveFieldComponent("floatLabel"),
      props: props.field.floatedLabelType
        ? { variant: props.field.floatedLabelType }
        : {},
    };
  }
  if (props.field.iftaLabel) {
    return {
      component: resolveFieldComponent("iftaLabel"),
      props: {},
    };
  }
  return {
    component: resolveFieldComponent("floatLabel"),
    props: {},
  };
});

const fieldComponent = computed(() => {
  return resolveFieldComponent(props.field.type);
});
</script>
