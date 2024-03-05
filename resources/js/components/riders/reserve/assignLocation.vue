<template>
  <div id="map"></div>
</template>

<script>
import mapboxgl from 'mapbox-gl';
import 'mapbox-gl/dist/mapbox-gl.css'; 

export default {
    props: {
        idmenu: String
    },
    data() {
        return {
            map: null,
            accessToken: "pk.eyJ1Ijoic3RyZWV0ZmVlZCIsImEiOiJjbHRkOWMzMXgwMDlyMmpybnA0MGt1N3RpIn0.jBsWG7vIB54CaqmpwbMapw",
            mapStyle: "mapbox://styles/mapbox/standard",
            defaultLocation: { lat: 41.388752, lng: 2.17271 },
            userId: 4,
            reserveData: [],
            userCurrentLocation: { latitude: null, longitude: null }
        };
    },
    mounted() {
        mapboxgl.accessToken = this.accessToken;
        this.map = new mapboxgl.Map({
            container: 'map',
            style: this.mapStyle,
            center: this.defaultLocation,
            zoom: 16
        });

        this.askForLocation();
        
        axios.get(`api/users/reserve-data/${this.userId}/${this.idmenu}`)
            .then(response => {
                this.reserveData = response.data;
                this.reserveData.markers.forEach(marker => {
                    const { latitude, longitude } = marker;
                    this.createMarker([longitude, latitude], '#984EAE');
                });

                const { latitude: userLat, longitude: userLng } = this.reserveData.user;
                this.createUserMarker([userLng, userLat], '#984EAE');

                const { latitude: providerLat, longitude: providerLng } = this.reserveData.provider;
                this.createMarker([providerLng, providerLat], '#B48753');

                const providerCoords = [providerLng, providerLat];
                this.createRoute(providerCoords, [this.userCurrentLocation.longitude, this.userCurrentLocation.latitude], 'walking');
            })
            .catch(error => {
                console.error('Error al obtener los datos de reserva:', error);
            });
    },
    beforeDestroy() {
            this.map.remove();
    },
    methods: {
        askForLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(
                    position => {
                        if (position && position.coords) {
                            this.userCurrentLocation.latitude = position.coords.latitude;
                            this.userCurrentLocation.longitude = position.coords.longitude;
                            const userCurrentCoordenates = [this.userCurrentLocation.longitude, this.userCurrentLocation.latitude];
                            this.updateCurrentLocation(userCurrentCoordenates);
                        }
                    },
                    error => {
                        console.error('Error al obtener la ubicación:', error.message);
                    }
                );
            } else {
                console.error('El navegador no soporta la geolocalización');
            }
        },
        createMarker(coordinates, color) {
            new mapboxgl.Marker({ color: color })
                .setLngLat(coordinates)
                .addTo(this.map);
        },
        createUserMarker(coordinates, color) {
            console.log(coordinates)
            const houseMarker = document.createElement('i');
            houseMarker.className = 'fa-solid fa-house';
            houseMarker.style.fontSize = '2.5rem';
            houseMarker.style.color = color;
            new mapboxgl.Marker({ element: houseMarker })
                .setLngLat(coordinates)
                .addTo(this.map);
        },
        updateCurrentLocation(coordinates) {
            console.log(coordinates)
            const userMarker = document.createElement('i');
            userMarker.className = 'fa-solid fa-location-arrow';
            userMarker.style.fontSize = '2.5rem';
            new mapboxgl.Marker({ element: userMarker  })
                .setLngLat(coordinates)
                .addTo(this.map);
        },
        createRoute(start, end, profile) {
            const url = `https://api.mapbox.com/directions/v5/mapbox/${profile}/${start[0]},${start[1]};${end[0]},${end[1]}?geometries=geojson&access_token=${this.accessToken}`;
      
            axios.get(url).then(response => {
                const route = response.data.routes[0].geometry;
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
                    paint: {
                    'line-color': '#000000',
                    'line-width': 5
                    }
                });
            })
            .catch(error => {
                console.error('Error al obtener la ruta:', error);
            });
        }
    },
}
</script>

<style scoped>
    #map {
        position: absolute;
        width: 100vw;
        height: 100%;
    }
</style>