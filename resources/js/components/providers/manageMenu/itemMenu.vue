<template>
    <div class="item-menu-card">
        <div class="d-flex flex-row justify-content-between align-items-center w-100 mb-4">
            <strong v-if="!m.editing && !m.creating"class="fs-5 mb-0">{{ m.title }}</strong>
            <input v-else class="fs-5 form-custom form-custom-title" v-model="m.title" />
            <img v-if="!m.editing && !m.creating" src="img/edit-profile.svg" alt="edit-profile-button" height="35" @click="m.editing=true" style="cursor: pointer;" />
            <div v-else-if="m.editing && !m.creating" else class="d-flex flex-row-reverse" >
                <div @click="cancelEditing()">
                <i class="fa fa-xmark save-button"></i>
                </div>
            </div>
        </div>
        <div v-if="!m.editing && !m.creating" class="row w-100">
            <div class="col-lg-3 col-12">
                <p class="mb-0 title-plate">{{ translations.firstMealLabel }}</p>
                <strong class="fs-5">{{ m.first_product }}</strong>
            </div>
            <div class="col-lg-3 col-12">
                <p class="mb-0 title-plate">{{ translations.secondMealLabel}}</p>
                <strong class="fs-5">{{ m.second_product }}</strong>
            </div>
            <div class="col-lg-3 col-12">
                <p class="mb-0 title-plate">{{ translations.drinkLabel}}</p>
                <strong class="fs-5">{{ m.drink_product }}</strong>
            </div>
            <div class="col-lg-3 col-12 d-flex justify-content-center align-items-center">
                <InputNumber v-model="launchapack_counting" buttonLayout="horizontal" mode="decimal" showButtons :min="0" :max="m.launchpack_count" @update:modelValue="updateLaunchpacksValue">
                    <template #incrementbuttonicon><span class="pi pi-plus" style=" color: #ffffff;font-weight: bold;"/></template>
                    <template #decrementbuttonicon><span class="pi pi-minus" style=" color: #ffffff;font-weight: bold;"/></template>
                </InputNumber>
            </div>
        </div>
        <template v-else>
            <div class="row mb-3 ms-4">
                <div class="col-lg-3 col-12">
                    <p class="mb-0 title-plate">{{ translations.firstMealLabel }}</p>
                    <input class="fs-5 form-custom" v-model="m.first_product" />
                </div>
                <div class="col-lg-3 col-12">
                    <p class="mb-0 title-plate">{{ translations.secondMealLabel}}</p>
                    <input class="fs-5 form-custom" v-model="m.second_product" />
                </div>
                <div class="col-lg-3 col-12">
                    <p class="mb-0 title-plate">{{ translations.drinkLabel}}</p>
                    <input class="fs-5 form-custom" v-model="m.drink_product" />
                </div>
                <div class="col-lg-3 col-12 d-flex justify-content-center align-items-center">
                    <InputNumber v-if="m.editing" v-model="launchapack_counting" buttonLayout="horizontal" mode="decimal" showButtons :min="0" :max="m.launchpack_count" @update:modelValue="updateLaunchpacksValue">
                        <template #incrementbuttonicon><span class="pi pi-plus" style=" color: #ffffff;font-weight: bold;"/></template>
                        <template #decrementbuttonicon><span class="pi pi-minus" style=" color: #ffffff;font-weight: bold;"/></template>
                    </InputNumber>
                </div>
            </div>
            <div class="row w-100">
                <div class="col-lg-10 col-9">
                    <button type="submit" class="btn-menu btn-save" @click="saveMenu">{{ translations.saveLabel }}</button>
                </div>
                <div v-if="m.editing" class="col-lg-2 col-3">
                    <button class="btn-menu btn-delete" @click="deleteMenuItem"><i class="pi pi-trash"></i></button>
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
import { createMenu, updateMenu, deleteMenu, updateLaunchpacks } from '../../../services/menu.js';

export default {

    props: {
        menu: Object,
        translations: Object
    },
    data(){
        return {
            m: this.menu,
            launchapack_counting: 0,
            launchapack_counting_timer: null,
            launchapack_counting_debaunce_time: 1000
        }
    },
    mounted() {
        this.launchapack_counting = this.m.launchpack.length;
    },

    methods: {
        updateLaunchpacksValue(val) {
                clearTimeout(this.launchapack_counting_timer);
                this.launchapack_counting_timer = setTimeout(() => {
                    updateLaunchpacks(this.m, val).then(response => {
                        console.log(response);
                    });
                },this.launchapack_counting_debaunce_time);
        },
        cancelEditing() {
            this.m.editing = false;
        },
        deleteMenuItem() {
            console.log(this.m);
            if(this.m.editing){
                deleteMenu(this.m.id_menu).then(response => {
                    console.log(response);
                    this.$emit('deleteMenuItem', this.m);
                });
            } else {
                this.$emit('deleteMenuItem', this.m);
            }
        },  
        saveMenu(){
            console.log(this.m);
            console.log(this.m);
            if(this.m.first_product !== '' && this.m.first_product !== null &&
               this.m.second_product !== '' && this.m.second_product !== null &&
               this.m.drink_product !== '' && this.m.drink_product !== null &&
               this.m.title !== '' && this.m.title !== null) {
                if(this.m.creating) {
                    delete this.m.id;
                    createMenu(this.m)
                    .then(response => {
                        console.log(response);
                        this.m.creating = false;
                        this.m.id_menu= response.data.newId;
                        console.log(this.m);
                    })
                } else{
                    updateMenu(this.m)
                    .then(response => {
                        this.m.editing = false;
                    })
                }
            }
            else{
                console.log('Todos los campos del menu son obligatorios');
                this.$emit('showError', 'Todos los campos del menu son obligatorios');
            }
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