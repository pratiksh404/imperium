<template>
    <div class="w-full">
        <div class="mt-4">
            <FloatLabel variant="on">
                <InputText id="name" v-model="name" fluid autofocus />
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
            <Checkbox v-model="autoIncrement" inputId="autoIncrement" name="autoIncrement" binary />
            <label for="autoIncrement"> Auto Increment </label>
        </div>
        <div class="mt-2">
            <Checkbox v-model="nullable" inputId="nullable" name="nullable" binary />
            <label for="nullable"> Nullable </label>
        </div>
        <div class="mt-2">
            <Checkbox v-model="unsigned" inputId="unsigned" name="unsigned" binary />
            <label for="unsigned"> Unsigned </label>
        </div>
        <div class="mt-2">
            <Checkbox v-model="unique" inputId="unique" name="unique" binary />
            <label for="unique"> Unique </label>
        </div>
        <div class="mt-2">
            <Checkbox v-model="constrained" inputId="constrained" name="constrained" binary />
            <label for="constrained"> Constrained </label>
        </div>
        <div class="mt-2">
            <Checkbox v-model="cascadeOnDelete" inputId="cascadeOnDelete" name="cascadeOnDelete" binary />
            <label for="cascadeOnDelete"> Cascade On Delete </label>
        </div>
        <div class="mt-2">
            <Checkbox v-model="nullOnDelete" inputId="nullOnDelete" name="nullOnDelete" binary />
            <label for="nullOnDelete"> Null On Delete </label>
        </div>
        <Divider />
        <div class="mt-4">
            <Button label="Save" icon="pi pi-check" class="w-full"
                @click="$emit('save', { name, type, autoIncrement, nullable, unique, unsigned, constrained, cascadeOnDelete, nullOnDelete })" />
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
const id = ref(props.modelValue?.id ?? Math.random(),);
const name = ref(props.modelValue?.name ?? null);
const type = ref(props.modelValue?.type ?? null);
const autoIncrement = ref(props.modelValue?.autoIncrement ?? false);
const nullable = ref(props.modelValue?.nullable ?? false);
const unique = ref(props.modelValue?.unique ?? false);
const unsigned = ref(props.modelValue?.unsigned ?? false);
const constrained = ref(props.modelValue?.constrained ?? false);
const cascadeOnDelete = ref(props.modelValue?.cascadeOnDelete ?? false);
const nullOnDelete = ref(props.modelValue?.nullOnDelete ?? false);

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