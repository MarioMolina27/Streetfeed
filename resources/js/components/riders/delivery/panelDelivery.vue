<template>
<div class="container-fluid ps-0 pe-0">
    <Navbar :menuItems = 'menuItems'></Navbar>
    <div class="delivery-container">
        <div v-if="loading">
                Cargando...
        </div>
        <div v-else-if="deliveries.length === 0" class="delivery-call-action">
            <noDelivery></noDelivery>
        </div>
        <div v-else style="width: 100%" class="d-flex flex-column">
            <hasDelivery :asosiationDelivery = asosiationDelivery></hasDelivery>
        </div>
    </div>
</div>
</template>

<script>
import Navbar from '../../shared/Navbar.vue';
import noDelivery from './noDelivery.vue';
import hasDelivery from './hasDelivery.vue';
export default{
    data(){
      return {
        menuItems: [
                {name: 'Tus Repartos', href: './delivery'},
                {name: 'Explorar', href: './explore'},
                {name: 'Favoritos', href: './favorite'},
                {name: 'Perfil', href: './profile'}
            ],
        loading: false,
        deliveries: [],
        asosiationDelivery: {}
      }
    },
    methods: {
        getDeliveries() {
            this.loading = true;
            axios.get('/api/delivery/get-user-deliveries/4')
                .then(response => {
                    this.deliveries = response.data;
                    this.doAssosiations(this.deliveries);
                    this.loading = false;
                })
                .catch(error => {
                    console.error('Error al obtener los repartos:', error);
                    this.loading = false;
                });
        },
        doAssosiations(deliveries) {
            Promise.all(deliveries.map(delivery => {
                const provider = delivery.menu.user;

                const providerAddressPromise = this.getAddressFromCoordinates(provider.latitude, provider.longitude)
                    .then(providerLocation => ({
                        provider: { ...provider, location: providerLocation, idDelivery: delivery.id }
                    }))
                    .catch(error => {
                        console.error('Error al obtener la dirección del proveedor:', error);
                        return null;
                    });

                const markerAddressPromise = this.getAddressFromCoordinates(delivery.marker.latitude, delivery.marker.longitude)
                    .then(markerLocation => ({
                        homeless: { ...delivery.marker, location: markerLocation, idDelivery: delivery.id, status: delivery.id_state}
                    }))
                    .catch(error => {
                        console.error('Error al obtener la dirección del marcador:', error);
                        return null;
                    });

                return Promise.all([providerAddressPromise, markerAddressPromise])
                    .then(([providerObj, markerObj]) => {
                        if (providerObj && markerObj) {
                            const nickname = provider.nickname;
                            if (this.asosiationDelivery.hasOwnProperty(nickname)) {
                                this.asosiationDelivery[nickname].push({ ...providerObj, ...markerObj });
                            } else {
                                this.asosiationDelivery[nickname] = [{ ...providerObj, ...markerObj }];
                            }
                        }
                    });
            }))
            .then(() => {
                console.log('Asociaciones completadas');
            })
            .catch(error => {
                console.error('Error al hacer asociaciones:', error);
            });
        },

        getAddressFromCoordinates(latitude, longitude) {
            const accessToken = "pk.eyJ1Ijoic3RyZWV0ZmVlZCIsImEiOiJjbHRkOWMzMXgwMDlyMmpybnA0MGt1N3RpIn0.jBsWG7vIB54CaqmpwbMapw";

            return new Promise((resolve, reject) => {
                fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${longitude},${latitude}.json?access_token=${accessToken}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('No se pudo obtener la información');
                        }
                        return response.json();
                    })
                    .then(markerInfo => {
                        const features = markerInfo.features;
                        if (features.length > 0) {
                            const location = features[0].place_name || 'No se ha encontrado la ubicación';
                            resolve(location);
                        } else {
                            reject('No se encontraron características');
                        }
                    })
                    .catch(error => {
                        console.error('Error al obtener la información:', error);
                        reject(error);
                    });
            });
        }
    },
    mounted(){
        this.getDeliveries();
    },
    components: {
        Navbar,
        noDelivery,
        hasDelivery
    }
}
</script>

<style scoped>
    .delivery-call-action > h1, p {
        text-align: center;
    }
    .delivery-container {
        display: flex;
        justify-content: center;
        padding: 20px;
        height: calc(100vh - 18vh);
    }
    .delivery-call-action {
        width: 80%;
    }
    @media (max-width: 691px) {
        .delivery-call-action {
            width: 95%;
        }
    }
    .button-suggest {
        margin: 0 auto;
        width: 20vw;
        min-width: 250px;
        height: 50px;
        background-color: #984EAE;
        color: #FDF8EB;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s ease;
    }
    .button-suggest:hover {
        background-color: #7a3a81;
        transform: scale(1.01);
    }
</style>