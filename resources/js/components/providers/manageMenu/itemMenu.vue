<template>
    <div class="item-menu-card">
        <div class="d-flex flex-row justify-content-between align-items-center w-100 mb-4">
            <strong v-if="!m.editing && !m.creating"class="fs-5 mb-0">{{ m.title }}</strong>
            <input v-else class="fs-5 form-custom form-custom-title" v-model="m.title" />
            <img v-if="!m.editing && !m.creating" src="img/edit-profile.svg" alt="edit-profile-button" height="35" @click="m.editing=true" />
            <div v-else-if="m.editing && !m.creating" else class="d-flex flex-row-reverse" >
                <button type="submit" class="ms-2" style="background-color: transparent; border: none;">
                    <i class="fa fa-check save-button"></i>
                </button>
                <div @click="cancelEditing()">
                <i class="fa fa-xmark save-button"></i>
                </div>
            </div>
        </div>
        <div v-if="!m.editing && !m.creating" class="item-menu-products">
            <div>
                <p class="mb-0 title-plate">Primer plato</p>
                <strong class="fs-5">{{ m.first_product }}</strong>
            </div>
            <div>
                <p class="mb-0 title-plate">Segundo plato</p>
                <strong class="fs-5">{{ m.second_product }}</strong>
            </div>
            <div>
                <p class="mb-0 title-plate">Bebida</p>
                <strong class="fs-5">{{ m.drink_product }}</strong>
            </div>
            <InputNumber v-model="launchapack_counting" buttonLayout="horizontal" mode="decimal" showButtons :min="0" :max="m.launchpack_count">
              <template #incrementbuttonicon><span class="pi pi-plus" style=" color: #ffffff;font-weight: bold;"/></template>
              <template #decrementbuttonicon><span class="pi pi-minus" style=" color: #ffffff;font-weight: bold;"/></template>
            </InputNumber>
        </div>
        <template v-else>
            <div class="row mb-3 ms-4">
                <div class="col-lg-3 col-12">
                    <p class="mb-0 title-plate">Primer plato</p>
                    <input class="fs-5 form-custom" v-model="m.first_product" />
                </div>
                <div class="col-lg-3 col-12">
                    <p class="mb-0 title-plate">Segundo plato</p>
                    <input class="fs-5 form-custom" v-model="m.second_product" />
                </div>
                <div class="col-lg-3 col-12">
                    <p class="mb-0 title-plate">Bebida</p>
                    <input class="fs-5 form-custom" v-model="m.drink_product" />
                </div>
                <div class="col-lg-3 col-12 d-flex justify-content-center align-items-center">
                    <InputNumber v-model="launchapack_counting" buttonLayout="horizontal" mode="decimal" showButtons :min="0" :max="m.launchpack_count">
                        <template #incrementbuttonicon><span class="pi pi-plus" style=" color: #ffffff;font-weight: bold;"/></template>
                        <template #decrementbuttonicon><span class="pi pi-minus" style=" color: #ffffff;font-weight: bold;"/></template>
                    </InputNumber>
                </div>
            </div>
            <div class="row w-100">
                <div class="col-lg-10 col-9">
                    <button type="submit" class="btn-menu btn-save">Guardar</button>
                </div>
                <div v-if="m.editing" class="col-lg-2 col-3">
                    <button class="btn-menu btn-delete"><i class="pi pi-trash"></i></button>
                </div>
                <div v-else class="col-lg-2 col-3">
                    <button class="btn-menu btn-delete" @click="deleteMenuItem"><i class="pi pi-times"></i></button>
                </div>
            </div>
           
        </template>

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
            m: this.menu,
            launchapack_counting: 0,
        }
    },
    mounted() {
        console.log(this.m);
        this.launchapack_counting = this.m.launchpack.length;
    },
    methods: {
        cancelEditing(){
            this.m.editing = false;
        },
        deleteMenuItem(){
            this.$emit('deleteMenuItem', this.m);
        }
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
        align-items: start;
        flex-direction: column;
        margin-top: 20px;
        border: 3px solid #b17a3b;
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

    .save-button{
        color: #984eae;
        font-size: 3rem;
        cursor: pointer;
    }   

    .form-custom{
        width: 100%;
        padding: 10px;
        border: none;
        outline: none;
        border-bottom: 2px solid #b48753;
        margin-bottom: 10px;
        background-color: transparent;
    }

    .form-custom-title{
        width: 50%;
        font-weight: 700;
    }

    .btn-save{
        width: 100%;
        background-color: #b48753;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .btn-delete{
        width: 100%;
        background-color: #FDF8EB;
        border: 3px solid #b48753;
        border-radius: 5px;
        padding: 10px;
        color: #b48753;
    }

    .btn-menu{
        transition: 0.3s ease;
    }
    .btn-menu:hover{
        transform: scale(1.05);
    }

    .title-plate{
        color: #b6b2ae;
    }
</style>