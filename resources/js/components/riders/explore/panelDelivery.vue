<template>
  <div class="container-fluid ps-0 pe-0">
    <Navbar :menuItems = 'menuItems'></Navbar>
    <div class="delivery-container">
      <div class="provider-container">
        <h2>Descubre a tus proveedores más cercanos</h2>
        <div class="card-container d-flex flex-nowrap">
          <template v-for="(provider) in nearProviders">
            <provider-card :provider = provider @favoriteToggled="refreshData"></provider-card>
          </template>
        </div>
      </div>
      <div class="provider-container">
        <h2>Los proveedores más queridos</h2>
        <div class="card-container d-flex flex-nowrap">
          <template v-for="(provider) in hasMoreFavoritesPrvoviders">
            <provider-card :provider = provider @favoriteToggled="refreshData"></provider-card>
          </template>
        </div>
      </div>
      <div class="provider-container">
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
import Navbar from '../../admin/Navbar.vue';
export default{
    data(){
      return {
        nearProviders: [],
        hasMoreFavoritesPrvoviders: [],
        favouriteProviders: [],
        menuItems: [
          {name: 'Inicio', href: '/'},
          {name: 'Explorar', href: '/explore'},
          {name: 'Reservas', href: '/reservations'},
          {name: 'Perfil', href: '/profile'}
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
        })
        .catch(error => {
            console.error('Error al obtener los datos:', error);
        });
      }
    },
    components: {
      providerCard,
      Navbar
    },
}
</script>

<style>
body {
  background-color: #FDF8EB;
}
.delivery-container {
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