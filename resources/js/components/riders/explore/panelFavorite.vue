<template>
    <div class="container-fluid ps-0 pe-0">
        <Navbar :menuItems = 'menuItems' :currentLanguage = 'lang'></Navbar>
        <div class="favorite-container">
            <template v-if="loading ||!loadingFinished">
                <loader :loading = 'loading' @loading-finished="handleLoadingFinished"></loader>
            </template>
            <div v-else-if="favoriteProviders.length === 0" class="favorite-call-action">
                <h1 class="mt-5 mb-4 font-weight-bold">{{translations.haveNotFavorites}}</h1>
                <p class="fs-5">{{translations.doClickToAddFavorite}}</p>
                <div class="d-flex justify-content-center" style="width: 100%;">
                    <div class="skeleton-card">
                        <Skeleton width="100%" height="10rem"></Skeleton>
                        <button class="heart-button" style="outline: 0;">
                            <i class="pi pi-heart" style="color: #984EAE; font-size: 1.75rem"></i>
                        </button>
                        <div class="d-flex mt-4 mb-3">
                            <div class="ms-2" style="width: 100%;">
                                <Skeleton width="50%" class="mb-2"></Skeleton>
                                <Skeleton width="20%" class="mb-2"></Skeleton>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <Skeleton class="ms-2" width="30%" height="2rem"></Skeleton>
                            <Skeleton class="me-2" width="30%" height="2rem"></Skeleton>
                        </div>
                    </div>
                </div>
                <button class="button-explore mb-2" @click="goExplore">{{translations.exploreProviders}}</button>
            </div>
            <div v-else style="width: 100%" class="d-flex flex-column">
                <h1 class="mt-3 mb-4" style="text-align: center;">{{translations.yourFavoritesLabel}}</h1>
                <div class="row">
                    <template v-for="(provider) in favoriteProviders">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 mb-3 d-flex justify-content-center">
                            <favorite-card :provider = provider :translations = "translations" @favoriteToggled="refreshData"></favorite-card>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from '../../shared/Navbar.vue';
import loader from '../../shared/loader.vue';
import favoriteCard from './favoriteCard.vue';
import Skeleton from 'primevue/skeleton';
import {menuTabs} from '../../../utilities/menuTabs.js'
export default{
    props: {
        user: Object,
        lang: String,
        type_user: Array
    },
    data(){
      return {
        loading: true,
        loadingFinished: false,
        favoriteProviders: [],
        menuItems: [],
        translations: {}
      }
    },
    created() {
        import(`../../../../lang/riders/${this.lang}.json`)
            .then(module => {
                this.translations = module.default;
                console.log(this.translations);
            })
            .catch(error => {
                console.error(`Error al importar el archivo de idioma: ${error}`);
            });
    },
    mounted(){
        this.menuItems = menuTabs(this.type_user);
        this.refreshData()
    },
    methods: {
        refreshData() {
            axios.get('api/users/favourite-providers/4')
                .then(response => {
                    this.favoriteProviders = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.error('Error al cargar los proveedores favoritos:', error);
                    this.loading = false;
                });
        },
        goExplore() {
            window.location.href = './explore';
        },
        handleLoadingFinished() {
           this.loadingFinished = true;
        } 
    },
    components: {
        Navbar,
        loader,
        favoriteCard,
        Skeleton
    }
}
</script>

<style scoped>
    .favorite-call-action > h1, p {
        text-align: center;
    }
    .favorite-container {
        display: flex;
        justify-content: center;
        padding: 20px;
    }
    .favorite-call-action {
        width: 80%;
    }
    .skeleton-card {
        position: relative;
        width: 30rem;
        height: 20rem;
        margin-top: 5rem;
        border-radius: 5px;
        border: 2px solid #ad8a62;
        background-color: #FDF8EB;
    }
    .heart-button {
        cursor: pointer;
        position: absolute;
        top: 0;
        right: 0;
        background-color: transparent;
        border: none;
        color: white;
        padding: 10px;
        z-index: 2;
        transition: transform 0.3s ease-in-out;
    }
    .button-explore {
        position: absolute;
        bottom: 20px;
        right: 0;
        left: 0;
        margin: 0 auto;
        width: 70%;
        height: 50px;
        background-color: #984EAE;
        color: white;
        font-size: 1.5rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s ease;
    }
    .button-explore:hover {
        background-color: #7a3a81;
        transform: scale(1.01);
    }
</style>