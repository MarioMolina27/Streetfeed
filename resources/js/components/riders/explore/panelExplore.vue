<template>
  <div class="container-fluid ps-0 pe-0">
    <Navbar :menuItems = 'menuItems' :currentLanguage = 'lang' :nameRoute="nameRoute"></Navbar>
    <template v-if="loading ||!loadingFinished">
        <loader :loading = 'loading' @loading-finished="handleLoadingFinished"></loader>
    </template>
    <div v-else class="explore-container">
      <template v-if="nearProviders.length == 0 && hasMoreFavoritesPrvoviders.length == 0 && favouriteProviders.length == 0">
          <div class="centered-div-no-deliveries">
              <h1 class="mt-5 mb-4 font-weight-bold text-center">No hay ningún proveedor que proporcione comida en estos momentos</h1>
              <p class="fs-4 mb-4 text-center">Vuelve en otro momento y ayudanos a mejorar el mundo</p>
          </div>               
      </template>
      <template v-else>
        <div v-if="nearProviders.length != 0" class="provider-container">
          <h2>{{translations.discoverProvidersCloseToYou}}</h2>
          <div class="card-container d-flex flex-nowrap">
            <template v-for="(provider) in nearProviders">
              <provider-card :provider = provider :translations = "translations" :user="user" @favoriteToggled="refreshData"></provider-card>
            </template>
          </div>
        </div>
        <div v-if="hasMoreFavoritesPrvoviders.length != 0" class="provider-container">
          <h2>{{translations.discoverProvidersMoreLike}}</h2>
          <div class="card-container d-flex flex-nowrap">
            <template v-for="(provider) in hasMoreFavoritesPrvoviders">
              <provider-card :provider = provider :translations = "translations" :user="user" @favoriteToggled="refreshData"></provider-card>
            </template>
          </div>
        </div>
        <div v-if="favouriteProviders.length != 0" class="provider-container">
          <h2>{{translations.favoriteLabel}}</h2>
          <div class="card-container d-flex flex-nowrap">
            <template v-for="(provider) in favouriteProviders">
              <provider-card :provider = provider :translations = "translations" :user="user" @favoriteToggled="refreshData"></provider-card>
            </template>
          </div>
        </div>  
      </template>
    </div>
  </div>
</template>

<script>
import providerCard from './providerCard.vue';
import Navbar from '../../shared/Navbar.vue';
import loader from '../../shared/loader.vue';
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
        nearProviders: [],
        hasMoreFavoritesPrvoviders: [],
        favouriteProviders: [],
        menuItems: [],
        translations: {},
        nameRoute: './explore'
      }
    }, 
    created() {
      import(`../../../../lang/riders/${this.lang}.json`)
          .then(module => {
              this.translations = module.default;
          })
          .catch(error => {
              console.error(`Error al importar el archivo de idioma: ${error}`);
          });
    },
    mounted(){
      this.menuItems = menuTabs(this.type_user, this.lang);
      this.refreshData()
    },
    methods: {
      refreshData() {
        Promise.all([
          axios.get(`api/users/near-providers/${this.user.id_user}`),
          axios.get(`api/users/has-more-favourites-providers/${this.user.id_user}`),
          axios.get(`api/users/favourite-providers/${this.user.id_user}`)
        ])
        .then(([nearProvidersResponse, hasMoreFavoritesResponse, favoriteProvidersResponse]) => {
            this.nearProviders = nearProvidersResponse.data;
            this.hasMoreFavoritesPrvoviders = hasMoreFavoritesResponse.data;
            this.favouriteProviders = favoriteProvidersResponse.data;
            this.loading = false;
        })
        .catch(error => {
            this.loading = false;
        });
      },
      handleLoadingFinished() {
           this.loadingFinished = true;
      }
    },
    components: {
      providerCard,
      Navbar,
      loader
    },
}
</script>

<style scoped>
body {
  background-color: #FDF8EB;
}

.explore-container {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: 20px;
}
.provider-container {
  margin-bottom: 2rem;
}
.card-container {
  overflow-x: auto;
  white-space: nowrap;
  scrollbar-width: none;
}
</style>