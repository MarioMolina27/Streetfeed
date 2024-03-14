import './bootstrap';
import 'primevue/resources/themes/aura-light-green/theme.css'
import * as bootstrap from 'bootstrap';
import { createApp } from 'vue';
import PrimeVue from 'primevue/config';
import panelUser from './components/admin/users/panelUser.vue';
import panelMenu from './components/providers/panelMenu.vue';
import panelExplore from './components/riders/explore/panelExplore.vue';
import providerDetails from './components/riders/reserve/providerDetails.vue';
import assignLocation from './components/riders/reserve/assignLocation.vue';
import adminHome from './components/admin/home/adminHome.vue';
import providerStats from './components/admin/stats/providerStats.vue';
import riderStats from './components/admin/stats/riderStats.vue';
import mapAdmin from './components/admin/map/mapAdmin.vue';
import ConfirmationService from 'primevue/confirmationservice';
import reserveConfirmation from './components/riders/reserve/reserveConfirmation.vue';
import panelFavorite from './components/riders/explore/panelFavorite.vue';
import login from './components/auth/login.vue';
import delivery from './components/riders/delivery/delivery.vue';
import profile from './components/shared/profile.vue';

const app = createApp({}).use(PrimeVue).use(ConfirmationService);
const appDOM = document.getElementById('app');

app.component('paneluser', panelUser)
app.component('panelmenu', panelMenu)
app.component('panelexplore', panelExplore)
app.component('providerdetails', providerDetails)
app.component('assignlocation', assignLocation)
app.component('adminhome', adminHome)
app.component('providerstats', providerStats)
app.component('riderstats', riderStats)
app.component('reserveconfirmation', reserveConfirmation)
app.component('panelfavorite', panelFavorite)
app.component('login', login)
app.component('mapadmin', mapAdmin)
app.component('delivery', delivery)
app.component('profile', profile)

app.mount(appDOM);