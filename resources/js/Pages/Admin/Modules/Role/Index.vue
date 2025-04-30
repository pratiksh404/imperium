<template>
  <Head title="Roles" />
  <AuthenticatedLayout title="Roles">
    <PageHeader>
      <template #actions>
        <ModuleFormOverlay
          name="Role"
          label="Create Role"
          key="module-create-role"
          shortcut="]"
        >
          <template #form>
            <component
              :is="ResourceForm"
              name="Role"
              method="post"
              :url="route('roles.store')"
            >
            </component>
          </template>
        </ModuleFormOverlay>
      </template>
    </PageHeader>

    <ModuleTable
      name="Role"
      :data="$page.props.roles"
      :trashed-data="$page.props.trashed_roles"
      :action-components="[BreadPermissionPanel]"
    />
  </AuthenticatedLayout>
</template>
<script setup>
import ModuleFormOverlay from "@/Imperium/Components/Modules/FormOverlay.vue";
import AuthenticatedLayout from "@/Imperium/Layouts/AuthenticatedLayout.vue";
import PageHeader from "@/Imperium/Components/PageHeader.vue";
import ModuleTable from "@/Imperium/Components/Modules/Table.vue";
import BreadPermissionPanel from "@/Components/Admin/Role/Components/BreadPermissionPanel.vue";
import ResourceForm from "@/Imperium/Components/Form/ResourceForm.vue";
</script>
