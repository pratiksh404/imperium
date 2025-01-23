<template>

    <Head title="Roles" />
    <AuthenticatedLayout title="Roles">
        <ModuleTable name="Role" :data="$page.props.roles" :trashed-data="$page.props.trashed_roles"
            :action-components="[BreadPermissionPanel]" />
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ModuleDataListPage from "@/Components/Modules/ListPage.vue"
import ModuleTable from "@/Components/Modules/Table.vue"
import BreadPermissionPanel from "@/Components/Modules/Role/BreadPermissionPanel.vue"
</script>
