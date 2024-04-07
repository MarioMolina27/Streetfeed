<template>
    <div class="item-menu-card">
        <span>{{ menu.title }}</span>
        <div class="item-menu-products">
            <p>Primer plato: <strong class="fs-5">{{ menu.first_product }}</strong> </p>
            <p>Segundo plato: <strong class="fs-5">{{ menu.second_product }}</strong></p>
            <p>Bebida: <strong class="fs-5">{{ menu.drink_product }}</strong></p>
        </div>
        <div class="item-menu-products">
            <InputNumber v-model="launchapack_counting" buttonLayout="horizontal" mode="decimal" showButtons :min="0" :max="menu.launchpack_count" @update:modelValue="emitChangeValue">
              <template #incrementbuttonicon><span class="pi pi-plus" style=" color: #ffffff;font-weight: bold;"/></template>
              <template #decrementbuttonicon><span class="pi pi-minus" style=" color: #ffffff;font-weight: bold;"/></template>
            </InputNumber>
        </div>
    </div>
</template>

<script>
import InputNumber from 'primevue/inputnumber';
export default {
    props: {
        menu: Object
    },
    data(){
        return {
            launchapack_counting: 0
        }
    },
    mounted() {
       
    },
    methods: {
        
    },
    components: {
        InputNumber
    }
}
</script>

<style scoped>
    .item-menu-card {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        margin-top: 20px;
        border: 2px solid #b17a3b;
        border-radius: 10px;
        padding: 10px;
    }
    .item-menu-products {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-around;
        gap: 10px;
    }
</style>