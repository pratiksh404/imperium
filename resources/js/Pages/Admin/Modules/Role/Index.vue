<template>

  <Head title="Roles" />
  <AuthenticatedLayout title="Roles">
    <PageHeader>
      <template #actions>
        <ModuleFormOverlay name="Role" label="Create Role" key="module-create-role">
          <template #form>
            <component :is="ResourceForm" name="Role" method="post" :url="route('roles.store')">
            </component>
          </template>
        </ModuleFormOverlay>
      </template>
    </PageHeader>

    <ModuleTable name="Role" :data="$page.props.roles" :trashed-data="$page.props.trashed_roles"
      :action-components="[BreadPermissionPanel]" />
  </AuthenticatedLayout>
</template>
<script setup>
import { ref, computed } from "vue";
import ModuleFormOverlay from "@/Components/Modules/FormOverlay.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PageHeader from "@/Components/PageHeader.vue";
import ModuleTable from "@/Components/Modules/Table.vue";
import BreadPermissionPanel from "@/Components/Modules/Role/BreadPermissionPanel.vue";
import ResourceForm from "@/Components/Form/ResourceForm.vue";
</script>
