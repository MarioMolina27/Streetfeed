<template>
    <div class="map-container">
        <div id="map" style="position: relative;"></div>
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

                        this.addMarker([providerInfo.longitude, providerInfo.latitude], 'blue', false);

                        processedProviders[provider] = true;
                    }

                    this.deliveries[provider].forEach(delivery => {
                        const deliveryLocation = delivery.homeless;

                        this.addMarker([deliveryLocation.longitude, deliveryLocation.latitude], 'green', false);
                    });
                }
            }
        },
        askForLocation() {
            return new Promise((resolve, reject) => {
                if (navigator.geolocation) {
                    navigator.geolocation.watchPosition(
                        position => {
                            if (position && position.coords) {
                                this.userCurrentLocation.latitude = position.coords.latitude;
                                this.userCurrentLocation.longitude = position.coords.longitude;
                                this.updateUserMarker([this.userCurrentLocation.longitude, this.userCurrentLocation.latitude]);
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
        }
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
</style>