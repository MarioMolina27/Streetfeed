<template>
  <div class="container-fluid ps-0 pe-0">
    <Navbar :menuItems = 'menuItems'></Navbar>
    <template v-if="loading ||!loadingFinished">
        <loader :loading = 'loading' @loading-finished="handleLoadingFinished"></loader>
    </template>
    <div v-else class="explore-container">
      <div v-if="nearProviders.length != 0" class="provider-container">
        <h2>Descubre a tus proveedores más cercanos</h2>
        <div class="card-container d-flex flex-nowrap">
          <template v-for="(provider) in nearProviders">
            <provider-card :provider = provider @favoriteToggled="refreshData"></provider-card>
          </template>
        </div>
      </div>
      <div v-if="hasMoreFavoritesPrvoviders.length != 0" class="provider-container">
        <h2>Los proveedores más queridos</h2>
        <div class="card-container d-flex flex-nowrap">
          <template v-for="(provider) in hasMoreFavoritesPrvoviders">
            <provider-card :provider = provider @favoriteToggled="refreshData"></provider-card>
          </template>
        </div>
      </div>
      <div v-if="favouriteProviders.length != 0" class="provider-container">
        <h2>Favoritos</h2>
        <div class="card-container d-flex flex-nowrap">
          <template v-for="(provider) in favouriteProviders">
            <provider-card :provider = provider @favoriteToggled="refreshData"></provider-card>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import providerCard from './providerCard.vue';
import Navbar from '../../shared/Navbar.vue';
import loader from '../../shared/loader.vue';
export default{
    data(){
      return {
        loading: true,
        loadingFinished: false,
        nearProviders: [],
        hasMoreFavoritesPrvoviders: [],
        favouriteProviders: [],
        menuItems: [
                {name: 'Tus Repartos', href: './delivery'},
                {name: 'Explorar', href: './explore'},
                {name: 'Favoritos', href: './favorite'},
                {name: 'Perfil', href: './profile'}
            ]
      }
    },
    mounted(){
      this.refreshData()
    },
    methods: {
      refreshData() {
        Promise.all([
          axios.get('api/users/near-providers/4'),
          axios.get('api/users/has-more-favourites-providers/4'),
          axios.get('api/users/favourite-providers/4')
        ])
        .then(([nearProvidersResponse, hasMoreFavoritesResponse, favoriteProvidersResponse]) => {
            this.nearProviders = nearProvidersResponse.data;
            this.hasMoreFavoritesPrvoviders = hasMoreFavoritesResponse.data;
            this.favouriteProviders = favoriteProvidersResponse.data;
            this.loading = false;
        })
        .catch(error => {
            console.error('Error al obtener los datos:', error);
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

<style>
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
  margin-top: 1rem;
  overflow-x: auto;
  white-space: nowrap;
  scrollbar-width: none;
}
</style>