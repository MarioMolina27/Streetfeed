<template>
    <div v-if="userIsProvider && userIsRider" class="row d-flex justify-content-around">
        <div class="col-4 p-0" style="position: relative;">
            <div class="h-100">
                <Card>
                    <template #content>
                        <div
                            class="d-flex flex-column justify-content-center align-items-center"
                        >
                            <img
                                src="img/bag.svg"
                                alt="Card"
                                class="img-profile-stats"
                            />
                            <p class="mb-0 mt-1 text-profile-stats">
                                {{ this.deliveriesUser }}
                            </p>

                        </div>
                    </template>
                </Card>
            </div>
            <p class="text_type_user" style="position: absolute; bottom: 2px; right: 10%;">{{translations.riderLabel}}</p>
        </div>
        <div class="col-4 p-0"  style="position: relative;">
            <div class="h-100">
                <Card>
                    <template #content>
                        <div
                            class="d-flex flex-column justify-content-center align-items-center"
                        >
                            <img
                                src="img/bag.svg"
                                alt="Card"
                                class="img-profile-stats"
                            />
                            <p class="mb-0 mt-1 text-profile-stats">
                                {{ this.numProviderDeliveries }}
                            </p>
                        </div>
                    </template>
                </Card>
            </div>
            <p class="text_type_user" style="position: absolute; bottom: 2px; right: 10%;">{{translations.providerLabel}}</p>

        </div>
        <div class="col-4 p-0" style="position: relative;">
            <div class="h-100">
                <Card>
                    <template #content>
                        <div
                            class="d-flex flex-column justify-content-center align-items-center"
                        >
                            <img
                                src="img/cloud.png"
                                alt="Card"
                                class="img-profile-stats"
                            />
                            <p class="mb-0 mt-1 text-profile-stats">
                                {{ this.deliveriesUser * kgDelivery }}kg
                            </p>
                        </div>
                    </template>
                </Card>
            </div>
            <p class="text_type_user" style="position: absolute; bottom: 2px; right: 10%;">{{translations.riderLabel}}</p>

        </div>

        <div class="col-4 p-0 mt-3" style="position: relative;">
            <div class="h-100">
                <Card>
                    <template #content>
                        <div
                            class="d-flex flex-column justify-content-center align-items-center"
                        >
                            <img
                                src="img/cloud.png"
                                alt="Card"
                                class="img-profile-stats"
                            />
                            <p class="mb-0 mt-1 text-profile-stats">
                                {{ this.numProviderDeliveries * kgDelivery }}kg
                            </p>
                        </div>
                    </template>
                </Card>
            </div>
            <p class="text_type_user" style="position: absolute; bottom: 2px; right: 10%;">{{translations.providerLabel}}</p>
        </div>
        
        <div class="col-4 p-0 mt-3" style="position: relative;">
           <div class="h-100">
            <Card>
                <template #content>
                    <div
                        class="d-flex flex-column justify-content-center align-items-center"
                    >
                        <img
                            src="img/marker.svg"
                            alt="Card"
                            class="img-profile-stats"
                        />
                        <p class="mb-0 mt-1 text-profile-stats">
                            {{ this.markersByUser }}
                        </p>
                    </div>
                </template>
            </Card>
           </div>
           <p class="text_type_user" style="position: absolute; bottom: 2px; right: 10%;">{{translations.youLabel}}</p>
        </div>
    </div>

    <div v-else class="row d-flex justify-content-around">
        <div class="col-3 p-0">
            <Card>
                <template #content>
                    <div
                        class="d-flex flex-column justify-content-center align-items-center"
                    >
                        <img
                            src="img/bag.svg"
                            alt="Card"
                            class="img-profile-stats"
                        />
                        <p v-if="userIsRider" class="mb-0 mt-1 text-profile-stats">
                            {{ this.deliveriesUser }}
                        </p>

                        <p v-else class="mb-0 mt-1 text-profile-stats">
                            {{ this.numProviderDeliveries }}
                        </p>
                    </div>
                </template>
            </Card>
        </div>
        <div class="col-3 p-0">
            <Card>
                <template #content>
                    <div
                        class="d-flex flex-column justify-content-center align-items-center"
                    >
                        <img
                            src="img/cloud.png"
                            alt="Card"
                            class="img-profile-stats"
                        />
                        <p v-if="userIsRider" class="mb-0 mt-1 text-profile-stats">
                            {{ this.deliveriesUser * kgDelivery }}kg
                        </p>
                        <p v-else class="mb-0 mt-1 text-profile-stats">
                            {{ this.numProviderDeliveries * kgDelivery  }}kg  
                        </p>
                    </div>
                </template>
            </Card>
        </div>
        <div class="col-3 p-0">
            <Card>
                <template #content>
                    <div
                        class="d-flex flex-column justify-content-center align-items-center"
                    >
                        <img
                            src="img/marker.svg"
                            alt="Card"
                            class="img-profile-stats"
                        />
                        <p class="mb-0 mt-1 text-profile-stats">
                            {{ this.markersByUser }}
                        </p>
                    </div>
                </template>
            </Card>
        </div>
    </div>
</template>

<script>
import Card from "primevue/card";
import { kgDelivery } from '../../../utilities/constant.js'
export default {
    props: {
        type_user: Array,
        deliveriesUser: Number,
        markersByUser: Number,
        numProviderDeliveries: Number,
        translations: Object
    },

    computed: {
        userIsRider() {
            return this.type_user.some((userType) => userType.id_type_user === 1);
        },
        userIsProvider() {
            return this.type_user.some((userType) => userType.id_type_user === 2);
        },
    },
    components: {
        Card,
    },
    data() {
        return {
            kgDelivery,
        };
    },
};
</script>

<style scoped>
.p-card {
    background-color: #b48753;
    margin: 5px;
    height: 100%;
    display: flex;
    justify-content: center;
}


.img-profile-stats {
    width: 4vh;
    height: 4vh;
}
.text-profile-stats {
    font-size: 1.5rem;
    color: #fdf8eb;
}
.text_type_user {
    color: #fdf8eb;
    margin-bottom: 0px;
    font-size: 15px;
}
</style>
