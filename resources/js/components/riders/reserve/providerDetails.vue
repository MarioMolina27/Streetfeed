<template>
    <div class="container-fluid ps-0 pe-0">
        <Navbar :menuItems = 'menuItems'></Navbar>
        <div class="container-fluid">
            <div v-if ="provider && provider.type_users && provider.type_users.length > 0" class="detail-header" :style="`background-image: url(../img/${provider.type_users[0].pivot.type_of_provider}.png)`">
            <h1 class="provider-name">{{ provider.nickname }}</h1>
            <button class="heart-button" style="outline: 0;" @click="toggleHeart">
                <i :class="heartClass" style="font-size: 1.5rem"></i>
            </button>
        </div>
        <div class="row mt-3 mb-3">
            <div class="col-lg-6 col-12 d-flex flex-column justify-content-center">
                <div class="d-flex flex-column justify-content-center align-items-center">
                   <div>
                    <div>
                        <p>Horario: </p>
                    </div>
                    <div class="info-text" v-if="provider.schedules && provider.schedules.length > 0">
                            <strong>{{ provider.schedules[0].start_time + " - " + provider.schedules[0].finish_time }}</strong>
                    </div>
                    <strong class="info-text" v-else>Sin Horario<br></strong>
                    <strong class="info-text" v-if="provider.schedules && provider.schedules.length > 1">{{ provider.schedules[1].start_time + " - " + provider.schedules[1].finish_time }}</strong><br>
                   </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <div>
                        <div>
                        <p>Ubicación: </p>
                    </div>
                    <div class="info-text" v-if="provider.addresses && provider.addresses.length > 0">
                            <strong>{{ provider.addresses[0].road_type.name + " " + provider.addresses[0].name + " " + provider.addresses[0].number + " (" + provider.addresses[0].cp + ")"}}</strong><br>
                            <strong>{{ provider.addresses[0].city + ", " + provider.addresses[0].country }}</strong><br>
                    </div>
                    <div class="info-text" v-else>
                        <strong>No se encontraron direcciones.</strong>
                    </div> 
                    </div> 
                </div>
            </div>
        </div>
        <div class="divider"></div>
        <div class="detail-provider-menus">
            <template v-for="(menu) in provider.menus">
                <menu-card :menu = menu @value-changed="updateLaunchpack"></menu-card>          
            </template>
            <div id="reserve-details" v-show="showReserveData" class="reserve-data">
            </div>
            <button v-show="showReserveData" class="reserve-button mb-5" @click="assignReserve">Reserva</button>
        </div>
        </div>
    </div>
</template>

<script>
import menuCard from './menuCard.vue';
import Navbar from '../../shared/Navbar.vue';
export default{
    props: {
        nickname: String
    },
    data(){
      return {
        idUser: 4,
        provider: [],
        menus: [],
        menuItems: [
          {name: 'Inicio', href: '/'},
          {name: 'Explorar', href: '/explore'},
          {name: 'Reservas', href: '/reservations'},
          {name: 'Perfil', href: '/profile'}
        ]
      }
    },
    created() {
        this.loadProvider();
    },
    computed: {
        heartClass() {
            return this.provider.is_favorite ? 'pi pi-heart-fill' : 'pi pi-heart';
        },
        showReserveData() {
            return this.menus.length === 0 || this.menus.some(menu => menu.launchpacks > 0);
        }
    },
    methods: {
        loadProvider() {
            axios.get(`api/users/get-provider/${this.nickname}/${this.idUser}`)
            .then(response => {
                this.provider = response.data;
                this.createMenusArray();
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
        assignReserve() {
            const encodedMenuId = btoa(JSON.stringify(this.menus));
            window.location.href = '../assignreserve/' + encodeURIComponent(encodedMenuId);
        },
        createMenusArray() {
            this.provider.menus.forEach(menu => {
                this.menus.push({
                    id: menu.id_menu,
                    launchpacks: 0
                });
            })
        },
        updateLaunchpack(newLaunchpackValue, menuid) {
            const menuToUpdate = this.menus.find(menu => menu.id === menuid);
            const menuFromProvider = this.provider.menus.find(menu => menu.id_menu === menuid);
            const menuTitle = menuFromProvider.title;
            if (menuToUpdate) {
                menuToUpdate.launchpacks = newLaunchpackValue;
            } else {
                console.error(`No se encontró el menú con el ID ${menuid}`);
            }
            const existingP = document.getElementById(`menu-${menuid}`);

            if (newLaunchpackValue === 0 && existingP) {
                existingP.remove();
            } else {
                if (existingP) {
                    existingP.textContent = `${menuTitle} x ${newLaunchpackValue}`;
                } else {
                    const p = document.createElement('p');
                    p.id = `menu-${menuid}`;
                    p.classList.add('menu-info-reserve');
                    
                    p.textContent = `${menuTitle} x ${newLaunchpackValue}`;
                    document.getElementById('reserve-details').appendChild(p);
                }
            }
        }
    },
    components: {
        menuCard,
        Navbar
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
        background-position-x: center;
        background-position-y: center;
        background-size: cover;
        filter: drop-shadow(0px 0px 10px #b487537a);
        filter: brightness(0.9);
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
    .reserve-button {
        width: 80%;
        height: 50px;
        background-color: #984EAE;
        color: white;
        font-size: 1.5rem;
        border: none;
        margin: 20px 0 0 0;
        border-radius: 5px;
        cursor: pointer;
    }
    .reserve-data {
        width: 80%;
        background-color: #984eae20;
        border: #984EAE 1px dashed;
        font-size: 1.5rem;
        margin: 20px 0 0 0;
        border-radius: 5px;
        padding: 5px;
    }
    .menu-info-reserve {
        display: flex;
        justify-content: center;
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