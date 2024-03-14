<template>
    <h1 class="mt-5 mb-4 font-weight-bold">¿A qué esperas para hacer un reparto?</h1>
    <p class="fs-4 mb-4">Te podemos proporcionar una sugerencia... </p>
    <div class="d-flex justify-content-center flex-column" style="height: calc(100% - 18vh);">
        <button class="button-suggest mb-5 fs-5" @click="doSuggest">Sugiereme!</button>
        <div id="map-container" style="position: relative;" class="mt-3">
            <div id="map" style="position: relative;"></div>
            <div v-if="suggestState === 'notSuggest'" class="map-unavailable"></div>
            <div v-else-if="suggestState === 'loading'" class="map-unavailable">
                <p class="unavailable-text">Cargando...</p>
            </div>
            <div v-else-if="suggestState === 'noSuggestions'" class="map-unavailable">
                <h1 class="unavailable-heading">No hay sugerencias</h1>
                <p class="unavailable-text">Lo sentimos, no hay sugerencias disponibles en este momento.</p>
            </div>
            <div v-if="suggestState === 'ready'" :class="{ 'selected': selectedProfile === 'walking' }" class="button-profile-route" style="left: 10px;" @click="createRoute('walking')">
                <i class="fa-solid fa-person-walking" style="color: #FDF8EB;"></i>
            </div>
            <div v-if="suggestState === 'ready'" :class="{ 'selected': selectedProfile === 'driving' }" class="button-profile-route" style="left: 70px;" @click="createRoute('driving')">
                    <i class="fa-solid fa-car" style="color: #FDF8EB;"></i>
            </div>
            <div v-if="suggestState === 'ready'" :class="{ 'selected': selectedProfile === 'cycling' }" class="button-profile-route" style="left: 130px;" @click="createRoute('cycling')">
                <i class="fa-solid fa-bicycle" style="color: #FDF8EB;"></i>
            </div>
            <div v-if="suggestState === 'ready'" class="duration-route">
                {{ routeDuration }}
            </div>
            <div v-if="suggestState === 'ready'" class="button-center-map" @click="centerMap">
                <i class="fa-solid fa-location-crosshairs" style="color: #FDF8EB;"></i>
            </div>
            <button v-if="suggestState === 'ready'" class="button-reserve" @click="doReserve">RESERVA</button>
        </div>
        
            
        
    </div>
</template>
    
<script>
import mapboxgl from 'mapbox-gl';
import 'mapbox-gl/dist/mapbox-gl.css';
export default{
    data(){
        return {
            suggestState: "notSuggest",
            map: null,
            accessToken: "pk.eyJ1Ijoic3RyZWV0ZmVlZCIsImEiOiJjbHRkOWMzMXgwMDlyMmpybnA0MGt1N3RpIn0.jBsWG7vIB54CaqmpwbMapw",
            mapStyle: "mapbox://styles/mapbox/light-v11",
            defaultLocation: { lat: 41.388752, lng: 2.17271 },
            userCurrentLocation: { latitude: null, longitude: null },
            selectedProfile: 'walking',
            routeDuration: null,
            coordinates: [],
            provider: [],
            homeless: []
        }
    },
    methods: {
        doSuggest(){
            window.devicePixelRatio

            this.suggestState = 'loading';
            this.askForLocation()
                .then(() => {
                    axios.get(`/api/users/do-suggest/${this.userCurrentLocation.latitude}/${this.userCurrentLocation.longitude}`)
                        .then(response => {
                            this.suggestState = 'ready';
                            this.provider = response.data.nearest_provider;
                            this.homeless = response.data.nearest_marker;
                            this.createMarker([this.userCurrentLocation.longitude, this.userCurrentLocation.latitude], '#B48753', true);
                            this.createMarker([this.provider.longitude, this.provider.latitude], '#B48753', false);
                            this.createMarker([this.homeless.longitude, this.homeless.latitude], '#984EAE', false);
                            this.coordinates = [
                                [this.userCurrentLocation.longitude, this.userCurrentLocation.latitude],
                                [this.provider.longitude, this.provider.latitude],
                                [this.homeless.longitude, this.homeless.latitude]
                            ];
                            this.createRoute(this.selectedProfile);
                            this.centerMap();
                        })
                        .catch(error => {
                            console.error('Error al obtener sugerencia de reparto:', error);
                            this.suggestState = 'noSuggestions';
                        });
                })
                .catch(error => {
                    console.error('No se pudo obtener la ubicación del usuario:', error);
                    this.suggestState = 'noSuggestions';
                });
        },
        askForLocation() {
            return new Promise((resolve, reject) => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        position => {
                            if (position && position.coords) {
                                this.userCurrentLocation.latitude = position.coords.latitude;
                                this.userCurrentLocation.longitude = position.coords.longitude;
                                resolve();
                            } else {
                                console.error('No se pudo obtener la ubicación del usuario');
                                reject(new Error('No se pudo obtener la ubicación del usuario'));
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

        createRoute(profile) {
            this.selectedProfile = profile;
            const waypoints = this.coordinates.map(coord => `${coord[0]},${coord[1]}`).join(';');
            const url = `https://api.mapbox.com/directions/v5/mapbox/${this.selectedProfile}/${waypoints}?geometries=geojson&access_token=${this.accessToken}`;

            axios.get(url)
                .then(response => {
                    const route = response.data.routes[0].geometry;
                    const duration = response.data.routes[0].duration;
                    console.log('Duración de la ruta:', duration);
                    this.routeDuration = this.formatDuration(duration);
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
                            'line-width': 5
                        }
                    });
                })
                .catch(error => {
                    console.error('Error al obtener la ruta:', error);
                });
        },
        formatDuration(durationInSeconds) {
            const minutes = Math.floor(durationInSeconds / 60);
            const seconds = Math.ceil(durationInSeconds % 60);
            return `${minutes} min ${seconds} sec`;
        },
        centerMap() {
            this.map.setCenter([this.userCurrentLocation.longitude, this.userCurrentLocation.latitude]);
        },
        doReserve(){
            console.log('Hacer reserva');
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
    #map {
        width: 100%;
        height: 100%;
    }
    #map-container {
        width: 80%; 
        flex: 1;
        margin: 0 auto;
        border: 2px solid #081733;
        border-radius: 5px;
    }
    .map-unavailable {
        position: absolute;
        z-index: 1;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center; 
    }
    .unavailable-text {
        color: #FDF8EB;
        text-align: center;
    }
    .unavailable-heading {
        color: #FDF8EB;
        text-align: center;
        font-size: 24px;
    }
    .map-not-suggestion {
        position: absolute; 
        z-index: 1; 
        top: 50%; 
        left: 50%; 
        transform: translate(-50%, -50%); 
        color: #FDF8EB; 
        background-color: rgba(0, 0, 0, 0.5);
    }
    .button-profile-route {
        position: absolute;
        z-index: 1;
        top: 10px;
        width: 50px;
        height: 50px;
        background-color: #B48753;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        transition: 0.3s ease;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .duration-route {
        position: absolute;
        z-index: 1;
        top: 70px;
        left: 10px;
        width: 170px;
        padding: 5px;
        background-color: #B48753;
        color: #FDF8EB;
        border-radius: 5px;
        display: flex;
        justify-content: center;
    }
    .selected {
        background-color: #984EAE;
    }
    .button-center-map {
        position: absolute;
        z-index: 1;
        top: 10px;
        right: 10px;
        width: 50px;
        height: 50px;
        background-color: #B48753;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        transition: 0.3s ease;
        display: flex;
        justify-content: center;
        align-items: center;
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
    .button-reserve {
        position: absolute;
        bottom: 10px;
        right: 0;
        left: 0;
        margin: 0 auto;
        width: 95%;
        height: 50px;
        background: #B48753;
        overflow: hidden;
        color: #FDF8EB;
        font-size: 1.5rem;
        border: none;
        border-radius: 5px;
        z-index: 1;
        cursor: pointer;
        transition: background-color 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }
    .button-reserve::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.3) 50%, rgba(255, 255, 255, 0));
        transition: left 0.5s ease;
        z-index: 1;
    }

    .button-reserve:hover::before {
        left: 100%;
    }
</style>