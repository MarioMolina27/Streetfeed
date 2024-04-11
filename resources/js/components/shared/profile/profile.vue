<template>
    <dialogPassword :modalVisible="this.modalPassword" :user= "this.user" :translations="translations" @closeModal="closeModal"></dialogPassword>
    <div class="container-fluid ps-0 pe-0">
        <Navbar :menuItems = 'menuItems' :currentLanguage = 'lang'></Navbar>
        <template v-if="loading ||!loadingFinished">
            <loader :loading = 'loading' @loading-finished="handleLoadingFinished"></loader>
        </template>
        <div v-else>
            <div class="container mt-3">
                <stadistic :type_user="this.type_user" :deliveriesUser="this.deliveriesUser" :markersByUser="this.markersByUser" :numProviderDeliveries="numProviderDeliveries" :translations="translations"></stadistic>
                <top-profile-rider v-if="userIsRider" :user="this.user" :deliveriesUser="deliveriesUser" :translations="translations"></top-profile-rider>
                <top-profile-provider v-if="userIsProvider" :user="this.user" :deliveriesUser="numProviderDeliveries" :translations="translations"></top-profile-provider>
                
                <profile-card :user="this.user" :type_user="this.type_user" :schedules="this.shifts" :adress="this.address" :roadTypes="this.typeRoads" :translations="translations"></profile-card>

                <h3 class="mt-5 ms-3" style="cursor: pointer;" @click="this.modalPassword=true;">{{translations.changePassword}}</h3>

                <h3 class="mt-4 ms-3 danger-btn" style="cursor: pointer;">{{translations.logout}}</h3>
                <h3 class="mt-4 ms-3 mb-4 danger-btn fw-bold" style="cursor: pointer;">{{translations.deleteAccount}}</h3>
            </div>
        </div>
    </div>
    </template>
    
    <script>
    import Navbar from '../../shared/Navbar.vue';
    import Card from 'primevue/card';
    import topProfileRider from './topProfileRider.vue';
    import topProfileProvider from './topProfileProvider.vue';
    import profileCard from './profileCard.vue';
    import { getDeliveriesByUser, getNumProviderDeliveries } from "../../../services/delivery.js"
    import { markersByUser } from "../../../services/markers.js"
    import { getAdressByUser, getTypeRoad } from '../../../services/adress.js';
    import { getScheduleByUser } from '../../../services/schedules.js';
    import loader from '../../shared/loader.vue';
    import dialogPassword from './dialogPassword.vue';
    import stadistic from './stadisticsTop.vue';
    import {menuTabs} from '../../../utilities/menuTabs.js'
    
    export default {
        props: {
            user: Object,
            lang: String,
            type_user: Array
        },
        data(){
          return {
            loading: true,
            loadingFinished: false,
            modalPassword: false,
            menuItems: [],
            deliveriesUser: 0,
            numProviderDeliveries: 0,
            markersByUser: 0,
            shifts: [],
            address: [],
            typeRoads: [],
            translations: {}
          }
        },

        computed: {
            userIsRider() {
                return this.type_user.some(userType => userType.id_type_user === 1); // Suponiendo que el id para Rider sea 1
            },
            userIsProvider() {
                return this.type_user.some(userType => userType.id_type_user === 2); // Suponiendo que el id para Provider sea 2
            }
        },
        components: {
            Navbar,
            Card,
            topProfileRider,
            topProfileProvider,
            profileCard,
            loader,
            dialogPassword,
            stadistic
        },
        created() {
            import(`../../../../lang/shared/${this.lang}.json`)
                .then(module => {
                    this.translations = module.default;
                    console.log(this.translations);
                })
                .catch(error => {
                    console.error(`Error al importar el archivo de idioma: ${error}`);
                });
                
        },
        mounted() {
            this.menuItems = menuTabs(this.type_user);
            Promise.all([
                getDeliveriesByUser(this.user.id_user),
                markersByUser(this.user.id_user),
                getScheduleByUser(this.user.id_user),
                getAdressByUser(this.user.id_user),
                getTypeRoad(),
                getNumProviderDeliveries(this.user.id_user)
            ]).then(([deliveriesResponse, markersResponse, scheduleResponse, addressResponse, typeRoadResponse,numProviderDeliveriesResponse]) => {
                this.deliveriesUser = deliveriesResponse;
                this.markersByUser = markersResponse;
                this.shifts = scheduleResponse;
                this.address = addressResponse;
                this.typeRoads = typeRoadResponse;
                this.numProviderDeliveries = numProviderDeliveriesResponse;
                this.loading = false;
            }).catch(error => {
                console.error("Hubo un error al obtener los datos:", error);
            });
        },
        methods: {
            handleLoadingFinished(){
                this.loadingFinished = true;
            },
            closeModal(){
                this.modalPassword = false;
            }
        }
    }
    </script>
    
    <style scoped>
        .p-card{
            background-color: #b48753;
            margin: 5px;
        }

       .p-card-body{
            padding: 15px;
        }

        .img-profile-stats{
            width: 4vh;
            height: 4vh;
        }

        .text-profile-stats{
            font-size: 1.5rem;
            color: #FDF8EB;
        }

        .danger-btn{
            color: #B52A2A;
            font-weight: 600;
        }
    </style>