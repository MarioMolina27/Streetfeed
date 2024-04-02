<template>
    <div class="container-fluid mt-5 h-100">
        <div class="row">
            <div class="col-lg-4 col-12 mb-3">
                <div class="d-flex flex-column justify-content-center h-100">
                    <div class="d-flex flex-column justify-content-center align-items-center mt-3">
                        <h3 class="title-stadistics-providers mb-0">NUESTROS</h3>
                        <h3 class="title-stadistics-providers title-stadistics-providers-2 mt-0 mb-3">PROVIDERS</h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-12 mb-3">
                <Card class="p-3 h-100">
                    <template #header>
                        <div class="card-header">
                            <h3 class="title-card-stadistics mt-3">EVOLUCION DE PROVIDERS</h3>
                        </div>
                    </template>
                    <template #content>
                        <EvolutionProvidersGraphic />
                    </template>
                </Card>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7 col-12 mb-3">
                <Card class="p-3 h-100">
                    <template #header>
                        <div class="card-header">
                            <h3 class="title-card-stadistics mt-3">SUS LOCALIDADES</h3>
                        </div>
                    </template>
                    <template #content>
                        <LocationProvidersGraphic />
                    </template>
                </Card>
            </div>
            <div class="col-lg-5 col-12 mb-3">
                <div class ="h-100 d-flex flex-column justify-content-between">
                    <Card class="p-3 h-50">
                        <template #header>
                            <div class="card-header">
                                <h3 class="title-card-stadistics mt-3 p-2">NUESTROS PROVIDERS</h3>
                            </div>
                        </template>
                        <template #content>
                            <h3 class="title-stadistics-providers title-stadistics-providers-2  mt-0 mb-0">{{numProviders}}</h3>
                        </template>
                    </Card>
                    <Card class="p-3 h-50 mt-3">
                        <template #header>
                            <div class="card-header">
                                <h3 class="title-card-stadistics mt-3 p-2">PEDIDOS ENTREGADOS</h3>
                            </div>
                        </template>
                        <template #content>
                            <h3 class="title-stadistics-providers title-stadistics-providers-2  mt-0 mb-0">{{numDeliveredOrders}}</h3>
                        </template>
                    </Card>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Card from "primevue/card";
import EvolutionProvidersGraphic from "../graphics/provider/EvolutionProvidersGraphic.vue";
import LocationProvidersGraphic from "../graphics/provider/LocationProvidersGraphic.vue";
import { getNumUsersByType } from "../../../services/users.js";
import { getTotalDeliveries } from "../../../services/delivery.js";

export default {
    name: "StadisticsProviders",

    components: {
        Card,
        EvolutionProvidersGraphic,
        LocationProvidersGraphic
     
    },

    data() {
        return {
            numProviders: 0,
            numDeliveredOrders: 0,
        };
    },

    mounted() {
        getNumUsersByType(2).then((response) => {
            console.log(response);
            this.numProviders = response;
        });
        getTotalDeliveries().then((response) => {
            this.numDeliveredOrders = response.deliveries;
        });
    },
}
</script>

<style scoped>
    .title-stadistics-providers{
        font-size: 3.5rem;
        font-weight: bold;
        color: #081733;
        text-align: center;
        letter-spacing: 2px;
    }

    .title-card-stadistics{
        font-size: 1.5rem;
        font-weight: 600;
        color: #081733;
        text-align: center;
        letter-spacing: 2px;
    }

    .p-card{
        border: 2px solid #081733;
        margin: 0 ;
    }

    .title-stadistics-providers-2{
        color: #b48753;
    }
</style>