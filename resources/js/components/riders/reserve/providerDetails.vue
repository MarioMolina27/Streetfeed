<template>
    <div class="detail-header">
        <h1 class="provider-name">{{ provider.nickname }}</h1>
        <button class="heart-button" style="outline: 0;" @click="toggleHeart">
            <i :class="heartClass" style="font-size: 1.5rem"></i>
        </button>
        <img v-if="provider && provider.type_users && provider.type_users.length > 0"
         :alt="`Provider image`"
         :src="`../img/${provider.type_users[0].pivot.type_of_provider}.png`"
         class="card-img-detail" />
    </div>
    <div class="detail-provider-content row">
        <div class="col-lg-6 col-12 d-flex justify-content-center">
            <p>
                Horario:<br>
                <div class="info-text" v-if="provider.schedules && provider.schedules.length > 0">
                    <strong>{{ provider.schedules[0].start_time + " - " + provider.schedules[0].finish_time }}</strong>
                </div>
                <strong class="info-text" v-else>Sin Horario<br></strong>
                <strong class="info-text" v-if="provider.schedules && provider.schedules.length > 1">{{ provider.schedules[1].start_time + " - " + provider.schedules[1].finish_time }}</strong><br>
            </p>
        </div>
        <div class="col-lg-6 col-12 d-flex justify-content-center">
            <p>
                Ubicación:<br>
                <div class="info-text" v-if="provider.addresses && provider.addresses.length > 0">
                    <strong>{{ provider.addresses[0].road_type.name + " " + provider.addresses[0].name + " " + provider.addresses[0].number + " (" + provider.addresses[0].cp + ")"}}</strong><br>
                    <strong>{{ provider.addresses[0].city + ", " + provider.addresses[0].country }}</strong><br>
                </div>
                <div class="info-text" v-else>
                    <strong>No se encontraron direcciones.</strong>
                </div>    
            </p>
        </div>
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
        return this.provider.is_favorite ? 'pi pi-heart-fill' : 'pi pi-heart';
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
            this.provider.is_favorite = !this.provider.is_favorite;
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
    .info-text {
        font-size: 1.5rem;
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
</style>./reserve/menuCard.vue