<template>
    <div>
        <div class="flow-root" v-if="presentationFields">
            <dl class="-my-3 divide-y divide-gray-100 text-sm">
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4" v-for="field in presentationFields"
                    :key="`presentation-${field.field}`">
                    <dt class="font-medium ">{{ field.label }}</dt>
                    <dd class="sm:col-span-2">
                        <component v-if="field.value" :is="field.presentationComponent" :field="field"></component>
                        <Message severity="secondary" variant="simple" v-else>No data found</Message>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</template>
<script setup>
import { defineProps, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { resolveFieldPresentationComponent } from '@/Utils/Resource/FieldPresentationMapper';

const props = defineProps({
    name: {
        required: true,
        type: String
    },
    data: {
        required: true,
        type: Object
    }
})

const resourceFields = usePage().props.resources[props.name].form.fields;

const mergeFields = (resourceFields, data) => {
    return resourceFields.map(field => {
        const fieldKey = field.field; // Extract the 'field' key
        if (data.hasOwnProperty(fieldKey)) {
            // Merge resourceField object with the corresponding value from data
            return {
                ...field,
                value: data[fieldKey], // Assign value from data to the resourceField's value
                presentationComponent: resolveFieldPresentationComponent(field.type)
            };
        }
        // If no matching field in data, return the field as is
        return field;
    });
};

// Usage
const presentationFields = computed(() => mergeFields(resourceFields, props.data));


</script>
<style></style>