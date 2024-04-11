<template>
    <div class="container-fluid mt-5 h-100">
        <div class="row">
            <div :class="{'col-lg-8 col-12 mb-3 order-1':!smallScreen, 'col-lg-8 col-12 mb-3 order-2': smallScreen}">
                <Card class="p-3 h-100">
                    <template #header>
                        <div class="card-header">
                            <h3 class="title-card-stadistics mt-3">{{translations.riderEvolLabel}}</h3>
                        </div>
                    </template>
                    <template #content>
                        <EvolutionRidersGraphic />
                    </template>
                </Card>
            </div>

            <div :class="{'col-lg-4 col-12 mb-3 order-2': !smallScreen, 'col-lg-4 col-12 mb-3 order-1': smallScreen}">
                <div class="d-flex flex-column justify-content-center h-100">
                    <div class="d-flex flex-column justify-content-center align-items-center mt-3">
                        <h3 class="title-stadistics-riders mb-0">NUESTROS</h3>
                        <h3 class="title-stadistics-riders title-stadistics-riders-2 mt-0 mb-3">{{translations.ridersLabel}}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5 col-12 mb-3">
                <div class ="h-100 d-flex flex-column justify-content-between">
                    <Card class="p-3 h-50">
                        <template #header>
                            <div class="card-header">
                                <h3 class="title-card-stadistics mt-3 p-2">{{translations.oursLabel}} {{translations.ridersLabel}}</h3>
                            </div>
                        </template>
                        <template #content>
                            <h3 class="title-stadistics-riders title-stadistics-riders-2  mt-0 mb-0">{{ numRiders }}</h3>
                        </template>
                    </Card>
                    <Card class="p-3 h-50 mt-3">
                        <template #header>
                            <div class="card-header">
                                <h3 class="title-card-stadistics mt-3 p-2">{{translations.deliveriesDoneLabel}}</h3>
                            </div>
                        </template>
                        <template #content>
                            <h3 class="title-stadistics-riders title-stadistics-riders-2  mt-0 mb-0">{{ numDeliveredOrders }}</h3>
                        </template>
                    </Card>
                </div>
            </div>
            <div class="col-lg-7 col-12 mb-3">
                <Card class="p-3 h-100">
                    <template #header>
                        <div class="card-header">
                            <h3 class="title-card-stadistics mt-3">{{translations.theirLocationLabel}}</h3>
                        </div>
                    </template>
                    <template #content>
                        <LocationRidersGraphic />
                    </template>
                </Card>
            </div>
        </div>
    </div>
</template>

<script>
import Card from "primevue/card";
import EvolutionRidersGraphic from "../graphics/rider/EvolutionRidersGraphic.vue";
import LocationRidersGraphic from "../graphics/rider/LocationRidersGraphic.vue";
import { getNumUsersByType } from "../../../services/users.js";
import { getTotalDeliveries } from "../../../services/delivery.js";

export default {
  name: "StadisticsRider",
  props: {
        translations: Object
    },
  components: {
    Card,
    EvolutionRidersGraphic,
    LocationRidersGraphic
  },

  data() {
    return {
      numRiders: 0,
      numDeliveredOrders: 0,
      smallScreen: false
    };
  },

  mounted() {
    window.addEventListener("resize", this.handleResize);
    this.handleResize();

    getNumUsersByType(1).then((response) => {
      console.log(response);
      this.numRiders = response;
    });

    getTotalDeliveries().then((response) => {
      this.numDeliveredOrders = response.deliveries;
    });
  },

  methods: {
    handleResize() {
      this.smallScreen = window.innerWidth <= 992;
    }
  }
};
</script>

<style scoped>
    .title-stadistics-riders{
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

    .title-stadistics-riders-2{
        color: #984EAE;
    }
</style>../../../services/users.js../../../services/delivery.js./StadisticsRider.vue/index.js