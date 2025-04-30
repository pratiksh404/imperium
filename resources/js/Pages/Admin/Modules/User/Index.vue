<template>
  <Head title="Users" />
  <AuthenticatedLayout title="Users">
    <ModuleDataListPage name="User" :url="route('users.store')">
      <template v-slot:table>
        <ModuleTable name="User" :data="users" :trashed-data="trashed_users" />
      </template>
    </ModuleDataListPage>
  </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Imperium/Layouts/AuthenticatedLayout.vue";
import ModuleDataListPage from "@/Imperium/Components/Modules/ListPage.vue";
import ModuleTable from "@/Imperium/Components/Modules/Table.vue";

defineProps({
  users: Object,
  trashed_users: Object,
});
</script>
