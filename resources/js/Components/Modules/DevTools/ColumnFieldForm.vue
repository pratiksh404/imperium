<template>
    <div class="w-full">
        <div class="mt-4">
            <FloatLabel variant="on">
                <InputText id="name" v-model="name" fluid />
                <label for="name">Field Name</label>
            </FloatLabel>
        </div>
        <div class="mt-4">
            <FloatLabel variant="on">
                <Select v-model="type" :options="fieldTypes" optionLabel="name" optionValue="name" filter
                    class="w-full" />
                <label for="type">Field Type</label>
            </FloatLabel>
        </div>
        <div class="mt-4">
            <ToggleButton v-model="autoIncrement" onIcon="pi pi-check" offIcon="pi pi-times" class="w-full"
                aria-label="autoIncrement" onLabel="Auto Increment" fluid offLabel="Not Auto Increment" />
        </div>
        <div class="mt-4">
            <ToggleButton v-model="nullable" onIcon="pi pi-check" offIcon="pi pi-times" class="w-full"
                aria-label="nullable" onLabel="Nullable" offLabel="Not Nullable" fluid />
        </div>
        <div class="mt-4">
            <ToggleButton v-model="unique" onIcon="pi pi-check" offIcon="pi pi-times" class="w-full" aria-label="unique"
                onLabel="Unique" offLabel="Not Unique" fluid />
        </div>
        <div class="mt-4">
            <ToggleButton v-model="unsigned" onIcon="pi pi-check" offIcon="pi pi-times" class="w-full"
                aria-label="unsigned" onLabel="Unsigned" offLabel="Not Unsigned" fluid />
        </div>
        <div class="mt-4">
            <Button label="Save" icon="pi pi-check" class="w-full"
                @click="$emit('save', { name, type, autoIncrement, nullable, unique, unsigned })" />
        </div>
    </div>
</template>
<script setup>
import { defineProps, ref } from "vue";
const props = defineProps({
    modelValue: {
        type: Object,
        default: null
    }
})
// Attributes
const name = ref(props.modelValue?.name ?? null);
const type = ref(props.modelValue?.type ?? null);
const autoIncrement = ref(props.modelValue?.autoIncrement ?? false);
const nullable = ref(props.modelValue?.nullable ?? false);
const unique = ref(props.modelValue?.unique ?? false);
const unsigned = ref(props.modelValue?.unsigned ?? false);

const fieldTypes = ref([
    { name: 'string' },
    { name: 'integer' },
    { name: 'id' },
    { name: 'foreignId' },
    { name: 'bigIncrements' },
    { name: 'bigInteger' },
    { name: 'binary' },
    { name: 'boolean' },
    { name: 'char' },
    { name: 'date' },
    { name: 'dateTime' },
    { name: 'dateTimeTz' },
    { name: 'decimal' },
    { name: 'double' },
    { name: 'enum' },
    { name: 'float' },
    { name: 'geometry' },
    { name: 'geometryCollection' },
    { name: 'increments' },
    { name: 'ipAddress' },
    { name: 'json' },
    { name: 'jsonb' },
    { name: 'lineString' },
    { name: 'longText' },
    { name: 'macAddress' },
    { name: 'mediumIncrements' },
    { name: 'mediumInteger' },
    { name: 'mediumText' },
    { name: 'morphs' },
    { name: 'uuidMorphs' },
    { name: 'multiLineString' },
    { name: 'multiPoint' },
    { name: 'multiPolygon' },
    { name: 'nullableMorphs' },
    { name: 'nullableUuidMorphs' },
    { name: 'nullableTimestamps' },
    { name: 'point' },
    { name: 'polygon' },
    { name: 'rememberToken' },
    { name: 'smallIncrements' },
    { name: 'smallInteger' },
    { name: 'softDeletes' },
    { name: 'softDeletesTz' },
    { name: 'text' },
    { name: 'time' },
    { name: 'timeTz' },
    { name: 'timestamp' },
    { name: 'timestampTz' },
    { name: 'timestamps' },
    { name: 'timestampsTz' },
    { name: 'tinyIncrements' },
    { name: 'tinyInteger' },
    { name: 'unsignedBigInteger' },
    { name: 'unsignedDecimal' },
    { name: 'unsignedInteger' },
    { name: 'unsignedMediumInteger' },
    { name: 'unsignedSmallInteger' },
    { name: 'unsignedTinyInteger' },
    { name: 'uuid' },
    { name: 'year' },
])
</script>
<style></style>