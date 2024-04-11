<template>
    <div class="container-fluid ps-0 pe-0">
        <Navbar :menuItems = 'menuItems'></Navbar>
        <div class="manage-menus-container">
            <div class="col-12">
                <!---<h1 class="text-center mt-4">{{ translations.yourMenusLabel }}</h1> -->
                <div class="new-menu" @click="createMenuItem()">
                    <i class="fa-solid fa-plus fs-5"></i>
                    <span class="fs-5">{{ translations.addMenuLabel }}</span>
                </div>
                <div class="divider-menus">

                </div>
                <template v-for="menu in menus" :key="menu.id">
                    <itemMenu :menu = 'menu' @deleteMenuItem="deleteMenuItem"></itemMenu>
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
                    this.menus.forEach(menu => {
                        menu.creating = false;
                        menu.editing = false;
                    });
                })
                .catch(error => {
                    console.log(error);
                });
        },
        updateMenu(){
            console.log('update menu');
        },
        createMenuItem(){
            let menu = {
                id: this.generateRandomId(),
                title: null,
                first_product: null,
                second_product: null,
                drink_product: null,
                launchpack: [],
                active: 1,
                user_id: this.user.id,
                creating: true,
                editing: false
            }
            this.menus.unshift(menu);
        },
        deleteMenuItem(menu) {
            const index = this.menus.findIndex(m => m.id === menu.id);
            if (index !== -1) {
                let menus= this.menus.slice(0, index).concat(this.menus.slice(index + 1));
                console.log(menus);
            }
        },

        generateRandomId() {
            let id;
            do {
                id = Math.floor(Math.random() * 10000); 
                id += 'l'; 
            } while (this.menus.some(menu => menu.id === id));
            return id;
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