<template>
   <div class="menu-card" style="margin: 10px; display: flex;">
      <div class="menu-card-image" style="flex: 0 0 33%;">
          <img :src="`../img/menuDefault.png`" alt="Card" style="width: 100%; height: auto;">
      </div>
      <div class="menu-card-content" style="flex: 1;">
        <div class="menu-card-header">
            <h2>{{ menu.name }}</h2>
            <Tag :class="{'low-availability': menu.launchpack.length < 3, 'high-availability': menu.launchpack.length >= 3}" value="Primary">{{ menu.launchpack.length }} disponibles</Tag>
        </div>
        <div class="menu-card-body row">
          <div class="col-lg-4 col-md-6 col-12">
              <p class="label-type-product fs-6">Primer producto</p>
              <p class="type-product">{{ menu.first_product }}</p>
          </div>
          <div class="col-lg-4 col-md-6 col-12">
              <p class="label-type-product fs-6">Segundo producto</p>
              <p class="type-product">{{ menu.second_product }}</p>
          </div>
          <div class="col-lg-4 col-md-6 col-12">
              <p class="label-type-product fs-6">Bebida</p>
              <p class="type-product">{{ menu.drink_product }}</p>
          </div>
        </div>
        <div class="menu-card-footer">
            <button class="btn-menu-reservation">RESERVA</button>
        </div>
    </div>
  </div>
</template>

<script>
import Tag from 'primevue/tag';
export default{
    props: {
      menu: Object
    },
    data(){
      return {
        
      }
    },
    mounted() {
      console.log(this.menu);
    },
    methods: {
      
    },
    components: {
      Tag
    },
}
</script>

<style>
  .menu-card {
    width: 80%;
    height: auto;
    border: 2px solid #B48753;
    border-radius: 5px;
    overflow: hidden;
  }

  .menu-card-image {
      padding: 10px;
      background-color: #f0f0f0;
  }

  .menu-card-content {
      padding: 10px;
  }

  .menu-card-header {
      margin-bottom: 10px;
      display: flex;
      justify-content: space-between;
  }

  .menu-card-body {
      display: flex;
      justify-content: space-between;
      width: 70%;
  }
  .menu-products {
    display: flex;
    flex-direction: column;
  }
  .label-type-product {
    color: #08173390;
  }
  .type-product {
    color: #081733;
  }
  .menu-card-footer {
      display: flex;
      justify-content: flex-end;
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
  .btn-menu-reservation {
    background-color: #984EAE;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
  }
</style>