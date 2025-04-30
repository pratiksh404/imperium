<template>
    <div style="width: 100%;">
        <FilePond ref="pond" v-model="model" allowImageEdit="true" @init="handleFilePondInit" allowFileRename="true"
            label-idle="Drag & Drop your images or <span class='filepond--label-action'>Browse</span>"
            v-bind="{ ...(allowFileSizeValidation ? { allowFileSizeValidation, minFileSize, maxFileSize, maxTotalFileSize, labelMaxFileSizeExceeded, labelMaxTotalFileSizeExceeded } : {}), ...(allowFileTypeValidation ? { allowFileTypeValidation, acceptedFileTypes } : {}) }"
            :allowDrop="allowDrop" :allowBrowse="allowBrowse" :allowPaste="allowPaste" :allowMultiple="allowMultiple"
            :multiple="allowMultiple" :allowReplace="allowReplace" :allowReorder="allowReorder"
            :allowRemove="allowRemove" :allowRevert="allowRevert" :maxFiles="maxFiles"
            :maxParallelUploads="maxParallelUploads" :itemInsertInterval="itemInsertInterval"
            :itemInsertLocation="itemInsertLocation" :dropOnPage="dropOnPage" :dropOnElement="dropOnElement"
            :dropValidation="dropValidation" :ignoredFiles="ignoredFiles" :disabled="disabled" :className="class"
            :required="required" />
    </div>
</template>

<script setup>
import { defineProps, computed, ref } from 'vue';
import { usePage, router } from "@inertiajs/vue3";
import { useToast } from "primevue/usetoast";
const toast = useToast();

const props = defineProps({
    modelValue: {
        type: String,
        default: null,
    },
    placeholder: { type: String, default: '' },
    required: { type: Boolean, default: false },
    readOnly: { type: Boolean, default: false },
    disabled: { type: Boolean, default: false },
    class: { type: String },
    id: { type: String, default: () => `input-${Math.random().toString(36).substr(2, 9)}` },
    size: { type: String, default: null },
    error: { type: String, default: null },
    field: { type: Object, default: () => ({}) },
});



// Import Vue FilePond and plugin styles
import vueFilePond from "vue-filepond";
import { setOptions } from 'vue-filepond';
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

// Import FilePond plugins
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';

// Initialize FilePond with the required plugins
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginFileValidateSize,
    FilePondPluginImagePreview,
);


// Method for initializing FilePond
const handleFilePondInit = (pond) => {
    console.log("FilePond initialized", pond);
};


// Attributes

// Core Properties
const allowDrop = computed(() => {
    return props.field.allowDrop ?? true;
});

const allowBrowse = computed(() => {
    return props.field.allowBrowse ?? true;
});

const allowPaste = computed(() => {
    return props.field.allowPaste ?? true;
});

const allowMultiple = computed(() => {
    return props.field.allowMultiple ?? false;
});

const allowReplace = computed(() => {
    return props.field.allowReplace ?? true;
});

const allowReorder = computed(() => {
    return props.field.allowReorder ?? true;
});

const allowRemove = computed(() => {
    return props.field.allowRemove ?? true;
});

const allowRevert = computed(() => {
    return props.field.allowRevert ?? true;
});

const maxFiles = computed(() => {
    return props.field.maxFiles ?? 10;
});

const maxParallelUploads = computed(() => {
    return props.field.maxParallelUploads ?? 2;
});

const itemInsertInterval = computed(() => {
    return props.field.itemInsertInterval ?? 45;
});

const itemInsertLocation = computed(() => {
    return props.field.itemInsertLocation ?? "before";
});

const dropOnPage = computed(() => {
    return props.field.dropOnPage ?? false;
});

const dropOnElement = computed(() => {
    return props.field.dropOnElement ?? true;
});

const dropValidation = computed(() => {
    return props.field.dropValidation ?? false;
});

const ignoredFiles = computed(() => {
    return props.field.ignoredFiles ?? ['.ds_store', 'thumbs.db', 'desktop.ini'];
});

// File size validation
const allowFileSizeValidation = computed(() => {
    return props.field.allowFileSizeValidation ?? true;
});

const minFileSize = computed(() => {
    return props.field.minFileSize ?? "1KB";
});

const maxFileSize = computed(() => {
    return props.field.maxFileSize ?? "10MB";
});

const maxTotalFileSize = computed(() => {
    return props.field.maxTotalFileSize ?? "50MB";
});

const labelMaxFileSizeExceeded = computed(() => {
    return props.field.labelMaxFileSizeExceeded ?? "File size is too large";
});

const labelMaxTotalFileSizeExceeded = computed(() => {
    return props.field.labelMaxTotalFileSizeExceeded ?? "Maximum total size exceeded";
});

// File Type validation
const allowFileTypeValidation = computed(() => {
    return props.field.allowFileTypeValidation ?? true;
});

const acceptedFileTypes = computed(() => {
    return props.field.acceptedFileTypes ?? ["image/*"];
});

const model = defineModel({
    type: [String, Array],
    default: () => null,
});

// Server Configuration
const handleFilePondOnProcess = (response) => {
    const filePath = response;
    if (allowMultiple.value) {
        // Ensure model is an array if allowMultiple is true
        if (!Array.isArray(model.value)) {
            model.value = [];
        }
        model.value.push(filePath); // Add the file path to the array
    } else {
        // Set model to a string for single file upload
        model.value = filePath;
    }
    return response;
};
const handleFilePondRevert = (uniqueFileId, load, error) => {
    model.value = Array.isArray(model.value) ? model.value.filter((file) => file !== uniqueFileId) : null;
    // Should remove the earlier created temp file here
    console.log("FilePond revert", uniqueFileId);
    router.visit(route('upload.revert'), {
        method: 'DELETE',
        data: {
            file: uniqueFileId
        },
        onSuccess: (response) => {
            toast.add({ severity: 'success', summary: 'Success', detail: 'Upload reverted successfully', life: 3000 });
            load();
        },
        onError: (error) => {
            toast.add({ severity: 'error', summary: 'Error', detail: 'Error reverting upload', life: 3000 });
            error();
        }
    })

};

setOptions({
    server: {
        process: {
            url: route('upload.process'),
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": usePage().props.auth.csrf_token,
                "X-Requested-With": "XMLHttpRequest",
                "Accept": "application/json",
            },
            timeout: 7000,
            onload: handleFilePondOnProcess,
            onerror: (response) => {
                toast.add({ severity: 'error', summary: 'Error', detail: 'Something went wrong', life: 3000 });
            },
            ondata: null,
        },
        revert: handleFilePondRevert,
    },
});

</script>
