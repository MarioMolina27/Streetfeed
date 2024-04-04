import { createApp } from 'vue';

import landing from './components/landing/landing.vue'; 

const app = createApp({});
const appDOM = document.getElementById('app');

app.component('landing', landing)

app.mount(appDOM);