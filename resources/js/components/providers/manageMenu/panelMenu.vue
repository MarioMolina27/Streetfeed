<template>
    <div class="container-fluid ps-0 pe-0">
        <Navbar :menuItems = 'menuItems' :currentLanguage = 'lang'></Navbar>
        <div class="manage-menus-container">
            <div class="col-12">
                <h1 class="text-center mt-4">{{ translations.yourMenusLabel }}</h1>
                <div class="new-menu">
                    <i class="fa-solid fa-plus fs-5"></i>
                    <span class="fs-5">{{ translations.addMenuLabel }}</span>
                </div>
                <div class="divider-menus">

                </div>
                <template v-for="menu in menus">
                    <itemMenu :menu = 'menu'></itemMenu>
                </template>
            </div>
        </div>
    </div>
</template>
  
<script >
import Navbar from '../../shared/Navbar.vue';
import itemMenu from './itemMenu.vue';
import esTranslations from '../../../../lang/providers/es.json';
import enTranslations from '../../../../lang/providers/en.json';
import caTranslations from '../../../../lang/providers/ca.json';
export default{
    props: {
        user: Object,
        lang: String
    },
    data(){
        return {
            menuItems: [
                {name: 'Repartos', href: './managedelivery'},
                {name: 'Tus Menus', href: './menu'},
                {name: 'Perfil', href: './profile'}
            ],
            loggedUser: 9,
            menus: [],
            translations: {}
        }
    },
    created() {
        console.log(this.lang);
        if (this.lang === 'ca') {
            this.translations = caTranslations;
        } else if (this.lang === 'en') {
            this.translations = enTranslations;
        } else {
            this.translations = esTranslations;
        }
    },
    mounted() {
        this.getMenus();
    },
    methods: {
        getMenus(){
            axios.get(`/api/menu/get-menus/${this.loggedUser}`)
                .then(response => {
                    this.menus = response.data;
                    console.log(this.menus);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        updateMenu(){
            console.log('update menu');
        }
    },
    components: {
        Navbar,
        itemMenu
    },
}
</script>
  
<style scoped>
    .manage-menus-container {
        width: 90%;
        margin: auto;
    }
    .new-menu {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
        border: 2px dashed #b17a3b;
        border-radius: 10px;
        padding: 10px;
        cursor: pointer;
    }
    .divider-menus {
        border-top: 2px solid #b17a3b;
        margin-top: 20px;
        margin-bottom: 20px;
    }
</style>