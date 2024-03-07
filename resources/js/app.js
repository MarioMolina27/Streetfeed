import './bootstrap';
import 'primevue/resources/themes/aura-light-green/theme.css'
import * as bootstrap from 'bootstrap';
import { createApp } from 'vue';
import PrimeVue from 'primevue/config';

import panelUser from './components/admin/panelUser.vue';
import panelMenu from './components/providers/panelMenu.vue';
import panelDelivery from './components/riders/explore/panelDelivery.vue';
import providerDetails from './components/riders/reserve/providerDetails.vue';
import assignLocation from './components/riders/reserve/assignLocation.vue';
import ConfirmationService from 'primevue/confirmationservice';



const app = createApp({}).use(PrimeVue).use(ConfirmationService);
const appDOM = document.getElementById('app');

app.component('paneluser', panelUser)
app.component('panelmenu', panelMenu)
app.component('paneldelivery', panelDelivery)
app.component('providerdetails', providerDetails)
app.component('assignlocation', assignLocation)


app.mount(appDOM);