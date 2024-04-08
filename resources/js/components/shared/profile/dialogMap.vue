<template>
    <div>
        <Dialog v-model:visible="visible" modal header="Dirección" style="width: 90%;">
            <div class="d-flex flex-column">
                <div style="position: relative;">
                    <div class="row">
                        <div class="col-6">
                            <IconField iconPosition="left">
                                <InputIcon class="pi pi-search"> </InputIcon>
                                <InputText v-model="value1" placeholder="Search" />
                            </IconField>
                        </div>
                        <div class="col-3">
                            <InputText v-model="floor" placeholder="Floor" />
                        </div>
                        <div class="col-3">
                            <InputText v-model="door" placeholder="Door" />
                        </div>
                    </div>
                    <div v-if="suggestions.length > 0 && showSuggestions" class="mapbox-autofilll-results mt-2">
                        <ul>
                            <li v-for="suggestion in suggestions" :key="suggestion.mapbox_id" @click="selectSuggestion(suggestion)">
                                {{ suggestion.full_address }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="map-container-dialog mt-2">
                    <div id="map" class="map" style="width: 100%;"></div>
                </div>
            </div>
            <Button label="Guardar" class="p-button mt-2" @click="closeModal()" />
        </Dialog>
    </div>
</template>

<script>
import Dialog from 'primevue/dialog';
import IconField from 'primevue/iconfield';
import InputText from 'primevue/inputtext';
import mapboxgl from 'mapbox-gl';
import Button from 'primevue/button';
import InputIcon from 'primevue/inputicon';


export default {
    components: {
        Dialog,
        IconField,
        InputText,
        Button,
        InputIcon
    },
    props: ['modalVisible','selectedDirection'],

    data() {
        return {
            visible: false,
            adress: '',
            adressDebounced: '',
            adressDebouncedTime: 500,
            timeoutAdress: null,
            floor: '',
            door: '',
            map: null,
            accessToken: "pk.eyJ1Ijoic3RyZWV0ZmVlZCIsImEiOiJjbHRkOWMzMXgwMDlyMmpybnA0MGt1N3RpIn0.jBsWG7vIB54CaqmpwbMapw",
            mapStyle: "mapbox://styles/mapbox/light-v11",
            suggestions: [],
            selectedSuggestion: {},
            showSuggestions: false,
            marker: new mapboxgl.Marker({ color: "#b48753" }),
        };
    },

    methods: {
            selectSuggestion(suggestion) {
                this.selectedSuggestion = suggestion;
                this.adress = suggestion.full_address;
                this.suggestions = [];

                const url = `https://api.mapbox.com/search/searchbox/v1/retrieve/${suggestion.mapbox_id}?session_token=084b1dc6-78bc-48e1-88e9-fd71f2a0a70d&access_token=${this.accessToken}`;
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        const coordinates = data.features[0].geometry.coordinates
                        this.map.flyTo({ center: coordinates, zoom: 16 });

                        this.marker
                            .setLngLat(coordinates)
                            .addTo(this.map);   
                            
                        this.showSuggestions = false;
                    });
            },
            closeModal() {
                this.visible = false;
                if(this.selectedSuggestion != {}) {
                    console.log(this.selectedSuggestion);
                    let address = {
                        country: this.selectedSuggestion.country,
                        city: this.selectedSuggestion.city,
                        cp: this.selectedSuggestion.cp,
                        name: this.selectedSuggestion.name,
                        number: this.selectedSuggestion.number,
                        floor: this.floor,
                        door: this.door,
                    }
                    this.$emit('addDirection', address);
                }
            },
        },

    watch: {
        modalVisible(newVal) {
            this.visible = newVal;
        },

        visible(newVal) {
            if(!newVal) {
                this.$emit('closeModal');
            }

            if(newVal) {
                setTimeout(() => {
                    mapboxgl.accessToken = this.accessToken;
                    this.map = new mapboxgl.Map({
                        container: 'map',
                        style: this.mapStyle,
                        center: [2.17271, 41.388752],
                        zoom: 16
                    });
                }, 100);
            }
        },

        adress(newVal) {
            this.showSuggestions = true;
            if(this.timeoutAdress){
                clearTimeout(this.timeoutAdress);
            }
            this.timeoutAdress = setTimeout(() => {
                this.adressDebounced = newVal;
            }, this.adressDebouncedTime);
        },

        adressDebounced(newVal) {
            this.suggestions = [];
            const url2 = `https://api.mapbox.com/search/searchbox/v1/suggest?q=${newVal}&language=es&types=address&session_token=0436db03-14e0-4cd1-88ea-f266bee070a9&access_token=${this.accessToken}`
            const url = `https://api.mapbox.com/search/searchbox/v1/suggest?q=${newVal}&language=es&types=address&ession_token=0406ae77-85a7-4918-8e9f-bf48400d103b&access_token=${this.accessToken}`;
            fetch(url2)
                .then(response => response.json())
                .then(data => {
                    if(data.suggestions && data.suggestions.length > 0) {
                        data.suggestions.forEach(s => {                            
                            this.suggestions.push({
                                name: s.context?.street ? s.context.street.name : '',
                                full_address: s.full_address,
                                country: s.context?.country ? s.context.country.name : '',
                                city: s.context?.place ? s.context.place.name : '',
                                cp: s.context?.postcode?.name ? s.context.postcode.name : '',
                                number: s.context?.address?.address_number ? s.context.address?.address_number : '',
                                mapbox_id: s.mapbox_id,
                            });
                        });                    
                    }
                });
        },
    },
};
</script>


<style scoped>
.map-container-dialog {
    height: 400px;
    width: 100%;
    position: relative;
}

.p-button {
    width: 100%;
    border: none;
    background-color: #984eae;
}

.mapbox-autofilll-results{
    position: absolute;
    z-index: 3;
    background-color: white;
    width: 100%;
    border-radius: 5px;
    box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.2);
}

li {
    padding: 10px;
    cursor: pointer;
    list-style: none;
    margin: 10px;
    display: flex;
    justify-content: start;
    align-items: center;
}

li:hover {
    background-color: #f2f2f2;
}

.p-inputtext {
    width: 100%;
}


</style>
