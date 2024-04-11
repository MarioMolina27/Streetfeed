<template>
    <div class="container-fluid ps-0 pe-0">
        <Navbar :menuItems = 'menuItems' :currentLanguage = 'lang'></Navbar>
        <div style="position: relative;">
            <div id="map" style="width: 100%; height: calc(100vh - 10vh);"></div>
            <div class="menus-container ms-2">
                <div class="d-flex justify-content-between mb-3">
                    <span class="me-4">{{translations.menusToAssign}}: </span>
                    <strong style="color: #984EAE;">{{ launchpacks }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="me-4">{{translations.menusAssigned}}: </span>
                    <strong class="d-flex flex-column justify-content-center" style="color: #984EAE;">{{ launchpacksLeft }}</strong>
                </div>
            </div>
            <div class="homeless-assigning">
                <Carousel ref="assignedCarrousel" v-if="homelessInformation.length > 0" :autoplayInterval=3000 :value="homelessInformation" :numVisible="1" :numScroll="1" :showIndicators="false">
                    <template #item="item">
                        <homelessInformation :information  = "item" :translations = "translations" @marker-removed="handleMarkerRemoved"></homelessInformation>
                    </template>
                </Carousel>
            </div>
            <button class="delivery-button" :class="{ 'disabled-button': launchpacksLeft !== 0 }" :disabled="launchpacksLeft !== 0" @click="doReserve">{{ launchpacksLeft !== 0 ? translations.assignAllMenus : translations.doDelivery }}</button>
        </div>
    </div>
</template>

<script>
import Navbar from '../../shared/Navbar.vue';
import homelessInformation from './homelessInformation.vue';
import mapboxgl from 'mapbox-gl';
import 'mapbox-gl/dist/mapbox-gl.css';
import Carousel from 'primevue/carousel';
import {menuTabsTwicePoints} from '../../../utilities/menuTabs.js'

export default {
    props: {
        menusjson: String,
        user: Object,
        lang: String,
        type_user: Array
    },
    data() {
        return {
            menuItems: [],
            map: null,
            accessToken: "pk.eyJ1Ijoic3RyZWV0ZmVlZCIsImEiOiJjbHRkOWMzMXgwMDlyMmpybnA0MGt1N3RpIn0.jBsWG7vIB54CaqmpwbMapw",
            mapStyle: "mapbox://styles/mapbox/light-v11",
            defaultLocation: { lat: 41.388752, lng: 2.17271 },
            userId: 4,
            reserveData: [],
            userCurrentLocation: { latitude: null, longitude: null },
            menus: JSON.parse(this.menusjson),
            launchpacks: 0,
            launchpacksLeft: 0,
            homelessMarkers: [],
            homelessInformation: [],
            translations: {}
        };
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
    mounted() {
        this.menuItems = menuTabsTwicePoints(this.type_user);
        mapboxgl.accessToken = this.accessToken;
        this.map = new mapboxgl.Map({
            container: 'map',
            style: this.mapStyle,
            center: this.defaultLocation,
            zoom: 16
        });
        this.countLaunchpacks();
        axios.get(`api/users/reserve-data/${this.userId}/${this.menus[0].id}`)
            .then(response => {
                this.reserveData = response.data;
                this.reserveData.markers.forEach(marker => {
                    const { latitude, longitude } = marker;
                    this.createMarker([longitude, latitude], '#984EAE', marker);
                });

                const { latitude: providerLat, longitude: providerLng } = this.reserveData.provider;
                this.createMarker([providerLng, providerLat], '#B48753', null);
            })
            .catch(error => {
                console.error('Error al obtener los datos de reserva:', error);
            });
    },
    beforeDestroy() {
            this.map.remove();
    },
    methods: {
        countLaunchpacks() {
            this.menus.forEach(menu => {
                this.launchpacks += menu.launchpacks;
            });
            this.launchpacksLeft = this.launchpacks;
        },
        
        createMarker(coordinates, color, data) {
            const marker = new mapboxgl.Marker({ color: color })
                .setLngLat(coordinates)
                .addTo(this.map);
            if (data !== null) {
                const popupContent = `
                    <div class="mb-2" style="text-align: center;">
                        <strong class="fs-3" style="color: #984EAE; margin-right: 10px;">${data.num_people_not_eat}</strong>
                        <i class="fa-solid fa-user fs-4"></i><i class="fa-solid fa-utensils fs-4"></i>
                    </div>
                    <button id="popup-button-${data.id_marker}" class="btn" style="background-color:#984EAE; color: #FDF8EB; border: none;display: block; margin: 0 auto;">${this.translations.assignMarker}</button>
                `;
                
                marker.setPopup(new mapboxgl.Popup({ closeButton: false }).setHTML(popupContent));

                marker.getPopup().once('open', () => {
                    const popupButton = document.getElementById(`popup-button-${data.id_marker}`);
                    if (popupButton) {
                        popupButton.addEventListener('click', e => { 
                            this.handleButtonClick(data, marker) });
                    } else {
                        console.error('Elemento con ID popup-button no encontrado.');
                    }
                });
            
            }
            
            marker.getElement().addEventListener('mouseenter', () => {
                marker.getElement().style.cursor ="pointer";
                marker.togglePopup();
            });

            marker.getElement().addEventListener('mouseleave', () => {
                marker.getElement().style.cursor ="default";
            });

            this.map.on('click', () => {
                
            });
            
        },
        handleButtonClick(data, marker) {
            this.addHomeless(data);
            if(this.launchpacksLeft !== 0) {
                marker.remove();
            }
        },

        addHomeless(data) {
            fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${data.longitude},${data.latitude}.json?access_token=${this.accessToken}`)
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
                        if(this.launchpacksLeft !== 0) {
                            if (data.num_people_not_eat >= this.launchpacksLeft) {
                                const people_eat = this.launchpacksLeft;
                                this.launchpacksLeft = 0;
                                this.addToEatenList(data.id_marker, location, people_eat);
                                const mapContainer = document.getElementById('map');
                                mapContainer.style.opacity = '0.5';
                                mapContainer.style.filter = 'grayscale(100%)';
                            } else {
                                this.launchpacksLeft -= data.num_people_not_eat;
                                this.addToEatenList(data.id_marker, location, data.num_people_not_eat);
                            } 
                        }
                    }
                })
                .catch(error => {
                    console.error('Error al obtener la información:', error);
                });
        },
        addToEatenList(id_marker, location, people_eat) {
            this.homelessInformation.push({
                id_marker: id_marker,
                location: location,
                people_eat: people_eat
            });
        },
        handleMarkerRemoved(markerData) {
            const mapContainer = document.getElementById('map');
            mapContainer.style.opacity = '1';
            mapContainer.style.filter = 'none';
            this.homelessInformation = this.homelessInformation.filter(information => information.id_marker !== markerData.id);
            const { id, peopleEat } = markerData;
            this.launchpacksLeft += peopleEat;
            const markerObject = this.reserveData.markers.find(marker => marker.id_marker === id);
            this.createMarker([markerObject.longitude, markerObject.latitude], '#984EAE', markerObject);
            if(this.homelessInformation.length > 0) {
                this.$refs.assignedCarrousel.$el.querySelector('.p-carousel-prev').click();
            }
        },
        doReserve() {
            if(this.launchpacksLeft === 0) {
                axios.post('api/delivery/do-reserve', {
                    userId: this.userId,
                    menus: this.menus,
                    assignMarkers: this.homelessInformation
                })
                .then(response => {
                    const encodedHomelessData = btoa(JSON.stringify(this.homelessInformation));
                    console.log('Datos enviados al servidor:', this.homelessInformation);
                    console.log('Encoded Homeless Data:', encodedHomelessData);
                    window.location.href = '../confirmation/' + encodeURIComponent(encodedHomelessData);
                })
                .catch(error => {
                    const encodedHomelessData = btoa(JSON.stringify(null));
                    window.location.href = '../confirmation/' + encodeURIComponent(encodedHomelessData);
                });
            }
        }
    },
    components: {
        Navbar,
        homelessInformation,
        Carousel
    }
}
</script>

<style>
    #map {
        position: relative;
        width: 100vw;
        height: 100%;
    }
    .mapboxgl-ctrl-bottom-left{
        display: none !important;
    }
    .mapboxgl-ctrl.mapboxgl-ctrl-attrib {
        display: none !important;
    }
    .menus-container {
        position: absolute;
        top: 10px; 
        right: 10px; 
        background-color: #FDF8EB; 
        padding: 20px;
        border-radius: 5px;
        border: 1px solid #B48753;
        font-size: 1.5rem;
        box-shadow: 0px 0px 10px #b487537a;
    }
    .homeless-assigning {
        position: absolute;
        bottom: 70px; 
        right: 0;
        left: 0;
        margin: 0 auto;
        width: 93%;
        
    }
    .homeless-information {
        margin: 10px 0;
        background-color: #FDF8EB; 
        padding: 20px;
        border-radius: 5px;
        border: 1px solid #B48753;
        font-size: 1.5rem;
        box-shadow: 0px 0px 10px #b487537a;
        display: flex;
        justify-content: space-between;
    }
    .delivery-button {
        position: absolute;
        bottom: 10px;
        right: 0;
        left: 0;
        margin: 0 auto;
        width: 90%;
        height: 50px;
        background-color: #984EAE;
        color: white;
        font-size: 1.5rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .disabled-button {
        background-color: #ccc;
        border: #555 1px solid;
        color: #000;
        cursor: not-allowed;
    }
    button.p-carousel-prev.p-link.p-disabled, button.p-carousel-next.p-link.p-disabled, button.p-carousel-prev.p-link, button.p-carousel-next.p-link {
        color: #984EAE;
        opacity: 1;
        background-color: #FDF8EB;
        border: #B48753 1px solid;
    }
    button.p-carousel-prev.p-link.p-disabled, button.p-carousel-next.p-link.p-disabled {
        color: #c4accc;

    }
    button.p-carousel-prev.p-link.p-disabled, button.p-carousel-prev.p-link {
        border-right: 0;
        border-radius: 5px 0 0 5px;
    }
    button.p-carousel-next.p-link.p-disabled, button.p-carousel-next.p-link {
        border-left: 0;
        border-radius: 0 5px 5px 0;
    }
    button.p-carousel-prev.p-link:hover, button.p-carousel-next:hover {
        background-color: #ffe9b2;
    }
</style>