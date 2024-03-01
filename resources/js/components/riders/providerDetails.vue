<template>
    <div class="detail-header">
        <h1 class="provider-name">{{ provider.name }}</h1>
        <button class="heart-button" style="outline: 0;" @click="toggleHeart">
            <i :class="heartClass" style="font-size: 1.5rem"></i>
        </button>
        <img v-if="provider && provider.type_users && provider.type_users.length > 0"
         :alt="`Provider image`"
         :src="`../img/${provider.type_users[0].pivot.type_of_provider}.png`"
         class="card-img-detail" />
    </div>
    <div class="detail-provider-content">
        <p>
            Horario:<br>
            <strong v-if="provider.schedules && provider.schedules.length > 0">
                {{ provider.schedules[0].start_time + " - " + provider.schedules[0].finish_time }}
            </strong>
            <strong v-else>Sin Horario</strong><br>
            <strong v-if="provider.schedules && provider.schedules.length > 1">{{ provider.schedules[1].start_time + " - " + provider.schedules[1].finish_time }}</strong><br>
        </p>
        <p>
            Ubicación:<br>
            <div v-if="provider.addresses && provider.addresses.length > 0">
                <strong>{{ provider.addresses[0].country + " " + provider.addresses[0].city }}</strong><br>
                <strong>{{ provider.addresses[0].road_type.name + " " + provider.addresses[0].name + " " + provider.addresses[0].number + " (" + provider.addresses[0].cp + ")"}}</strong><br>
            </div>
            <div v-else>
                No se encontraron direcciones.
            </div>    
        </p>
    </div>
    <div class="divider"></div>
    <div class="detail-provider-menus">
        <template v-for="(menu) in provider.menus">
            <menu-card :menu = menu ></menu-card>
        </template>
    </div>
</template>

<script>
import menuCard from './menuCard.vue';
export default{
    props: {
        nickname: String
    },
    data(){
      return {
        idUser: 4,
        provider: []
      }
    },
    created() {
        this.loadProvider();
    },
    computed: {
      heartClass() {
        return this.provider.isFavorite ? 'pi pi-heart-fill' : 'pi pi-heart';
      }
    },
    methods: {
        loadProvider() {
            axios.get(`api/users/get-provider/${this.nickname}/${this.idUser}`)
            .then(response => {
                this.provider = response.data;
                console.log(this.provider);
            })
            .catch(error => {
                console.error('Error al obtener el proveedor:', error);
            });
        },
        toggleHeart(event) {
            this.provider.isFavorite = !this.provider.isFavorite;
            let button = event.currentTarget;
            button.classList.add('heart-icon-clicked');
            setTimeout(() => {
                button.classList.remove('heart-icon-clicked');
            }, 300);

            axios.post('api/users/toggle-favorite-provider', {
                userId: 4,
                providerId: this.provider.id_user
            })
            .then(response => {
                this.loadProvider();
            })
            .catch(error => {
                console.error('Error al cambiar el estado de favorito:', error);
            });
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
    .card-img-detail{
        width: 100%;
        background-size: auto;
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