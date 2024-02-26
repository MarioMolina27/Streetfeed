import './bootstrap';
import { createApp } from 'vue';
import PrimeVue from 'primevue/config';
import panelUser from './components/admin/panelUser.vue';

const app = createApp({});
app.use(PrimeVue);
app
    .component('panelUser', panelUser)

app.mount('#app');