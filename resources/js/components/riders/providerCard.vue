<template>
    <Card class="provider-card mx-3" @click="showDetails">
        <template #header>
            <div class="card-header">
            <h3 class="provider-name">{{ provider.name }}</h3>
            <button class="heart-button" style="outline: 0;" @click.stop.prevent="toggleHeart">
                <i :class="heartClass" style="font-size: 1.5rem"></i>
            </button>
            <img :alt="`Provider image`" :src="`img/${provider.image}`" class="card-img-top" />
            </div>
        </template>
        <template #content>
            <p>
            Horario:<br>
            <strong>{{ provider.scheduleShift1 }}</strong><br>
            <strong>{{ provider.scheduleShift2 }}</strong><br>
            </p>
            <div class="d-flex justify-content-between">
            <Tag :class="{'low-availability': provider.menusAvailable < 3, 'high-availability': provider.menusAvailable >= 3}" value="Primary">{{ provider.menusAvailable }} disponibles</Tag>
            <span><strong>{{ provider.distance }} de ti</strong></span>
            </div>  
        </template>
    </Card>
</template>

<script>
import Card from 'primevue/card';
import Tag from 'primevue/tag';
export default{
    props: {
      provider: Object
    },
    data(){
      return {
      
      }
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
      showDetails(){
        const encodedProvider = btoa(JSON.stringify(this.provider));
        window.location.href = 'details/' + encodeURIComponent(encodedProvider);
      }
    },
    components: {
      Card,
      Tag
    },
}
</script>

<style>
.provider-card {
  width: 22rem;
  flex: 0 0 auto;
  margin-bottom: 20px;
  margin-left: 0 !important;
  border: 3px solid #B48753;
  background-color: #FDF8EB;
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
  height: 10rem;
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