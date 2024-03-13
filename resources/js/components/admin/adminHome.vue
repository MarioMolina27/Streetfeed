<template>
    <div class="container-fluid full-size">
        <div class="row h-100">
        <div class="col-lg-1 col-12 d-flex align-items-start mt-4 ps-4">
            <SidebarAdmin />
        </div>
        <div class="col-lg-11 col-12">
            <StadisticsHome />
        </div>
    </div>
    </div>
</template>

<script>
import SidebarAdmin from "./SidebarAdmin.vue";
import StadisticsHome from "./StadisticsHome.vue";


export default {
    components: {
        SidebarAdmin,
        StadisticsHome
    }
}
</script>

<style>
.full-size{
    height: 100vh;
}
</style>
