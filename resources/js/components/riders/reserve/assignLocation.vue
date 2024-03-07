<template>
    <div style="position: relative;">
        <div id="map" style="width: 100%; height: calc(100vh - 58px);"></div>
        <div class="menus-container">
            <span>MENÚS A REPARTIR: <strong style="color: #984EAE;">{{ launchpacks }}</strong></span><br>
            <span>MENÚS RESTANTES: <strong style="color: #984EAE;">{{ launchpacks }}</strong></span>
        </div>
        <div class="homeless-assigning">
            <div class="homeless-information">
                <span>Ubicación</span>
                <span>Barcelona</span>
                <span>Barcelona</span>
                <span>Plz Urquinaona 12</span>
                <span>2</span>
            </div>
            <div class="homeless-information">
                <span>Ubicación</span>
                <span>Barcelona</span>
                <span>Barcelona</span>
                <span>Plz Urquinaona 12</span>
                <span>2</span>
            </div>
        </div>
        <button class="delivery-button">Hacer la entrega!</button>
    </div>
</template>

<script>
import mapboxgl from 'mapbox-gl';
import 'mapbox-gl/dist/mapbox-gl.css'; 

export default {
    props: {
        menusjson: String 
    },
    data() {
        return {
            map: null,
            accessToken: "pk.eyJ1Ijoic3RyZWV0ZmVlZCIsImEiOiJjbHRkOWMzMXgwMDlyMmpybnA0MGt1N3RpIn0.jBsWG7vIB54CaqmpwbMapw",
            mapStyle: "mapbox://styles/mapbox/standard",
            defaultLocation: { lat: 41.388752, lng: 2.17271 },
            userId: 4,
            reserveData: [],
            userCurrentLocation: { latitude: null, longitude: null },
            menus: JSON.parse(this.menusjson),
            launchpacks: 0,
            homelessMarkers: []
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
        this.countLaunchpacks();
        this.askForLocation();
        axios.get(`api/users/reserve-data/${this.userId}/${this.menus[0].id}`)
            .then(response => {
                this.reserveData = response.data;
                this.reserveData.markers.forEach(marker => {
                    const { latitude, longitude } = marker;
                    this.createMarker([longitude, latitude], '#984EAE', marker);
                });

                const { latitude: userLat, longitude: userLng } = this.reserveData.user;
                this.createUserMarker([userLng, userLat], '#984EAE', null);

                const { latitude: providerLat, longitude: providerLng } = this.reserveData.provider;
                this.createMarker([providerLng, providerLat], '#B48753', null);

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
        countLaunchpacks() {
            this.menus.forEach(menu => {
                this.launchpacks += menu.launchpacks;
            });
        },
        askForLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(
                    position => {
                        if (position && position.coords) {
                            this.userCurrentLocation.latitude = position.coords.latitude;
                            this.userCurrentLocation.longitude = position.coords.longitude;
                            const userCurrentCoordenates = [this.userCurrentLocation.longitude, this.userCurrentLocation.latitude];
                            this.map.setCenter(userCurrentCoordenates);
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
        createMarker(coordinates, color, data) {
            const marker = new mapboxgl.Marker({ color: color })
                .setLngLat(coordinates)
                .addTo(this.map);
                marker.getElement().classList.add('marker');
            if (data !== null) {
                this.homelessMarkers.push({ marker, data });
            }
            marker.getElement().addEventListener('click', () => {
                console.log(data);
            });
        },
        createUserMarker(coordinates, color) {
            const houseMarker = document.createElement('i');
            houseMarker.className = 'fa-solid fa-house';
            houseMarker.style.fontSize = '2.5rem';
            houseMarker.style.color = color;
            new mapboxgl.Marker({ element: houseMarker })
                .setLngLat(coordinates)
                .addTo(this.map);
        },
        updateCurrentLocation(coordinates) {
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
        position: relative;
        width: 100vw;
        height: 100%;
    }
    .mapbox-logo{
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
    .marker {
        cursor: pointer;
        transition: transform 0.2s ease-in-out;
    }

    .marker:hover {
        transform: scale(1.1);
    }
    .homeless-assigning {
        position: absolute;
        bottom: 70px; 
        right: 0;
        left: 0;
        margin: 0 auto;
        width: 90%;
        
    }
    .homeless-information {
        margin: 10px 0;
        background-color: #FDF8EB; 
        padding: 20px;
        border-radius: 5px;
        border: 1px solid #B48753;
        font-size: 1.5rem;
        box-shadow: 0px 0px 10px #b487537a;
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
</style>