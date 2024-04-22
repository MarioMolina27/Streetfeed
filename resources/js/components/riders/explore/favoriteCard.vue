<template>
    <Card class="provider-card mx-3" @click="showDetails">
        <template #content>
          <div class="card-header mb-3">
            <h3 class="provider-name">{{ provider.nickname }}</h3>
            <button class="heart-button" style="outline: 0;" @click.stop.prevent="toggleHeart">
                <i :class="heartClass" style="font-size: 1.5rem"></i>
            </button>
            <img :alt="`Provider image`" :src="`img/${provider.type_users[0].pivot.type_of_provider}${typeExtension}`" class="card-img-top img-fluid" />
          
          </div>
          <p class="fs-5">
            {{translations.scheduleLabel}}:<br>
            <strong v-if="provider.schedules && provider.schedules.length > 0">
              {{ provider.schedules[0].start_time + " - " + provider.schedules[0].finish_time }}
            </strong>
            <strong v-else>{{translations.notScheduleLabel}}</strong><br>
            <strong v-if="provider.schedules[1]">{{ provider.schedules[1].start_time + " - " + provider.schedules[1].finish_time }}</strong><br>
          </p>
          <div class="d-flex justify-content-between">
            <Tag :class="{'low-availability': totalLaunchpacks  < 3, 'high-availability': totalLaunchpacks  >= 3}" style="font-size: 1.1rem; margin: 0;" value="Primary">{{ totalLaunchpacks  }} {{translations.availableLabel}}</Tag>
            <span class="fs-5"><strong>{{ provider.distance }}km</strong> {{translations.fromYouLabel}}</span>
          </div>  
        </template>
    </Card>
</template>

<script>
import Card from 'primevue/card';
import Tag from 'primevue/tag';
export default{
    props: {
      provider: Object,
      translations: Object
    },
    data(){
      return {
        isRequesting: false,
        imageExtension: ''
      }
    },
    computed: {
      heartClass() {
        return this.provider.is_favorite ? 'pi pi-heart-fill' : 'pi pi-heart';
      },
      totalLaunchpacks() {
        let total = 0;
        this.provider.menus.forEach(menu => {
            total += menu.launchpack.length;
        });
        return total;
      },
      typeExtension() {
        if (this.provider.type_users[0].pivot.type_of_provider == 'restaurante') {
          return '.jpg';
        } else {
          return '.png';
        }
      }
    },
    mounted() {
      
    },
    methods: {
      toggleHeart(event) {
        this.isRequesting = true;
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
            console.log(response.data.message);
            this.$emit('favoriteToggled');
            this.isRequesting = false;
        })
        .catch(error => {
            this.isRequesting = false;
        });
      },
      showDetails(){
        window.location.href = 'details/' + this.provider.nickname;
      }
    },
    components: {
      Card,
      Tag
    },
}
</script>

<style scoped>
.provider-card {
  width: 90%;
  flex: 0 0 auto;
  margin-bottom: 20px;
  margin-left: 0 !important;
  padding: 0;
  border: 3px solid #B48753;
  background-color: #FDF8EB;
  border-radius: 10px;
  transition: box-shadow 0.3s ease-in-out;
}
.provider-card:hover {
  box-shadow: 0 0 10px 0 #B48753;
  cursor: pointer;
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

.provider-name {
  position: absolute;
  bottom: 0;
  left:10px;
  font-weight: bold;
  color: white;
  padding: 10px;
  z-index: 2;
}
.p-card .p-card-body {
    padding: 1rem;
}
.card-header {
  position: relative;
  overflow: hidden;
}

.card-img-top {
  width: 100%;
  height: 15rem;
  border-radius: 10px;
  filter: brightness(60%);
}

.low-availability {
  border: #B52A2A solid 1px;
  background-color: #B52A2A80; 
  color: #B52A2A;
  
}

.high-availability {
  border: #984EAE solid 1px;
  background-color: #984eae80;
  color: #984EAE;
}
</style>