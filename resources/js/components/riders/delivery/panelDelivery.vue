<template>
<div class="container-fluid ps-0 pe-0">
    <Navbar :menuItems = 'menuItems' :currentLanguage = 'lang' :nameRoute="nameRoute"></Navbar>
    <template v-if="loading ||!loadingFinished">
        <loader :loading = 'loading' @loading-finished="handleLoadingFinished"></loader>
    </template>
    <div v-else class="delivery-container">
        <div v-if="deliveries.length === 0" class="delivery-call-action">
            <noDelivery :translations="translations" :user = "user"></noDelivery>
        </div>
        <div v-else style="width: 100%" class="d-flex flex-column">
            <hasDelivery :asosiationDelivery = "asosiationDelivery" :lang="lang" :translations="translations" @isChanging="onChangeDeliveries" @notifyDeliver="notifyDeliver"></hasDelivery>
        </div>
    </div>
</div>
</template>

<script>
import Navbar from '../../shared/Navbar.vue';
import noDelivery from './noDelivery.vue';
import hasDelivery from './hasDelivery.vue';
import loader from '../../shared/loader.vue';
import {menuTabs} from '../../../utilities/menuTabs.js';
export default{
    props: {
        user: Object,
        lang: String,
        type_user: Array
    },
    data(){
      return {
        menuItems: [],
        loading: true,
        loadingFinished: false,
        deliveries: [],
        asosiationDelivery: {},
        translations: {},
        nameRoute: './delivery'
      }
    },
    methods: {
        getDeliveries() {
            this.loading = true;
            axios.get(`/api/delivery/get-user-deliveries/${this.user.id_user}`)
                .then(response => {
                    this.deliveries = [];
                    this.deliveries = response.data;
                    this.doAssosiations(this.deliveries);
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                });
        },
        doAssosiations(deliveries) {
            this.asosiationDelivery = {};
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
        },
        handleLoadingFinished() {
           this.loadingFinished = true;
        },
        onChangeDeliveries(deliveryIds) {
            for (const assosiation in this.asosiationDelivery) {
                if (this.asosiationDelivery.hasOwnProperty(assosiation)) {
                    const providers = this.asosiationDelivery[assosiation];
                    for (const provider of providers) {
                        if (deliveryIds.includes(provider.homeless.idDelivery)) {
                            provider.homeless.status = 2;
                        }
                    }
                }
            }
        },
        notifyDeliver(deliveryId) {
            for (const assosiation in this.asosiationDelivery) {
                if (this.asosiationDelivery.hasOwnProperty(assosiation)) {
                    const providers = this.asosiationDelivery[assosiation];
                    const remainingProviders = providers.filter(provider => {
                        return provider.homeless.idDelivery !== deliveryId;
                    });

                    if (remainingProviders.length === 0) {
                        delete this.asosiationDelivery[assosiation];
                    } else {
                        this.asosiationDelivery[assosiation] = remainingProviders;
                    }
                }
            }
            if (Object.keys(this.asosiationDelivery).length === 0) {
                this.deliveries = [];
            }
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
        this.getDeliveries();
    },
    components: {
        Navbar,
        noDelivery,
        hasDelivery,
        loader
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