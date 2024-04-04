<template>
    <div class="container-fluid ps-0 pe-0">
        <Navbar :menuItems = 'menuItems'></Navbar>
        <div>
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
                <top-profile></top-profile>
                <profile-card></profile-card>

                <h3 class="mt-5 ms-3 danger-btn">Cerrar Sessión</h3>
                <h3 class="mt-4 ms-3 mb-4 danger-btn fw-bold">Eliminar Cuenta</h3>
            </div>
        </div>
    </div>
    </template>
    
    <script>
    import Navbar from '../../shared/Navbar.vue';
    import Card from 'primevue/card';
    import topProfile from './topProfile.vue';
    import profileCard from './profileCard.vue';
    import { getDeliveriesByUser, getDeliveriesByKgUser } from "../../../services/delivery.js"
    import { markersByUser } from "../../../services/markers.js"


    export default{
        data(){
          return {
            menuItems: [
                    {name: 'Tus Repartos', href: './delivery'},
                    {name: 'Explorar', href: './explore'},
                    {name: 'Favoritos', href: './favorite'},
                    {name: 'Perfil', href: './profile'}
            ],
            deliveriesUser: 0,
            markersByUser: 0,
            kgUser: 0,
            user: {
                id_user: 4
            }
          }
        },
        components: {
            Navbar,
            Card,
            topProfile,
            profileCard,
        },
        mounted() {
            getDeliveriesByUser(this.user.id_user).
            then((response) => {
                this.deliveriesUser = response;
            })

            markersByUser(this.user.id_user).
            then((response) => {
                this.markersByUser = response;
            })

            getDeliveriesByKgUser(this.user.id_user).
            then((response) => {
                this.kgUser = response.kg;
            })

        },
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