<template>
    <div class="container-fluid">
        <div class="row">
        <div class="col-lg-1 col-12 d-flex align-items-start mt-4 ps-4">
            <SidebarAdmin />
        </div>
        <div class="col-lg-11 col-12">
            <UsersTable />
        </div>
    </div>
    </div>
</template>

<script>
import SidebarAdmin from "../shared/SidebarAdmin.vue";
import UsersTable from "./UsersTable.vue";

export default {
    components: {
        SidebarAdmin,
        UsersTable,
    }
}
</script>
