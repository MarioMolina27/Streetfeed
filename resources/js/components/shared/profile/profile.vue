<template>
    <dialogPassword :modalVisible="this.modalPassword" :user= "this.user" @closeModal="closeModal"></dialogPassword>
    <div class="container-fluid ps-0 pe-0">
        <Navbar :menuItems = 'menuItems'></Navbar>
        <template v-if="loading ||!loadingFinished">
            <loader :loading = 'loading' @loading-finished="handleLoadingFinished"></loader>
        </template>
        <div v-else>
            <div class="container mt-3">
                <div class="row d-flex justify-content-around">
                    <div class="col-3 p-0">
                        <Card>                        
                            <template #content>
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <img src="img/bag.svg" alt="Card" class="img-profile-stats"/>
                                    <p class="mb-0 mt-1 text-profile-stats">{{this.deliveriesUser}}</p>
                                </div>
                            </template>
                        </Card>
                    </div>
                    <div class="col-3 p-0">
                        <Card>
                            <template #content>
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <img src="img/cloud.png" alt="Card" class="img-profile-stats"/>
                                    <p class="mb-0 mt-1 text-profile-stats">{{this.kgUser}}kg</p>
                                </div>
                            </template>
                        </Card>
                    </div>
                    <div class="col-3 p-0">
                        <Card>
                            <template #content>
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <img src="img/marker.svg" alt="Card" class="img-profile-stats" />
                                    <p class="mb-0 mt-1 text-profile-stats">{{this.markersByUser}}</p>
                                </div>
                            </template>
                        </Card>
                    </div>
                </div>
                <top-profile-rider v-if="userIsRider" :user="this.user" :deliveriesUser="deliveriesUser"></top-profile-rider>
                <top-profile-provider v-if="userIsProvider" :user="this.user" :deliveriesUser="numProviderDeliveries"></top-profile-provider>
                
                <profile-card :user="this.user" :type_user="this.type_user" :schedules="this.shifts" :adress="this.address" :roadTypes="this.typeRoads"></profile-card>

                <h3 class="mt-5 ms-3" style="cursor: pointer;" @click="this.modalPassword=true;">Cambiar Contraseña</h3>

                <h3 class="mt-4 ms-3 danger-btn" style="cursor: pointer;">Cerrar Sessión</h3>
                <h3 class="mt-4 ms-3 mb-4 danger-btn fw-bold" style="cursor: pointer;">Eliminar Cuenta</h3>
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
    import { getDeliveriesByUser, getDeliveriesByKgUser, getNumProviderDeliveries } from "../../../services/delivery.js"
    import { markersByUser } from "../../../services/markers.js"
    import { getAdressByUser, getTypeRoad } from '../../../services/adress.js';
    import { getScheduleByUser } from '../../../services/schedules.js';
    import loader from '../../shared/loader.vue';
    import dialogPassword from './dialogPassword.vue';


    export default {

        data(){
          return {
            loading: true,
            loadingFinished: false,
            modalPassword: false,
            type_user: [
                {id: 1, name: 'Rider'},
                {id: 2, name: 'Provider'}],
            menuItems: [
                    {name: 'Tus Repartos', href: './delivery'},
                    {name: 'Explorar', href: './explore'},
                    {name: 'Favoritos', href: './favorite'},
                    {name: 'Perfil', href: './profile'}
            ],
            deliveriesUser: 0,
            numProviderDeliveries: 0,
            markersByUser: 0,
            shifts: [],
            address: [],
            typeRoads: [],
            kgUser: 0,
            user: {
                id_user: 9,
                name: 'Pol Crespo',
                username: '@pcrespo',
                email: 'pcrespo@politecnics.barcelona',
            }
          }
        },

        computed: {
            userIsRider() {
                return this.type_user.some(userType => userType.id === 1); // Suponiendo que el id para Rider sea 1
            },
            userIsProvider() {
                return this.type_user.some(userType => userType.id === 2); // Suponiendo que el id para Provider sea 2
            }
        },
        components: {
            Navbar,
            Card,
            topProfileRider,
            topProfileProvider,
            profileCard,
            loader,
            dialogPassword
        },
        mounted() {
            Promise.all([
                getDeliveriesByUser(this.user.id_user),
                markersByUser(this.user.id_user),
                getDeliveriesByKgUser(this.user.id_user),
                getScheduleByUser(this.user.id_user),
                getAdressByUser(this.user.id_user),
                getTypeRoad(),
                getNumProviderDeliveries(this.user.id_user)
            ]).then(([deliveriesResponse, markersResponse, kgResponse, scheduleResponse, addressResponse, typeRoadResponse,numProviderDeliveriesResponse]) => {
                this.deliveriesUser = deliveriesResponse;
                this.markersByUser = markersResponse;
                this.kgUser = kgResponse.kg;
                this.shifts = scheduleResponse;
                this.address = addressResponse;
                this.typeRoads = typeRoadResponse;
                this.numProviderDeliveries = numProviderDeliveriesResponse;
                this.loading = false;
                console.log("Datos obtenidos correctamente");
            }).catch(error => {
                console.error("Hubo un error al obtener los datos:", error);
            });
        },
        computed: {
            userIsRider() {
                return this.type_user.some(userType => userType.id === 1); // Suponiendo que el id para Rider sea 1
            },
            userIsProvider() {
                // Verifica si el tipo de usuario es Provider
                return this.type_user.some(userType => userType.id === 2); // Suponiendo que el id para Provider sea 2
            }
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