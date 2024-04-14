import './bootstrap';
import 'primevue/resources/themes/aura-light-green/theme.css'
import * as bootstrap from 'bootstrap';
import { createApp } from 'vue';
import PrimeVue from 'primevue/config';
import panelUser from './components/admin/users/panelUser.vue';
import panelMenu from './components/providers/manageMenu/panelMenu.vue';
import manageDelivery from './components/providers/manageDelivery/manageDelivery.vue';
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
import panelDelivery from './components/riders/delivery/panelDelivery.vue';
import profile from './components/shared/profile/profile.vue';
import Tooltip from 'primevue/tooltip';
import ToastService from 'primevue/toastservice';



const app = createApp({}).use(PrimeVue).use(ConfirmationService).use(ToastService);
const appDOM = document.getElementById('app');

app.component('paneluser', panelUser)
app.component('panelmenu', panelMenu)
app.component('managedelivery', manageDelivery)
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
app.component('paneldelivery', panelDelivery)
app.component('profile', profile)
app.directive('tooltip', Tooltip);


app.mount(appDOM);