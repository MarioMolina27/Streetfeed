<template>
    <div class="homeless-card" style="margin-top: 10px; display: flex;">
      <div class="homeless-card-content" style="flex: 1;">
        <div class="homeless-card-sections">
          <div>
            <span>Reparto</span>
            <p class="p-border-bottom"><strong>{{homeless.idDelivery}}</strong></p>
          </div>
          <button class="deliver-btn">Entregar</button>
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
  .deliver-btn {
    background-color: #984EAE;
    color: #FDF8EB;
    width: 10%;
    height: 30px;
    min-width: 100px;
    font-size: 1rem;
    padding: 5px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  
  
</style>