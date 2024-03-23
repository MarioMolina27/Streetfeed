<template>
    <div class="map-container">
        <div id="map" style="position: relative;"></div>
        <div :class="{ 'selected': selectedProfile === 'walking' }" class="button-profile-route" style="left: calc(20px + 5%);" @click="createRoute('walking')">
            <i class="fa-solid fa-person-walking" style="color: #FDF8EB;"></i>
        </div>
        <div :class="{ 'selected': selectedProfile === 'driving' }" class="button-profile-route" style="left: calc(80px + 5%);" @click="createRoute('driving')">
                <i class="fa-solid fa-car" style="color: #FDF8EB;"></i>
        </div>
        <div :class="{ 'selected': selectedProfile === 'cycling' }" class="button-profile-route" style="left: calc(140px + 5%);;" @click="createRoute('cycling')">
            <i class="fa-solid fa-bicycle" style="color: #FDF8EB;"></i>
        </div>
        <div class="duration-route">
            {{ routeDuration }}
        </div>
        <div class="button-center-map" @click="centerMap">
            <i class="fa-solid fa-location-crosshairs" style="color: #FDF8EB;"></i>
        </div>
    </div>
</template>

<script>
import mapboxgl from 'mapbox-gl';
import 'mapbox-gl/dist/mapbox-gl.css';
export default{
    props: {
        deliveries: Object
    },
    data(){
        return {
            map: null,
            accessToken: "pk.eyJ1Ijoic3RyZWV0ZmVlZCIsImEiOiJjbHRkOWMzMXgwMDlyMmpybnA0MGt1N3RpIn0.jBsWG7vIB54CaqmpwbMapw",
            mapStyle: "mapbox://styles/mapbox/light-v11",
            defaultLocation: { lat: 41.388752, lng: 2.17271 },
            userCurrentLocation: { latitude: null, longitude: null },
            userMarker: null,
            watchId: null,
            selectedProfile: 'walking',
            routeDuration: null,
            coordinates: [],
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
        this.creatingMarkers();
        this.askForLocation();
    },
    beforeUnmount() {
        this.stopWatchingLocation();
    },
    methods: {
        addMarker(coordinates, color) {
            new mapboxgl.Marker({ color })
                .setLngLat(coordinates)
                .addTo(this.map);
        },
        addUserMarker(coordinates) {
            const el = document.createElement('div');
            el.className = 'pulse';
            this.userMarker = new mapboxgl.Marker({element : el})
                .setLngLat(coordinates)
                .addTo(this.map);
            el.style.animation = 'pulseAnimation 2s infinite';
        },

        updateUserMarker(coordinates) {
            if (!this.userMarker) {
                this.addUserMarker(coordinates);                
            } else {
                this.userMarker.setLngLat(coordinates);
            }
        },
        creatingMarkers() {
            const processedProviders = {};

            for (const provider in this.deliveries) {
                if (this.deliveries.hasOwnProperty(provider)) {
                    if (!processedProviders.hasOwnProperty(provider)) {
                        const providerInfo = this.deliveries[provider][0].provider;

                        this.addMarker([providerInfo.longitude, providerInfo.latitude], '#B48753', false);

                        processedProviders[provider] = true;
                    }

                    this.deliveries[provider].forEach(delivery => {
                        const deliveryLocation = delivery.homeless;

                        this.addMarker([deliveryLocation.longitude, deliveryLocation.latitude], '#984EAE', false);
                    });
                }
            }
        },
        askForLocation() {
            return new Promise((resolve, reject) => {
                if (navigator.geolocation) {
                    this.watchId = navigator.geolocation.watchPosition(
                        position => {
                            if (position && position.coords) {
                                this.userCurrentLocation.latitude = position.coords.latitude;
                                this.userCurrentLocation.longitude = position.coords.longitude;
                                this.updateUserMarker([this.userCurrentLocation.longitude, this.userCurrentLocation.latitude]);
                                this.createRoute(this.selectedProfile);
                                this.centerMap();
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
        stopWatchingLocation() {
            if (this.watchId) {
                navigator.geolocation.clearWatch(this.watchId);
                this.watchId = null;
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
    }
}
</script>

<style>
    .map-container {
        position: absolute;
        top: 10vh;
        left: 0;
        width: 100%;
        height: calc(100vh - 10vh);
    }
    #map {
        width: 100%;
        height: 100%;
    }
    .pulse {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: #4381ee;
        opacity: 0.5;
    }
    @keyframes pulseAnimation {
        0% { opacity: 0.5; border: 2px solid rgba(142, 202, 230, 0.3); }
        10% { opacity: 0.6; border: 2px solid rgba(142, 202, 230, 0.3); }
        20% { opacity: 0.7; border: 2px solid rgba(142, 202, 230, 0.3); }
        30% { opacity: 0.8; border: 2px solid rgba(142, 202, 230, 0.3); }
        40% { opacity: 0.9; border: 2px solid rgba(142, 202, 230, 0.3); }
        50% { opacity: 1; border: 4px solid rgba(142, 202, 230, 0.7); }
        60% { opacity: 0.9; border: 4px solid rgba(142, 202, 230, 0.7); }
        70% { opacity: 0.8; border: 4px solid rgba(142, 202, 230, 0.7); }
        80% { opacity: 0.7; border: 4px solid rgba(142, 202, 230, 0.7); }
        90% { opacity: 0.6; border: 4px solid rgba(142, 202, 230, 0.7); }
        100% { opacity: 0.5; border: 2px solid rgba(142, 202, 230, 0.3); }
    }
    .button-profile-route {
        position: absolute;
        z-index: 1;
        top: 80px;
        width: 50px;
        height: 50px;
        background-color: #B48753;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: 0.3s ease;
    }
    .button-profile-route:not(.selected):hover {
        background-color: #b17a3b;
        transform: scale(1.01);
    }
    .duration-route {
        position: absolute;
        z-index: 1;
        top: 140px;
        left: calc(20px + 5%);
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
        top: 80px;
        right: calc(20px + 5%);
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
        transition: ease 0.3s;
    }
    .button-center-map:hover {
        background-color: #b17a3b;
        transform: scale(1.01);
    }
</style>