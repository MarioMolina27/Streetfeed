<template>
    <div class="container-fluid ps-0 pe-0">
        <Navbar :menuItems = 'menuItems' :currentLanguage = 'lang'></Navbar>
        <template v-if="loading ||!loadingFinished">
            <loader :loading = 'loading' @loading-finished="handleLoadingFinished"></loader>
        </template>
        <div v-else class="deliveries-container">
            <div class="header-accordion">
                <h1>{{translations.deliveriesLabel}}</h1>
            </div>
            <Accordion :multiple="true" :activeIndex="0" expandIcon="pi pi-angle-down" collapseIcon="pi pi-angle-up" class="custom-accordion">
                <template v-for="(riderDeliveries) in deliveriesByRiders">
                    <AccordionTab>
                        <template #header>
                            <span class="d-flex justify-content-between align-items-center gap-2 w-100">
                                <div style="padding: 10px;">
                                    <div >
                                        <div class="delivery-rider-label">{{translations.deliverLabel}}:</div>
                                        <div class="delivery-rider-info"><strong>{{ riderDeliveries[0].user.name + " " + riderDeliveries[0].user.surnames }}</strong></div>
                                    </div>
                                </div>
                                <div class="delivery-action-btns">
                                    <div class="delivery-button-chat" @click.stop="generateQRCode(riderDeliveries)">
                                        <i class="fa-solid fa-qrcode fs-3" style="color: #FDF8EB;"></i>
                                    </div>
                                    <div class="delivery-button-chat" @click.stop="showChat(riderDeliveries[0].user)">
                                        <i class="fa-solid fa-comment fs-3" style="color: #FDF8EB;"></i>
                                    </div>
                                    
                                </div>
                            </span>
                        </template>
                        <template v-for="delivery in riderDeliveries" :key="delivery.id">
                            <riderCard :delivery="delivery" :translations="translations"/>
                        </template>
                    </AccordionTab>
                </template>
            </Accordion>
            <Dialog v-model:visible="scanning" modal :closable="false" :showHeader="false" :style="{ width: '75%' }">
                <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%;">
                    <div v-if="animating" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                        <svg class="qr-animate-svg" v-if="animationConfirm" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                            <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                            <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                        </svg>
                        <svg class="qr-animate-svg" v-if="animationError" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                            <circle class="path circle" fill="none" stroke="#B52A2A" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                            <line class="path line" fill="none" stroke="#B52A2A" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/>
                            <line class="path line" fill="none" stroke="#B52A2A" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/>
                        </svg>
                    </div>
                    <div v-else style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                        <vue-qrcode v-if="scanning" :value="qrCodeData" :size="200" :scale="10" :color="{ dark: '#000000ff', light: '#ffffffff' }" :type="'image/png'" @click="handleQRCodeScan"/>
                        <span class="qr-scan-txt-info">{{translations.clickOnQRLabel}}</span>
                    </div>
                </div>
                <div class="qr-deliver-centered-buttons">
                    <button class="deliver-qr-btn" @click="doDeliver">{{translations.deliverWithoutQRLabel}}</button>
                    <button class="cncl-deliver-qr-btn" @click="scanning = false">{{translations.closeLabel}}</button>
                </div>
            </Dialog>
        </div>
        <Dialog v-model:visible="showChatDialog" modal class="dialog-responsive">
            <Chat :user="userChat" :loggedUser="user.id_user" :lang="lang"/>
        </Dialog>
    </div>
</template>
  
<script >
import Navbar from '../../shared/Navbar.vue';
import loader from '../../shared/loader.vue';
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
import VueQrcode from 'vue-qrcode';
import Dialog from 'primevue/dialog';
import Chat from '../../shared/chat/chat.vue';;
import riderCard from './riderCard.vue';
import {menuTabs} from '../../../utilities/menuTabs.js';
export default{
    props: {
        user: Object,
        lang: String,
        type_user: Array
    },
    data(){
        return {
            menuItems: [],
            loading: true,
            loadingFinished: false,
            deliveriesByRiders: [],
            qrCodeData: '',
            scanning: false,
            animating: false,
            animationError: false,
            animationConfirm: false,
            showChatDialog: false,
            userChat: {},
            translations: {}
        }
    },
    created() {
        import(`../../../../lang/providers/${this.lang}.json`)
                .then(module => {
                    this.translations = module.default;
                    console.log(this.translations);
                })
                .catch(error => {
                    console.error(`Error al importar el archivo de idioma: ${error}`);
                });
    },
    mounted() {
        this.menuItems = menuTabs(this.type_user);
        this.getAllDelivriesByRider();
    },
    methods: {
        getAllDelivriesByRider() {
            axios.get(`api/delivery/get-provider-deliveries/${this.user.id_user}`)
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
        },
        generateQRCode(riderDeliveries) {
            this.scanning = true;
            const ids = riderDeliveries.map(delivery => delivery.id).join(',');
            this.qrCodeData = ids;
        },
        handleQRCodeScan() {
            this.scanning = false;
            this.getAllDelivriesByRider();
        },
        doDeliver() {
            const deliveriesIds = this.qrCodeData.split(',');
            axios.post('api/delivery/do-collect', {
                deliveryIds: deliveriesIds
            })
            .then(response => {
                if (response.status == 200) {
                    this.animateConfirm();
                } else {
                    this.animateError();
                }
                setTimeout(() => {
                    this.stopAnimation();
                    if (response.status == 200) {  
                        this.scanning = false;
                    }
                    this.notifyToCloseFrame(true);
                }, 2000);
            })
            .catch(error => {
                this.animateError();
                setTimeout(() => {
                    this.stopAnimation();
                }, 2000);
            });
        },
        animateConfirm() {
            this.animating = true;
            this.animationConfirm = true;
        },
        animateError() {
            this.animating = true;
            this.animationError = true;
        },
        stopAnimation() {
            this.animating = false;
            this.animationConfirm = false;
            this.animationError = false;
        },
        showChat(user) {
            this.userChat = user;
            this.showChatDialog = true;
        }
    },
    components: {
        Navbar,
        loader,
        Accordion,
        AccordionTab,
        VueQrcode,
        Dialog,
        Chat,
        riderCard
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

.deliveries-container > .p-accordion .p-accordion-tab{
    margin-bottom: 30px;
}

.deliveries-container > .p-accordion .p-accordion-tab {
    border-radius: 6px !important;
    background-color: #FDF8EB !important;
    outline: 2px solid #b17a3b;
}
.deliveries-container > .p-accordion .p-accordion-header:not(.p-disabled) .p-accordion-header-link:focus-visible {
    outline: none !important;
}
.deliveries-container > .p-accordion .p-accordion-header .p-accordion-header-link {
    border-top-right-radius: 6px !important;
    border-top-left-radius: 6px !important;
    border-bottom-left-radius: 0px !important;
    border-bottom-right-radius: 0px !important;
    background-color: #FDF8EB !important;
}
.deliveries-container > .p-accordion .p-accordion-content {
    background-color: #FDF8EB !important;
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
    width: 55px;
    height: 55px;
    background-color: #984EAE;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: 0.3s ease;
}
.delivery-button-chat:hover {
    background-color: #642777;
    transform: scale(1.05);
}

.qr-scan-txt-info {
    font-size: 1.5rem;
    color: #08173390;
    margin-bottom: 20px;
    text-align: center;
}
.qr-deliver-centered-buttons {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
}
.qr-deliver-centered-buttons > button {
    padding: 10px;
    border: none;
    border-radius: 6px;
    color: #FDF8EB;
    cursor: pointer;
    transition: transform 0.3s ease;
}
.qr-deliver-centered-buttons > button:hover {
    transform: scale(1.05);
}
.qr-deliver-centered-buttons > .deliver-qr-btn {
    background-color: #984EAE;
    color: #FDF8EB;
}
.qr-deliver-centered-buttons > .cncl-deliver-qr-btn {
    background-color: #858585;
    color: #FDF8EB;
}

.qr-animate-svg {
    width: 250px;
    display: block;
    margin: 15vh auto 100px;
}
.path {
    stroke-dasharray: 1000;
    stroke-dashoffset: 0;
    &.circle {
        -webkit-animation: dash .9s ease-in-out;
        animation: dash .9s ease-in-out;
    }
    &.line {
        stroke-dashoffset: 1000;
        -webkit-animation: dash .9s .35s ease-in-out forwards;
        animation: dash .9s .35s ease-in-out forwards;
    }
    &.check {
        stroke-dashoffset: -100;
        -webkit-animation: dash-check .9s .35s ease-in-out forwards;
        animation: dash-check .9s .35s ease-in-out forwards;
    }
}
@-webkit-keyframes dash {
    0% {
        stroke-dashoffset: 1000;
    }
    100% {
        stroke-dashoffset: 0;
    }
}
@keyframes dash {
    0% {
        stroke-dashoffset: 1000;
    }
    100% {
        stroke-dashoffset: 0;
    }
}
@-webkit-keyframes dash-check {
    0% {
        stroke-dashoffset: -100;
    }
    100% {
        stroke-dashoffset: 900;
    }
}
@keyframes dash-check {
    0% {
        stroke-dashoffset: -100;
    }
    100% {
        stroke-dashoffset: 900;
    }
}
.dialog-responsive {
  max-width: 90%;
  width: 90%;
}
.dialog-responsive > .p-dialog-header {
    justify-content: end;
}
</style>