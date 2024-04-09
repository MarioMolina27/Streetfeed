<template>
    <div class="container-fluid full-size">
        <div class="row h-100">
        <div class="col-lg-1 col-12 d-flex align-items-start mt-4 ps-4">
            <SidebarAdmin />
        </div>
        <div class="col-lg-11 col-12">
            <StadisticsProviders />
        </div>
    </div>
    </div>
</template>

<script>
import SidebarAdmin from "../shared/SidebarAdmin.vue";
import StadisticsProviders from "./StadisticsProviders.vue"


export default {
    props: {
        user: Object
    },
    components: {
        SidebarAdmin,
        StadisticsProviders
    }
}
</script>

<style>
.full-size{
    height: 100vh;
}
</style>
