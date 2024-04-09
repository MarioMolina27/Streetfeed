<template>
    <div v-if="userIsProvider && userIsRider" class="row d-flex justify-content-around">
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
                        <p class="mb-0 mt-1 text-profile-stats">
                            {{ this.deliveriesUser }}
                        </p>

                        <p class="text_type_user">Rider</p>
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
                            src="img/bag.svg"
                            alt="Card"
                            class="img-profile-stats"
                        />
                        <p class="mb-0 mt-1 text-profile-stats">
                            {{ this.numProviderDeliveries }}
                        </p>
                        <p class="text_type_user">Provider</p>
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
                        <p class="mb-0 mt-1 text-profile-stats">
                            {{ this.kgUser }}kg
                        </p>
                        <p class="text_type_user">Rider</p>

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
                        <p class="mb-0 mt-1 text-profile-stats">
                            {{ this.kgUser }}kg <!-- Cambiar por kg por proveedor -->
                        </p>
                        <p class="text_type_user">Provider</p>
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
                        <p class="text_type_user">User</p>
                    </div>
                </template>
            </Card>
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
                            {{ this.kgUser }}kg
                        </p>
                        <p v-else class="mb-0 mt-1 text-profile-stats">
                            {{ this.kgUser }}kg  <!-- Cambiar por kg por proveedor -->
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
export default {
    props: {
        type_user: Array,
        deliveriesUser: Number,
        kgUser: Number,
        markersByUser: Number,

        numProviderDeliveries: Number,
    },

    computed: {
        userIsRider() {
            return this.type_user.some((userType) => userType.id === 1);
        },
        userIsProvider() {
            return this.type_user.some((userType) => userType.id === 2);
        },
    },

    components: {
        Card,
    },
};
</script>

<style scoped>
.p-card {
    background-color: #b48753;
    margin: 5px;
}

.p-card-body {
    padding: 15px;
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
}
</style>
