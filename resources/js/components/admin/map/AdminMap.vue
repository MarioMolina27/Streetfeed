<template>
    <div class="d-flex justify-content-center align-items-center h-100">
        <div id="map"></div>
        <div class="map-legend">
            <div class="d-flex justify-content-center align-items-center">
                <div class="d-flex justify-content-center align-items-center" style="margin: 10px;">
                    <i class="fa-solid fa-shop fs-4 me-2" style="color: #b48753;"></i>
                    <strong class="fs-4" style="color: #b48753;">Provider</strong>
                </div>
                <div class="d-flex justify-content-center align-items-center" style="margin: 10px;">
                    <i class="fa-solid fa-user fs-4 me-2" style="color: #984EAE;"></i>
                    <strong class="fs-4" style="color: #984EAE;">Homeless</strong>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import mapboxgl from 'mapbox-gl';
import 'mapbox-gl/dist/mapbox-gl.css';
import { getAllMarkers } from '../../../services/markers.js';

export default {
    name: "AdminMap",

    data() {
        return {
            map: null,
            accessToken: "pk.eyJ1Ijoic3RyZWV0ZmVlZCIsImEiOiJjbHRkOWMzMXgwMDlyMmpybnA0MGt1N3RpIn0.jBsWG7vIB54CaqmpwbMapw",
            mapStyle: "mapbox://styles/mapbox/light-v11",
            defaultLocation: { lat: 41.388752, lng: 2.17271 },
            userId: 4,
        }
    },

    beforeDestroy() {
        this.map.remove();
    },

    mounted() {
        mapboxgl.accessToken = this.accessToken;
        this.map = new mapboxgl.Map({
            container: 'map',
            style: this.mapStyle,
            center: this.defaultLocation,
            zoom: 16
        });

        getAllMarkers().then(response => {
            response.data.forEach(marker => {
                let color;
                if(marker.id_user) {
                    color = '#b48753';
                }
                else {
                    color = '#984EAE';
                }
                this.createMarker([marker.longitude, marker.latitude], color, marker);
            });
        });
    },
    
    methods: {
        createMarker(coordinates, color, data) {
            const marker = new mapboxgl.Marker({ color: color })
                .setLngLat(coordinates)
                .addTo(this.map);
            if (data !== null) {
                let popupContent;
                if(data.id_user) {
                    popupContent= ` 
                    <div class="mb-2" style="text-align: center;">
                        <i class="fa-solid fa-shop fs-4 me-2"></i>
                        <strong class="fs-4" style="color: #b48753; margin-right: 10px;">${data.nickname}</strong>
                        <p class="mb-0">${data.type_users[0].pivot.type_of_provider.toUpperCase()}</p>
                    </div>`
                }
                else{
                    popupContent = `
                    <div class="mb-2" style="text-align: center;">
                        <strong class="fs-3" style="color: #984EAE; margin-right: 10px;">${data.num_people}</strong>
                        <i class="fa-solid fa-user fs-4"></i><i class="fa-solid fa-utensils fs-4"></i>
                    </div>
                `;
                }
                 
                marker.setPopup(new mapboxgl.Popup({ closeButton: false }).setHTML(popupContent));
            }
            
            marker.getElement().addEventListener('mouseenter', () => {
                marker.getElement().style.cursor ="pointer";
                marker.togglePopup();
            });

            marker.getElement().addEventListener('mouseleave', () => {
                marker.getElement().style.cursor ="default";
            });

            
        }
    }
}
</script>

<style scoped>
    #map {
        position: relative;
        width: 85vw;
        height: 90vh;
        border-radius: 10px;
        border: 2px solid #081733;
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
    
    .map-legend{
        position: absolute; 
        z-index: 3;
        right: 15px;
        bottom: 15px;
        background-color: #FDF8EB;
        border: 2px solid #081733;
        border-radius: 5px;
        padding: 10px;
        box-shadow: 0px 0px 2px #081733;
        margin-left: 5px;
    }

    @media screen and (max-width: 992px){
        .map-legend{
            bottom: 0;
            right: 1px;
            left: 1px;
            margin: 0;
            padding: 5px;
        }
    }
</style>
