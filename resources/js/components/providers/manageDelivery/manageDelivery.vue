<template>
    <div class="container-fluid ps-0 pe-0">
        <Navbar :menuItems = 'menuItems'></Navbar>
        <template v-if="loading ||!loadingFinished">
            <loader :loading = 'loading' @loading-finished="handleLoadingFinished"></loader>
        </template>
        <div v-else class="deliveries-container">
            <Accordion :multiple="true" :activeIndex="0" expandIcon="pi pi-angle-down" collapseIcon="pi pi-angle-up" class="custom-accordion">
                <template v-for="(riderDeliveries, riderId) in deliveriesByRiders" :key="riderId">
                    <AccordionTab>
                        <template #header>
                            <span class="d-flex justify-content-between align-items-center gap-2 w-100">
                                <div style="padding: 10px;">
                                    <div >
                                        <div class="delivery-rider-label">Repartidor:</div>
                                        <div class="delivery-rider-info"><strong>{{ riderDeliveries[0].user.name + " " + riderDeliveries[0].user.surnames }}</strong></div>
                                    </div>
                                </div>
                                <div class="delivery-action-btns">
                                    <div class="delivery-button-chat">
                                        <i class="fa-solid fa-qrcode" style="color: #FDF8EB;"></i>
                                    </div>
                                    <div class="delivery-button-chat">
                                        <i class="fa-solid fa-comment" style="color: #FDF8EB;"></i>
                                    </div>
                                </div>
                            </span>
                        </template>
                        <template v-for="delivery in riderDeliveries" :key="delivery.id">
                            <div class="delivery-rider-card">
                                <h3>Reparto: {{ delivery.id }}</h3>
                            </div>
                        </template>
                    </AccordionTab>
                </template>
            </Accordion>
        </div>
    </div>
</template>
  
<script >
import Navbar from '../../shared/Navbar.vue';
import loader from '../../shared/loader.vue';
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
export default{
    data(){
        return {
            menuItems: [
                {name: 'Repartos', href: './managedelivery'},
                {name: 'Tus Menus', href: './menu'},
                {name: 'Perfil', href: './profile'}
            ],
            loading: true,
            loadingFinished: false,
            deliveriesByRiders: []
        }
    },
    mounted() {
        this.getAllDelivriesByRider();
    },
    methods: {
        getAllDelivriesByRider() {
            axios.get('api/delivery/get-provider-deliveries/9')
            .then(response => {
                console.log(response.data);
                this.deliveriesByRiders = response.data;
                this.loading = false;
            })
            .catch(error => {
                console.log(error);
                this.loading = false;
            });
        },
        handleLoadingFinished() {
           this.loadingFinished = true;
      }
    },
    components: {
        Navbar,
        loader,
        Accordion,
        AccordionTab
    },
}
</script>
  
<style>
.deliveries-container {
    padding-top: 10px;
    width: 95%;
    margin: 0 auto;
}
.deliveries-container > .p-accordion .p-accordion-header .p-accordion-header-link .p-accordion-toggle-icon {
    transform: rotate(0deg);
}
.deliveries-container > .header-accordion {
    display: flex;
    justify-content: center;
    padding: 10px
}

.custom-accordion {
    margin-bottom: 20px;
}

.delivery-rider-card {
    border: #b17a3b 1px solid;
    border-radius: 10px;
    padding: 10px;
    
}

.deliveries-container > .p-accordion .p-accordion-tab{
    margin-bottom: 10px;
}

.deliveries-container > .p-accordion .p-accordion-tab {
    border-radius: 20px !important;
    background-color: #ffffff !important;
}

.deliveries-container > .p-accordion .p-accordion-header .p-accordion-header-link {
    border-top-right-radius: 6px !important;
    border-top-left-radius: 6px !important;
    border-bottom-left-radius: 0px !important;
    border-bottom-right-radius: 0px !important;
}

.delivery-rider-label{
    font-size: 1.5rem;
    color: #08173390;
}
.delivery-rider-info {
    font-size: 2rem;
}
.delivery-action-btns {
    margin: 10px;
    margin-right: 20px;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-self: center;
    gap: 10px;
}
.delivery-button-chat {
    width: 40px;
    height: 40px;
    background-color: #B48753;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: 0.3s ease;
}
.delivery-button-chat:hover {
    background-color: #b17a3b;
    transform: scale(1.05);
    }
</style>