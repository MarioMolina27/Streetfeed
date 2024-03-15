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
        }
    },
    mounted(){
        console.log('Deliveries:', this.deliveries);
        mapboxgl.accessToken = this.accessToken;
        this.map = new mapboxgl.Map({
            container: 'map',
            style: this.mapStyle,
            center: this.defaultLocation,
            zoom: 16
        });
        this.deliveries.forEach(delivery => {
            this.addMarker([delivery.marker.longitude, delivery.marker.latitude], 'blue', false);
            this.addMarker([delivery.user.longitude, delivery.user.latitude], 'green', false);
        });
        this.askForLocation();
    },
    methods: {
        addMarker(coordinates, color, isUser) {
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
        askForLocation() {
            return new Promise((resolve, reject) => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        position => {
                            const handleOrientation = event => {
                                // Acceder a los ángulos de inclinación, balanceo y orientación
                                const alpha = event.alpha; // Orientación alrededor del eje z
                                const beta = event.beta;   // Inclinación hacia adelante y hacia atrás
                                const gamma = event.gamma; // Inclinación hacia la izquierda y hacia la derecha

                                // Hacer algo con los ángulos obtenidos
                                console.log('alpha (orientación): ' + alpha);
                                console.log('beta (inclinación hacia adelante/atrás): ' + beta);
                                console.log('gamma (inclinación hacia izquierda/derecha): ' + gamma);
                            };
                            if (window.DeviceOrientationEvent) {
                                window.addEventListener('deviceorientation', handleOrientation, false);
                            }
                            console.log(position)
                            if (position && position.coords) {
                                this.userCurrentLocation.latitude = position.coords.latitude;
                                this.userCurrentLocation.longitude = position.coords.longitude;
                                this.addMarker([this.userCurrentLocation.longitude, this.userCurrentLocation.latitude], 'red', true);
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

<style scoped>
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
</style>