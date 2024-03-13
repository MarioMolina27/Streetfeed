<template>
<div class="container-fluid ps-0 pe-0">
    <Navbar :menuItems = 'menuItems'></Navbar>
    <div class="delivery-container">
        <div v-if="loading">
                Cargando...
        </div>
        <div v-else-if="deliveries.length === 0" class="delivery-call-action">
            <h1 class="mt-5 mb-4 font-weight-bold">¿A que esperas para hacer un reparto?</h1>
            <p class="fs-4 mb-4">Te podemos proporcionar una sugerencia... </p>
            <div class="d-flex justify-content-center">
                <button class="button-suggest mb-2 fs-5" @click="doSuggest">Sugiereme!</button>
            </div>

            <button class="button-explore mb-2 fs-5" @click="goExplore">Explora proveedores</button>
        </div>
        <div v-else style="width: 100%" class="d-flex flex-column">
                
        </div>
    </div>
</div>
</template>

<script>
import Navbar from '../../shared/Navbar.vue';
import Skeleton from 'primevue/skeleton';
export default{
    data(){
      return {
        menuItems: [
                {name: 'Tus Repartos', href: './delivery'},
                {name: 'Explorar', href: './explore'},
                {name: 'Favoritos', href: './favorite'},
                {name: 'Perfil', href: './profile'}
            ],
        loading: true,
        deliveries: []
      }
    },
    mounted(){
        setTimeout(() => {
            this.loading = false;
        }, 2000);
    },
    components: {
        Navbar,
        Skeleton    
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
    }
    .delivery-call-action {
        width: 80%;
    }
    .button-suggest {
        margin: 0 auto;
        width: 20vw;
        max-width: 20vw;
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
    .button-explore {
        position: absolute;
        bottom: 20px;
        right: 20px;
        width: 20vw;
        max-width: 20vw;
        height: 50px;
        background-color: #ad8a62;
        color: #FDF8EB;
        border: none;
        border-radius: 5px;
        overflow: hidden;
        cursor: pointer;
        transition: background-color 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .button-explore::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.3) 50%, rgba(255, 255, 255, 0));
        transition: left 0.5s ease;
        z-index: 1;
    }

    .button-explore:hover::before {
        left: 100%;
    }
</style>