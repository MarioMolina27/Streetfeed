<template>
    <h1 class="mt-5 mb-4 font-weight-bold">¿A qué esperas para hacer un reparto?</h1>
    <p class="fs-4 mb-4">Te podemos proporcionar una sugerencia... </p>
    <div class="d-flex justify-content-center flex-column" style="height: calc(100% - 18vh);">
        <button class="button-suggest mb-5 fs-5" @click="doSuggest">Sugiereme!</button>
        <div id="map" style="position: relative;">
            <div v-if="suggestLoading || notSuggest" style="position: absolute; z-index: 1; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);">
                <p v-if="suggestLoading" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white;">Cargando...</p>
                <div v-if="notSuggest" style="position: absolute; z-index: 1; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white;">
                    <h1>No hay sugerencias</h1>
                    <p>Lo sentimos, no hay sugerencias disponibles en este momento.</p>
                </div>
            </div>
        </div>
        
    </div>
</template>
    
<script>
import mapboxgl from 'mapbox-gl';
import 'mapbox-gl/dist/mapbox-gl.css';
export default{
    data(){
        return {
            notSuggest: false,
            suggestLoading: false,
            map: null,
            accessToken: "pk.eyJ1Ijoic3RyZWV0ZmVlZCIsImEiOiJjbHRkOWMzMXgwMDlyMmpybnA0MGt1N3RpIn0.jBsWG7vIB54CaqmpwbMapw",
            mapStyle: "mapbox://styles/mapbox/light-v11",
            defaultLocation: { lat: 41.388752, lng: 2.17271 },
            userCurrentLocation: { latitude: null, longitude: null },
            provider: [],
            homeless: []
        }
    },
    methods: {
        doSuggest(){
            this.suggestLoading = true;
            this.notSuggest = false;
            this.askForLocation()
                .then(() => {
                    axios.get(`/api/users/do-suggest/${this.userCurrentLocation.latitude}/${this.userCurrentLocation.longitude}`)
                        .then(response => {
                            this.provider = response.data.nearest_provider;
                            this.homeless = response.data.nearest_marker;
                            this.createMarker([this.userCurrentLocation.longitude, this.userCurrentLocation.latitude], '#B48753', true);
                            this.createMarker([this.provider.longitude, this.provider.latitude], '#B48753', false);
                            this.createMarker([this.homeless.longitude, this.homeless.latitude], '#984EAE', false);
                            this.createRoute([
                                [this.userCurrentLocation.longitude, this.userCurrentLocation.latitude],
                                [this.provider.longitude, this.provider.latitude],
                                [this.homeless.longitude, this.homeless.latitude]
                            ]);
                            this.suggestLoading = false;
                            this.notSuggest = false;
                        })
                        .catch(error => {
                            console.error('Error al obtener sugerencia de reparto:', error);
                            this.notSuggest = true;
                            this.suggestLoading = false;
                        });
                })
                .catch(error => {
                    console.error('No se pudo obtener la ubicación del usuario:', error);
                    this.notSuggest = true;
                    this.suggestLoading = false;
                });
        },
        askForLocation() {
            return new Promise((resolve, reject) => {
                if (navigator.geolocation) {
                    navigator.geolocation.watchPosition(
                        position => {
                            if (position && position.coords) {
                                this.userCurrentLocation.latitude = position.coords.latitude;
                                this.userCurrentLocation.longitude = position.coords.longitude;
                                const userCurrentCoordenates = [this.userCurrentLocation.longitude, this.userCurrentLocation.latitude];
                                this.map.setCenter(userCurrentCoordenates);
                                resolve();
                            }
                        },
                        error => {
                            console.error('Error al obtener la ubicación:', error.message);
                            reject(error);
                        }
                    );
                } else {
                    console.error('El navegador no soporta la geolocalización');
                    reject(new Error('Geolocalización no soportada'));
                }
            });
        },
        createMarker(coordinates, color, isUser) {
            if (isUser) {
                const userMarker = document.createElement('i');
                userMarker.className = 'fa-solid fa-location-arrow';
                userMarker.style.fontSize = '2.5rem';
                new mapboxgl.Marker({ element: userMarker  })
                    .setLngLat(coordinates)
                    .addTo(this.map);
            } else {
                new mapboxgl.Marker({ color })
                    .setLngLat(coordinates)
                    .addTo(this.map);
            }
        },

        createRoute(coordinates) {
            const profile = 'walking';
            const waypoints = coordinates.map(coord => `${coord[0]},${coord[1]}`).join(';');
            const url = `https://api.mapbox.com/directions/v5/mapbox/${profile}/${waypoints}?geometries=geojson&access_token=${this.accessToken}`;

            axios.get(url)
                .then(response => {
                    const route = response.data.routes[0].geometry;
                    const existingRoute = this.map.getSource('route');
                    if (existingRoute) {
                        this.map.removeLayer('route');
                        this.map.removeSource('route');
                    }
                    this.map.addLayer({
                        id: 'route',
                        type: 'line',
                        source: {
                            type: 'geojson',
                            data: {
                                type: 'Feature',
                                geometry: route
                            }
                        },
                        layout: {
                            'line-cap': 'round',
                            'line-join': 'round'
                        },
                        paint: {
                            'line-color': '#888',
                            'line-width': 5,
                            'line-arrow-width': 2
                        }
                    });
                })
                .catch(error => {
                    console.error('Error al obtener la ruta:', error);
                });
        }
    },
    mounted(){
        mapboxgl.accessToken = this.accessToken;
        this.map = new mapboxgl.Map({
            container: 'map',
            style: this.mapStyle,
            center: this.defaultLocation,
            zoom: 16
        });
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
    #map {
        width: 80%; 
        flex: 1;
        margin: 0 auto;
        padding: 10px;
        border: 2px solid #081733;
        border-radius: 5px;
    }
    .button-suggest {
        margin: 0 auto;
        width: 20vw;
        min-width: 250px;
        height: 50px;
        background-color: #984EAE;
        color: white;
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