<template>
    <div class="container-fluid ps-0 pe-0">
        <Navbar :menuItems = 'menuItems'></Navbar>
        <template v-if="loading ||!loadingFinished">
            <loader :loading = 'loading' @loading-finished="handleLoadingFinished"></loader>
        </template>
        <div v-else class="manage-menus-container">
            <Toast />
            <div class="col-12">
                <!---<h1 class="text-center mt-4">{{ translations.yourMenusLabel }}</h1> -->
                <div class="new-menu" @click="createMenuItem()">
                    <i class="fa-solid fa-plus fs-5"></i>
                    <span class="fs-5">{{ translations.addMenuLabel }}</span>
                </div>
                <div class="divider-menus">

                </div>
                <template v-for="menu in menus" :key="menu.id_menu">
                    <itemMenu :menu = 'menu' @deleteMenuItem="deleteMenuItem" @showError="showError"></itemMenu>
                </template>
            </div>
        </div>
    </div>
</template>
  
<script >
import Navbar from '../../shared/Navbar.vue';
import itemMenu from './itemMenu.vue';
import esTranslations from '../../../../lang/es.json';
import enTranslations from '../../../../lang/en.json';
import caTranslations from '../../../../lang/ca.json';
import loader from '../../shared/loader.vue';
import Toast from 'primevue/toast';

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
            menus: [],
            translations: {},
            loading: true,
            loadingFinished: false
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
            console.log(this.user.id_user);
            axios.get(`/api/menu/get-menus/${this.user.id_user}`)
                .then(response => {
                    this.menus = response.data;
                    this.menus.forEach(menu => {
                        menu.creating = false;
                        menu.editing = false;
                    });
                    this.loading = false;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        createMenuItem(){
            let menu = {
                id_menu: this.generateRandomId(),
                title: null,
                first_product: null,
                second_product: null,
                drink_product: null,
                launchpack: [],
                active: 1,
                user_id: this.user.id_user,
                creating: true,
                editing: false
            }
            this.menus.unshift(menu);
        },
        deleteMenuItem(menu) {
            const index = this.menus.findIndex(m => m.id_menu === menu.id_menu);
            console.log(index);
            if (index !== -1) {
                this.menus.splice(index, 1); // Elimina 1 elemento en la posición 'index'
                console.log(this.menus);
            }
        },

        generateRandomId() {
            let id;
            do {
                id = Math.floor(Math.random() * 10000); 
                id += 'l'; 
            } while (this.menus.some(menu => menu.id === id));
            return id;
        },
        handleLoadingFinished(){
            this.loadingFinished = true;
        },

        showError(message) {
            this.$toast.add({ severity: 'error', summary: 'Error', detail: message, life: 3000 });
        }
    },
    components: {
        Navbar,
        itemMenu,
        loader,
        Toast
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
        border: 3px dashed #b17a3b;
        border-radius: 10px;
        padding: 10px;
        cursor: pointer;
        font-weight: 700;
        color: #b17a3b;
    }
    .divider-menus {
        border-top: 2px solid #b17a3b;
        margin-top: 20px;
        margin-bottom: 20px;
    }
</style>