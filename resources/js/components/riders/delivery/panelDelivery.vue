<template>
<div class="container-fluid ps-0 pe-0">
    <Navbar :menuItems = 'menuItems'></Navbar>
    <div class="delivery-container">
        <div v-if="loading">
                Cargando...
        </div>
        <div v-else-if="deliveries.length === 0" class="delivery-call-action">
            <noDelivery></noDelivery>
        </div>
        <div v-else style="width: 100%" class="d-flex flex-column">
            <hasDelivery :deliveries = deliveries></hasDelivery>
        </div>
    </div>
</div>
</template>

<script>
import Navbar from '../../shared/Navbar.vue';
import noDelivery from './noDelivery.vue';
import hasDelivery from './hasDelivery.vue';
export default{
    data(){
      return {
        menuItems: [
                {name: 'Tus Repartos', href: './delivery'},
                {name: 'Explorar', href: './explore'},
                {name: 'Favoritos', href: './favorite'},
                {name: 'Perfil', href: './profile'}
            ],
        loading: false,
        deliveries: []
      }
    },
    methods: {
        getDeliveries() {
            this.loading = true;
            axios.get('/api/delivery/get-user-deliveries/4')
                .then(response => {
                    this.deliveries = response.data;
                    console.log('Repartos:', this.deliveries);
                    this.loading = false;
                })
                .catch(error => {
                    console.error('Error al obtener los repartos:', error);
                    this.loading = false;
                });
        },
    },
    mounted(){
        this.getDeliveries();
    },
    components: {
        Navbar,
        noDelivery,
        hasDelivery
    }
}
</script>

<style scoped>
    .delivery-call-action > h1, p {
        text-align: center;
    }
    .delivery-container {
        display: flex;
        justify-content: center;
        padding: 20px;
        height: calc(100vh - 18vh);
    }
    .delivery-call-action {
        width: 80%;
    }
    @media (max-width: 691px) {
        .delivery-call-action {
            width: 95%;
        }
    }
    .button-suggest {
        margin: 0 auto;
        width: 20vw;
        min-width: 250px;
        height: 50px;
        background-color: #984EAE;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s ease;
    }
    .button-suggest:hover {
        background-color: #7a3a81;
        transform: scale(1.01);
    }
</style>