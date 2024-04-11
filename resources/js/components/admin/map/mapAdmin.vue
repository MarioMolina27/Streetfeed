<template>
    <div class="container-fluid full-size">
        <div class="row h-100">
            <div class="col-lg-1 col-12 d-flex align-items-start mt-4 ps-4">
                <SidebarAdmin :translations = "translations"/>
            </div>
            <div class="col-lg-11 col-12">
                <AdminMap :translations = "translations"/>
            </div>
        </div>
    </div>
</template>

<script>
import SidebarAdmin from "../shared/SidebarAdmin.vue";
import AdminMap from "./AdminMap.vue";
import esTranslations from '../../../../lang/admin/es.json';
import enTranslations from '../../../../lang/admin/en.json';
import caTranslations from '../../../../lang/admin/ca.json';
export default{
    name: "MapAdmin",
    props: {
        user: Object,
        lang: String
    },
    data() {
        return {
            translations: {}
        }
    },
    created() {
        if (this.lang === 'ca') {
            this.translations = caTranslations;
        } else if (this.lang === 'en') {
            this.translations = enTranslations;
        } else {
            this.translations = esTranslations;
        }
    },
    components: {
        SidebarAdmin,
        AdminMap
    }
}
</script>