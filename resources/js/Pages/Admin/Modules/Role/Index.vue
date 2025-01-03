<template>

    <Head title="Roles" />
    <ContentLayout title="Roles">
        <ModuleDataListPage name="Role" :url="route('roles.store')">
            <template v-slot:table>
                <ModuleTable name="Role" :data="$page.props.roles" :trashed-data="$page.props.trashed_roles"
                    :action-components="[BreadPermissionPanel]" />
            </template>
        </ModuleDataListPage>
    </ContentLayout>
</template>
<script setup>
import ContentLayout from "@/Layouts/ContentLayout.vue";
import ModuleDataListPage from "@/Components/Modules/ListPage.vue"
import ModuleTable from "@/Components/Modules/Table.vue"
import BreadPermissionPanel from "@/Components/Modules/Role/BreadPermissionPanel.vue"
</script>
