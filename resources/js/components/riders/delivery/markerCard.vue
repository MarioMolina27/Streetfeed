<template>
    <div class="homeless-card" style="margin-top: 10px; display: flex;">
      <div class="homeless-card-content" style="flex: 1;">
        <div class="homeless-card-sections">
          <div>
            <span>Reparto</span>
            <p class="p-border-bottom"><strong>{{homeless.idDelivery}}</strong></p>
          </div>
          <div class="d-flex flex-column align-items-end">
              <button class="deliver-btn" :disabled="!isDeliverButtonActive" @click="doDeliver">Entregar</button>
              <span v-if="!isDeliverButtonActive" class="info not-active-info">Antes recoge el menú</span>
              <span v-if="isDeliverButtonActive" class="info active-info">Listo para repartir</span>
          </div>
        </div>
        <div class="homeless-card-sections">
          <div>
            <span>Ubicación</span>
            <p class="p-border-bottom"><strong>{{ homeless.location }}</strong></p>
          </div> 
          <div class="d-flex justify-content-end flex-column">
            <span style="font-weight: bold; color: #984EAE;">Necesitado</span>
          </div>
        </div>
    </div>
  </div>
</template>

<script>
export default {
    props: {
      homeless: Object
    },
    computed: {
      isDeliverButtonActive() {
        return this.homeless.status === 2;
      }
    },
    methods: {
      doDeliver() {
        axios.post('api/delivery/do-deliver', {
                deliveryId: this.homeless.idDelivery
            })
            .then(response => {
                console.log(response);
                
            })
            .catch(error => {
                console.log(error);
            });
      }
    },
    mounted(){
    }
}
</script>

<style scoped>
.homeless-card {
    margin: 0 auto;
    width: 100%;
    height: auto;
    border: 2px solid #984EAE;
    background-color: #984eae3d;
    border-radius: 5px;
    overflow: hidden;
  }

  .homeless-card-content {
      padding: 10px;
  }

  .homeless-card-sections {
      display: flex;
      justify-content: space-between;
  }
  .p-border-bottom{
      margin-bottom: 0.5rem;
  }
  .info {
    font-size: 10px;
    font-weight: 600;
  }
  .not-active-info {
    color: #B52A2A;
  }
  .active-info {
    color: #984EAE;
  }
  .deliver-btn {
    background-color: #984EAE;
    color: #FDF8EB;
    width: 10%;
    height: 35px;
    min-width: 100px;
    font-size: 1rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  .deliver-btn:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }
  
</style>