<template>
    <h1>{{email}}</h1>
    <h2>{{ nickname }}</h2>
    <Calendar id="calendar-timeonly" v-model="time" timeOnly />

</template>

<script>
import Calendar from 'primevue/calendar';
export default {
    props: {
        nickname: String
    },
    data() {
        return {
            email: 'hola',
            password: '',
            errors: []
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        login() {
            console.log('login');
        }
    },
    components: {
        Calendar
    }
}
</script>

<style>
 .p-inputtext:hover {
    border-color: blue;
 }
</style>