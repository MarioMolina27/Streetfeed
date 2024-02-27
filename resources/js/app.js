import './bootstrap';
import * as bootstrap from 'bootstrap';
import { createApp } from 'vue';
import PrimeVue from 'primevue/config';
import navMenu from './components/shared/nav.vue';
import panelUser from './components/admin/panelUser.vue';
import panelMenu from './components/providers/panelMenu.vue';
import panelDelivery from './components/riders/panelDelivery.vue';
import 'primevue/resources/themes/aura-light-green/theme.css'


const app = createApp({});
app.use(PrimeVue, {
});
const appDOM = document.getElementById('app');

app.component('navmenu', navMenu)
app.component('paneluser', panelUser)
app.component('panelmenu', panelMenu)
app.component('paneldelivery', panelDelivery)

app.mount(appDOM);