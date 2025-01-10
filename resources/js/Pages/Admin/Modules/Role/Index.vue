<template>

    <Head title="Roles" />
    <AuthenticatedLayout title="Roles">
        <ModuleDataListPage name="Role" :url="route('roles.store')">
            <template v-slot:table>
                <ModuleTable name="Role" :data="$page.props.roles" :trashed-data="$page.props.trashed_roles"
                    :action-components="[BreadPermissionPanel]" />
            </template>
        </ModuleDataListPage>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ModuleDataListPage from "@/Components/Modules/ListPage.vue"
import ModuleTable from "@/Components/Modules/Table.vue"
import BreadPermissionPanel from "@/Components/Modules/Role/BreadPermissionPanel.vue"
</script>
