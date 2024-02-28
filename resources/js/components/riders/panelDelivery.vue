<template>
  <div class="delivery-container">
    <div class="provider-container">
      <h2>Descubre a tus proveedores más cercanos</h2>
      <div class="card-container d-flex flex-nowrap">
        <template v-for="(provider) in providers">
          <provider-card :provider = provider></provider-card>
        </template>
      </div>
    </div>
    <div class="provider-container">
      <h2>Los proveedores más queridos</h2>
      <div class="card-container d-flex flex-nowrap">
        <template v-for="(provider) in providers">
          <provider-card :provider = provider></provider-card>
        </template>
      </div>
    </div>
    <div class="provider-container">
      <h2>Favoritos</h2>
      <div class="card-container d-flex flex-nowrap">
        <template v-for="(provider) in providers">
          <provider-card :provider = provider></provider-card>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
import providerCard from './providerCard.vue';
export default{
    data(){
      return {
        providers : [
          {
            id: 1,
            name: 'Proveedor A',
            image: 'breakfastProvider.png',
            scheduleShift1: '08:00 - 12:00',
            scheduleShift2: '14:00 - 18:00',
            menusAvailable: 4,
            distance: '2km',
            city: 'Barcelona',
            adress: 'Calle Arago 14',
            menu: [
              {
                id: 1,
                name: 'Hamburguesa',
                firstProduct: 'Hamburguesa',
                secondProduct: 'Patatas',
                drink: 'Agua',
                available: 5
              },
              {
                id: 2,
                name: 'Pizza',
                firstProduct: 'Pizza',
                secondProduct: 'Ensalada',
                drink: 'Coca-cola',
                available: 1
              },
              {
                id: 3,
                name: 'Ensalada',
                firstProduct: 'Ensalada',
                secondProduct: 'Pan',
                drink: 'Agua',
                available: 3
              }
            ],
            isFavorite: true
          },
          {
            id: 2,
            name: 'Proveedor B',
            image: 'hamburgerProvider.png',
            scheduleShift1: '09:00 - 13:00',
            scheduleShift2: null,
            menusAvailable: 2,
            distance: '5km',
            city: 'Barcelona',
            adress: 'Rambla Catalunya 1',
            menu: [
              {
                id: 1,
                name: 'Hamburguesa',
                firstProduct: 'Hamburguesa',
                secondProduct: 'Patatas',
                drink: 'Agua',
                available: 5
              },
              {
                id: 2,
                name: 'Pizza',
                firstProduct: 'Pizza',
                secondProduct: 'Ensalada',
                drink: 'Coca-cola',
                available: 1
              },
              {
                id: 3,
                name: 'Ensalada',
                firstProduct: 'Ensalada',
                secondProduct: 'Pan',
                drink: 'Agua',
                available: 3
              }
            ],
            isFavorite: false
          },
          {
            id: 3,
            name: 'Proveedor C',
            image: 'hamburgerProvider.png',
            scheduleShift1: '07:00 - 11:00',
            scheduleShift2: '15:00 - 19:00',
            menusAvailable: 12,
            distance: '1km',
            city: 'Barcelona',
            adress: 'Plaza Espanya 1',
            menu: [
              {
                id: 1,
                name: 'Hamburguesa',
                firstProduct: 'Hamburguesa',
                secondProduct: 'Patatas',
                drink: 'Agua',
                available: 5
              },
              {
                id: 2,
                name: 'Pizza',
                firstProduct: 'Pizza',
                secondProduct: 'Ensalada',
                drink: 'Coca-cola',
                available: 1
              },
              {
                id: 3,
                name: 'Ensalada',
                firstProduct: 'Ensalada',
                secondProduct: 'Pan',
                drink: 'Agua',
                available: 3
              }
            ],
            isFavorite: false
          },
          {
            id: 4,
            name: 'Proveedor D',
            image: 'breakfastProvider.png',
            scheduleShift1: '10:00 - 14:00',
            scheduleShift2: null,
            menusAvailable: 1,
            distance: '7km',
            city: 'Barcelona',
            adress: 'Plaza Urquinaona 10',
            menu: [
              {
                id: 1,
                name: 'Hamburguesa',
                firstProduct: 'Hamburguesa',
                secondProduct: 'Patatas',
                drink: 'Agua',
                available: 5
              },
              {
                id: 2,
                name: 'Pizza',
                firstProduct: 'Pizza',
                secondProduct: 'Ensalada',
                drink: 'Coca-cola',
                available: 1
              },
              {
                id: 3,
                name: 'Ensalada',
                firstProduct: 'Ensalada',
                secondProduct: 'Pan',
                drink: 'Agua',
                available: 3
              }
            ],
            isFavorite: true
          },
          {
            id: 5,
            name: 'Proveedor E',
            image: 'hamburgerProvider.png',
            scheduleShift1: '11:00 - 15:00',
            scheduleShift2: '17:00 - 21:00',
            menusAvailable: 9,
            distance: '4km',
            city: 'Barcelona',
            adress: 'Plaza Urquinaona 10',
            menu: [
              {
                id: 1,
                name: 'Hamburguesa',
                firstProduct: 'Hamburguesa',
                secondProduct: 'Patatas',
                drink: 'Agua',
                available: 5
              },
              {
                id: 2,
                name: 'Pizza',
                firstProduct: 'Pizza',
                secondProduct: 'Ensalada',
                drink: 'Coca-cola',
                available: 1
              },
              {
                id: 3,
                name: 'Ensalada',
                firstProduct: 'Ensalada',
                secondProduct: 'Pan',
                drink: 'Agua',
                available: 3
              }
            ],
            isFavorite: false
          },
          {
            id: 6,
            name: 'Proveedor F',
            image: 'breakfastProvider.png',
            scheduleShift1: '10:00 - 14:00',
            scheduleShift2: null,
            menusAvailable: 1,
            distance: '7km',
            city: 'Barcelona',
            adress: 'Calle Numancia 111',
            menu: [
              {
                id: 1,
                name: 'Hamburguesa',
                firstProduct: 'Hamburguesa',
                secondProduct: 'Patatas',
                drink: 'Agua',
                available: 5
              },
              {
                id: 2,
                name: 'Pizza',
                firstProduct: 'Pizza',
                secondProduct: 'Ensalada',
                drink: 'Coca-cola',
                available: 1
              },
              {
                id: 3,
                name: 'Ensalada',
                firstProduct: 'Ensalada',
                secondProduct: 'Pan',
                drink: 'Agua',
                available: 3
              }
            ],
            isFavorite: true
          },
          {
            id: 7,
            name: 'Proveedor G',
            image: 'hamburgerProvider.png',
            scheduleShift1: '11:00 - 15:00',
            scheduleShift2: '17:00 - 21:00',
            menusAvailable: 9,
            distance: '4km',
            city: 'Barcelona',
            adress: 'Avenida Roma 12',
            menu: [
              {
                id: 1,
                name: 'Hamburguesa',
                firstProduct: 'Hamburguesa',
                secondProduct: 'Patatas',
                drink: 'Agua',
                available: 5
              },
              {
                id: 2,
                name: 'Pizza',
                firstProduct: 'Pizza',
                secondProduct: 'Ensalada',
                drink: 'Coca-cola',
                available: 1
              },
              {
                id: 3,
                name: 'Ensalada',
                firstProduct: 'Ensalada',
                secondProduct: 'Pan',
                drink: 'Agua',
                available: 3
              }
            ],
            isFavorite: false
          }
        ]
      }
    },
    components: {
      providerCard
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