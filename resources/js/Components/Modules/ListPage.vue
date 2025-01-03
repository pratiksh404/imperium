<template>

    <Card>
        <template #title>
            <div class="flex justify-between">
                {{ name + ' Table' }}
                <div class="flex justify-end gap-2">
                    <div v-if="route != null && moduleForm != null && $page.props.can.create?.[name.toLowerCase()]">
                        <ModuleFormOverlay :name="'Create ' + name" :key="'module-create-' + name">
                            <template #form>
                                <component :is="moduleForm" :name="name" method="post" :url="url">
                                </component>
                            </template>
                        </ModuleFormOverlay>
                    </div>
                </div>
            </div>

        </template>
        <template #content>
            <slot name="table"></slot>
        </template>
    </Card>

</template>
<script setup>
import { defineProps } from 'vue';
import ModuleFormOverlay from "@/Components/Modules/FormOverlay.vue";
import ResourceForm from '@/Components/Form/ResourceForm.vue';

defineProps({
    name: {
        required: true,
        type: String
    },
    url: {
        required: false,
        type: String,
        default: null
    },
    moduleForm: {
        required: false,
        type: Object,
        default: ResourceForm
    }
})


</script>
<script>
export default {
    name: "ModuleDataListPage"
}
</script>