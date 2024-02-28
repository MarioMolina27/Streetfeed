<template>
    <div class="detail-header">
        <h1 class="provider-name">{{ provider.name }}</h1>
        <button class="heart-button" style="outline: 0;" @click="toggleHeart">
            <i :class="heartClass" style="font-size: 1.5rem"></i>
        </button>
        <img :alt="`Provider image`" :src="`img/${provider.image}`" class="card-img-top" />
    </div>
    <div class="detail-provider-content">
        <p>
            Horario:<br>
            <strong>{{ provider.scheduleShift1 }}</strong><br>
            <strong>{{ provider.scheduleShift2 }}</strong><br>
        </p>
        <p>
            Ubicación:<br>
            <strong>{{ provider.city }}</strong><br>
            <strong>{{ provider.adress }}</strong><br>
        </p>
    </div>
    <div class="divider"></div>
    <div class="detail-provider-menus">
        <template v-for="(menu) in provider.menu">
            <menu-card :menu = menu ></menu-card>
        </template>
    </div>
</template>

<script>
import menuCard from './menuCard.vue';
export default{
    props: {
        provider: Object
    },
    data(){
      return {
      
      }
    },
    mounted() {
        console.log(this.provider);
    },
    computed: {
      heartClass() {
        return this.provider.isFavorite ? 'pi pi-heart-fill' : 'pi pi-heart';
      }
    },
    methods: {
        toggleHeart(event) {
            this.provider.isFavorite = !this.provider.isFavorite;
            let button = event.currentTarget;
            button.classList.add('heart-icon-clicked');
            setTimeout(() => {
            button.classList.remove('heart-icon-clicked');
            }, 300);
        },
    },
    components: {
        menuCard
    },
}
</script>

<style>
    .detail-header {
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 30vh;
        border-bottom: 5px solid #B48753;
    }
    .provider-name {
        position: absolute;
        bottom: 0;
        left:10px;
        font-weight: bold;
        color: white;
        padding: 10px;
        z-index: 2;
    }
    .heart-button {
        cursor: pointer;
        position: absolute;
        top: 0;
        right: 0;
        background-color: transparent;
        border: none;
        color: white;
        padding: 10px;
        z-index: 2;
        transition: transform 0.3s ease-in-out;
    }
    .heart-icon-clicked {
        animation: heartPulse 0.3s;
    }

    @keyframes heartPulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.2);
        }
        100% {
            transform: scale(1);
        }
    }
    .detail-provider-content {
        display: flex;
        justify-content: space-around;
        align-items: center;
        margin-block: 10px;
    }
    .detail-provider-content > p{
        font-size: 1.5rem;
    }
    .divider {
        width: 80%;
        height: 2px; 
        background-color: #B48753; 
        margin: 0 auto;
    }
    .detail-provider-menus {
        display: flex;
        flex-direction: column;
        width: 100%;
    }
    .detail-provider-menus {
        display: flex;
        flex-direction: column;
        width: 100%;
        align-items: center;
    } 
</style>