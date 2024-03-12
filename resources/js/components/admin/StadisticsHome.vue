<template>
    <div class="container-fluid mt-5 h-100">
        <div class="row">
            <div class="col-lg-4 col-12 mb-3">
                <div class="d-flex flex-column justify-content-between h-100">
                    <div class="d-flex flex-column justify-content-center align-items-center mt-3">
                        <h3 class="title-home-admin mb-0">NUESTRA</h3>
                        <h3 class="title-home-admin mt-0 mb-3">APP</h3>
                    </div>
                    <Card class="p-3">
                        <template #header>
                            <div class="card-header">
                                <h3 class="title-card-stadistics mt-3 p-2">COMIDA SALVADA</h3>
                            </div>
                        </template>
                        <template #content>
                            <h3 class="title-home-admin mt-0 mb-0">{{ deliveriesKg }}</h3>
                        </template>
                    </Card>
                </div>
            </div>

            <div class="col-lg-8 col-12 mb-3">
                <Card class="p-3 h-100">
                    <template #header>
                        <div class="card-header">
                            <h3 class="title-card-stadistics mt-3">EVOLUCION STREETFEED</h3>
                            <EvolutionUsersGraphic />
                        </div>
                    </template>
                    <template #content>
                    </template>
                </Card>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-12 mb-3">
                <Card class="p-3">
                    <template #header>
                        <div class="card-header">
                            <h3 class="title-card-stadistics mt-3">NUESTROS USUARIOS</h3>
                            <NumUsersGraphic />
                        </div>
                    </template>
                    <template #content>
                    </template>
                </Card>
            </div>

            <div class="col-lg-8 col-12 mb-3">
                <Card class="p-3 h-100">
                    <template #header>
                        <div class="card-header">
                            <h3 class="title-card-stadistics mt-3">NUESTROS REPARTOS</h3>
                        </div>
                    </template>
                    <template #content>
                        <DeliveryHistoryGraphic />
                    </template>
                </Card>
            </div>
        </div>
    </div>
</template>

<script>
import Card from "primevue/card";
import NumUsersGraphic from "./graphics/home/NumUsers.vue";
import EvolutionUsersGraphic from "./graphics/home/EvolutionUsersGraphic.vue";
import DeliveryHistoryGraphic from "./graphics/home/DeliveryHistoryGraphic.vue";
import { getDeliveriesKg } from "../../services/delivery.js";



export default {
    name: "StadisticsHome",

    components: {
        Card,
        NumUsersGraphic,
        EvolutionUsersGraphic,
        DeliveryHistoryGraphic
    },

    data() {
        return {
            deliveriesKg: 0
        };
    },

    mounted() {
        getDeliveriesKg().then((response) => {
            console.log(response);
            this.deliveriesKg = response.kg + " Kg";
        });
    },
}
</script>

<style scoped>
    .title-home-admin{
        font-size: 3.5rem;
        font-weight: bold;
        color: #081733;
        text-align: center;
        letter-spacing: 2px;
    }

    .title-card-stadistics{
        font-size: 1.5rem;
        font-weight: 500;
        color: #081733;
        text-align: center;
        letter-spacing: 2px;
    }

    .p-card{
        border: 2px solid #081733;
        margin: 0 ;
    }
</style>./graphics/home/DeliveryHistoryGraphic.vue./graphics/home/NumUsers.vue./graphics/home/EvolutionUsersGraphic.vue