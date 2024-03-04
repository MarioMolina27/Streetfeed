<template>
  <div id="map"></div>
</template>

<script>
import mapboxgl from 'mapbox-gl';

export default {
    props: {
        data: String
    },
    data() {
        return {
            map: null,
            accessToken: 'pk.eyJ1Ijoic3RyZWV0ZmVlZCIsImEiOiJjbHRkOWMzMXgwMDlyMmpybnA0MGt1N3RpIn0.jBsWG7vIB54CaqmpwbMapw',

            localizacion: { lat: 41.388752, lng: 2.17271 }, // Coordenadas de Urquinaona
            menuId: null,
            userId: 4,
            reserveData: []
        };
    },
    mounted() {
        const decodedData = atob(this.data);
        this.menuId = decodedData;
        axios.get(`api/users/reserve-data/${this.userId}/${this.menuId}`)
            .then(response => {
                this.reserveData = response.data;
                console.log(this.reserveData);
            })
            .catch(error => {
                console.error('Error al obtener los datos de reserva:', error);
            });

        mapboxgl.accessToken = this.accessToken;
        this.map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/standard',
        center: this.localizacion,
        zoom: 16
        });
        this.map.on('load', () => {
        this.createMarker(this.localizacion);
        });
    },
    beforeDestroy() {
            this.map.remove();
    },
    methods: {
        createMarker(coordinates) {
            this.marker = new mapboxgl.Marker()
                .setLngLat(coordinates)
                .addTo(this.map);
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