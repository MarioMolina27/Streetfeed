<template>
    <div class="d-flex justify-content-center align-items-center h-100">
        <div id="map"></div>
    </div>
</template>

<script>
import mapboxgl from 'mapbox-gl';
import 'mapbox-gl/dist/mapbox-gl.css';

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
    },
    
    methods: {
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
                    <button id="popup-button-${data.id_marker}" class="btn" style="background-color:#984EAE; color: #FDF8EB; border: none;display: block; margin: 0 auto;">Asignar</button>
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
