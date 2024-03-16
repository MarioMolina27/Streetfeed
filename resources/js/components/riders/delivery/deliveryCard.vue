<template>
    <div class="menu-card" style="margin-top: 30px; display: flex;">
      <div class="menu-card-content" style="flex: 1;">
        <div class="menu-card-header">
          <h2>Card</h2>
          <h2>HELLO</h2>
        </div>
        <div class="menu-card-body row gx-3">
          <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="menu-products">
                  <p class="label-type-product mb-0 fs-6">Primer producto</p>
                  <p class="type-product">PRIMER PRODUCTO</p>
              </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="menu-products">
                  <p class="label-type-product mb-0 fs-6">Segundo producto</p>
                  <p class="type-product">PRIMER PRODUCTO</p>
              </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="menu-products">
                  <p class="label-type-product mb-0 fs-6">Bebida</p>
                  <p class="type-product">PRIMER PRODUCTO</p>
              </div>
          </div>
        </div>
        <div class="menu-card-footer d-flex justify-content-between">
            
        </div>
    </div>
  </div>
</template>

<script>
export default {
    props: {
        delivery: Object
    }
}
</script>

<style scoped>
.menu-card {
    margin: 0 auto;
    width: 90%;
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
      justify-content: center;
      width: 100%;
  }
  .menu-products {
    display: flex;
    flex-direction: column;
    text-align: center;
  }
  .label-type-product {
    color: #08173390;
  }
  .type-product {
    color: #081733;
    font-size: 1.25rem;
  }
  .menu-card-footer {
      display: flex;
      justify-content: space-between;
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
  .p-inputnumber-button-down {
    border-radius: 5px 0 0 5px;
    border: 1px solid #984EAE;

  }
  .p-inputnumber-button-up {
    border-radius: 0 5px 5px 0;
    border: 1px solid #984EAE;
  }
  .p-inputtext:enabled:focus {
    outline: 1px solid #984EAE;
    pointer-events: none;
  }
  .p-inputnumber-input {
    width:50px; 
    text-align: center; 
    background-color: #ffffff; 
    font-weight: bold; 
    border-top: 1px solid #984EAE;
    border-bottom: 1px solid #984EAE;
    pointer-events: none;
  }
</style>