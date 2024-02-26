import './bootstrap';
import { createApp } from 'vue';
import PrimeVue from 'primevue/config';
import panelUser from './components/admin/panelUser.vue';

const app = createApp({});

const appDOM = document.getElementById('app');

app.component('panel-user', panelUser)

app.mount(appDOM);