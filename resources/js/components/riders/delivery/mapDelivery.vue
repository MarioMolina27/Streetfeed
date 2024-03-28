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
        <div v-if="isScanning" class="scanner-container">
            <qrScanner :deliveryIds="deliveryIds" @closeFrame="closeFrame"></qrScanner>
        </div>
    </div>
</template>

<script>
import mapboxgl from 'mapbox-gl';
import 'mapbox-gl/dist/mapbox-gl.css';
import qrScanner from './qrScanner.vue';
export default{
    props: {
        deliveries: Object,
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
            isScanning: false,
            deliveryIds: [],
            isDelivered: false,
            delivery: [],
            collectMarkerButton: null
        }
    },
    computed: {
        isCollectButtonActive() {
            if (!this.areAllDeliveriesHomeless && this.isWithinSchedule) {
                return true;
            }
            return false;
        },
        areAllDeliveriesHomeless() {
            let allDeliveriesHomeless = true;
            let i = 0;
            while (i < this.delivery.length && allDeliveriesHomeless) {
                if (this.delivery[i].homeless.status !== 2) {
                    allDeliveriesHomeless = false;
                }
                i++;
            }
            return allDeliveriesHomeless;
        },
        isWithinSchedule() {
            if (this.delivery.length > 0 && this.delivery[0].provider.schedules.length > 0) {
                const currentDate = new Date();
                const [startHours, startMinutes, startSeconds] = this.closestSchedule.start_time.split(':');
                currentDate.setHours(parseInt(startHours));
                currentDate.setMinutes(parseInt(startMinutes));
                currentDate.setSeconds(parseInt(startSeconds));
                const startTime = currentDate.getTime();

                const [finishHours, finishMinutes, finishSeconds] = this.closestSchedule.finish_time.split(':');
                currentDate.setHours(parseInt(finishHours));
                currentDate.setMinutes(parseInt(finishMinutes));
                currentDate.setSeconds(parseInt(finishSeconds));
                const finishTime = currentDate.getTime();

                const currentTime = new Date().getTime();
                return currentTime >= startTime && currentTime <= finishTime;
            }
            return false;
        },
        closestSchedule() {
            if (this.delivery[0].provider.schedules.length === 0) return null;

            let currentTime = new Date().getTime();
            let closest = this.delivery[0].provider.schedules[0];
            let closestDiff = Math.abs(currentTime - new Date("1970-01-01T" + closest.start_time).getTime());

            for (let i = 1; i < this.delivery[0].provider.schedules.length; i++) {
            let scheduleTime = new Date("1970-01-01T" + this.delivery[0].provider.schedules[i].start_time).getTime();
            let diff = Math.abs(currentTime - scheduleTime);

            if (diff < closestDiff) {
                closest = this.delivery[0].provider.schedules[i];
                closestDiff = diff;
            }
            }
            return closest;
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
        addMarker(coordinates, color, info, type) {
            const marker = new mapboxgl.Marker({ color })
                .setLngLat(coordinates)
                .addTo(this.map);
            if (info !== null) {
                if (type === 'provider') {
                    const popupContent = `
                        <div class="mb-2" style="text-align: center;">
                            <strong class="fs-3" style="color: #B48753; margin-right: 10px;">${info.nickname}</strong>
                            <i class="fa-solid fa-store fs-4"></i>
                        </div>
                        ${this.isCollectButtonActive ? `<button id="popup-button-${info.id_user}" class="btn" style="background-color:#B48753; color: #FDF8EB; border: none;display: block; margin: 0 auto;">Recoger</button>` : ''}
                    `;
                    const popup = new mapboxgl.Popup({ closeButton: false, closeOnClick: false }).setHTML(popupContent);
                    marker.setPopup(popup);
                    popup.once('open', () => {
                        const popupButton = document.getElementById(`popup-button-${info.id_user}`);
                        if (popupButton) {
                            popupButton.addEventListener('click', e => { 
                                this.collectMenus(info.id_user) });
                                console.log('Click en el botón:', info);
                        } else {
                            console.error('Elemento con ID popup-button no encontrado.');
                        }
                    });
                    marker.togglePopup();
                } else {
                    const popupContent = `
                        <div class="mb-2" style="text-align: center;">
                            <strong class="fs-3" style="color: #984EAE; margin-right: 10px;">${info.numDeliveries}</strong>
                            <i class="fa-solid fa-user fs-4"></i><i class="fa-solid fa-utensils fs-4"></i>
                        </div>
                        <button id="popup-button-${info.id_marker}" class="btn" style="background-color:#984EAE; color: #FDF8EB; border: none;display: block; margin: 0 auto;">Entrega</button>
                    `;
                    
                    const popup = new mapboxgl.Popup({ closeButton: false, closeOnClick: false }).setHTML(popupContent);
                    marker.setPopup(popup);
                    popup.once('open', () => {
                        const popupButton = document.getElementById(`popup-button-${info.id_marker}`);
                        if (popupButton) {
                            popupButton.addEventListener('click', e => { 
                                this.deliverMenus(info) });
                                console.log('Click en el botón:', info);
                        } else {
                            console.error('Elemento con ID popup-button no encontrado.');
                        }
                    });
                    marker.togglePopup();
                }   
            }
            marker.getElement().addEventListener('mouseenter', () => {
                marker.getElement().style.cursor ="pointer";
            });

            marker.getElement().addEventListener('mouseleave', () => {
                marker.getElement().style.cursor ="default";
            });            
        },
        collectMenus(idProvider) {
            this.isScanning = true;
            this.collectMarkerButton = document.getElementById(`popup-button-${idProvider}`);
        },
        closeFrame(isChanging) {
            this.isScanning = false;
            if (isChanging) {
                this.$emit('isChanging', this.deliveryIds);
                this.collectMarkerButton.style.display = 'none';
            }
            this.collectMarkerButton = null;
        },
        deliverMenus(homelessMarker) {            
            const relatedDeliveries = Object.values(this.deliveries).flat().filter(delivery => {
                return delivery.homeless.id_marker === homelessMarker.id_marker;
            });

            relatedDeliveries.forEach(delivery => {
                if(delivery.homeless.status === 2) {
                    const idDelivery = delivery.homeless.idDelivery;
                    axios.post('api/delivery/do-deliver', {
                        deliveryId: idDelivery
                    })
                    .then(response => {
                        if (response.status == 200) {
                            this.isDelivered = true;
                            this.$emit('notifyDeliver', idDelivery);
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    });
                }
            });
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
            this.deliveryIds = [];
            for (const provider in this.deliveries) {
                if (this.deliveries.hasOwnProperty(provider)) {
                    this.delivery = this.deliveries[provider];
                    if (!processedProviders.hasOwnProperty(provider)) {
                        const providerInfo = this.deliveries[provider][0].provider;

                        this.addMarker([providerInfo.longitude, providerInfo.latitude], '#B48753', providerInfo, 'provider');

                        processedProviders[provider] = true;
                    }
                    const processedMarkersDelivery = {};
                    this.deliveries[provider].forEach(delivery => {
                    
                        const deliveryInfo = delivery.homeless;
                        const idMarker = deliveryInfo.id_marker;
                        if (deliveryInfo.status === 1) {
                                this.deliveryIds.push(deliveryInfo.idDelivery);
                            }
                        if (!(idMarker in processedMarkersDelivery)) {
                            const numDeliveries = this.deliveries[provider].filter(del => del.homeless.id_marker === idMarker).length;
                            deliveryInfo.numDeliveries = numDeliveries;
                            
                            this.addMarker([deliveryInfo.longitude, deliveryInfo.latitude], '#984EAE', deliveryInfo, 'homeless');
                            processedMarkersDelivery[idMarker] = true;
                        }
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
    },
    components: {
        qrScanner
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
    .scanner-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
    }
</style>