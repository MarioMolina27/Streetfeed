<template>
    <div class="map-container">
        <div id="map" style="position: relative;"></div>

    </div>
</template>

<script>
import mapboxgl from 'mapbox-gl';
import 'mapbox-gl/dist/mapbox-gl.css';
export default{
    data(){
        return {
            map: null,
            accessToken: "pk.eyJ1Ijoic3RyZWV0ZmVlZCIsImEiOiJjbHRkOWMzMXgwMDlyMmpybnA0MGt1N3RpIn0.jBsWG7vIB54CaqmpwbMapw",
            mapStyle: "mapbox://styles/mapbox/light-v11",
            defaultLocation: { lat: 41.388752, lng: 2.17271 },
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