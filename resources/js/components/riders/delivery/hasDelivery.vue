<template>
    <div class="switches-container">
        <input type="radio" id="switchList" name="switchPlan" value="List" v-model="selectedOption"/>
        <input type="radio" id="switchMap" name="switchPlan" value="Map" v-model="selectedOption"/>
        <label for="switchList" :class="{ 'switch-option': true, 'notSelected': selectedOption === 'Map' }">{{ translations.listLabel }}</label>
        <label for="switchMap" :class="{ 'switch-option': true, 'notSelected': selectedOption === 'List' }">{{ translations.routeLabel }}</label>
        <div class="switch-wrapper">
        <div class="switch">
            <div>{{ translations.listLabel }}</div>
            <div>{{ translations.routeLabel }}</div>
        </div>
        </div>
    </div>
    <mapDelivery v-if="selectedOption === 'Map'" :deliveries="asosiationDelivery" :translations="translations" @isChanging="emitIsChanging" @notifyDeliver="notifyDeliver"></mapDelivery>
    <listDelivery v-else :deliveries="asosiationDelivery" :lang="lang" :translations="translations" :user = "user" @isChanging="emitIsChanging" @notifyDeliver="notifyDeliver"></listDelivery>
</template>

<script>
import mapDelivery from './mapDelivery.vue';
import listDelivery from './listDelivery.vue';
export default {
    props: {
        asosiationDelivery: Object,
        lang: String,
        translations: Object,
        user: Object
    },
    data(){
        return {
            selectedOption: 'List',
            delivery: {}
        }
    },
    mounted(){
    },
    methods: {
        emitIsChanging(deliveryIds) {
            this.$emit('isChanging', deliveryIds);
        },
        notifyDeliver(deliveryId) {
            this.$emit('notifyDeliver', deliveryId);
        },
    },
    emits: ['isChanging', 'notifyDeliver'],
    components: {
        mapDelivery,
        listDelivery
    }
}
</script>

<style scoped>
    .delivery-container {
        padding-inline: 0;
    }
    /*SWITCH STYLES*/
    .switches-container {
        width: 90%;
        position: relative;
        display: flex;
        padding: 0;
        background: #FDF8EB;
        border: 2px solid #081733;
        line-height: 3rem;
        border-radius: 0.5rem;
        margin-left: auto;
        margin-right: auto;
        z-index: 1;
    }

    .switches-container input {
        visibility: hidden;
        position: absolute;
        top: 0;
    }

    .switches-container label {
        width: 50%;
        padding: 0;
        margin: 0;
        text-align: center;
        cursor: pointer;
        color: #FDF8EB;
        font-size: 1.15rem;
        font-weight: bold;
    }

    .switch-wrapper {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 50%;
        padding: 0.1rem;
        z-index: 3;
        transition: transform 0.5s cubic-bezier(0.77, 0, 0.175, 1);
    }

    .switch {
        border-radius: 0.5rem;
        background: #081733;
        height: 100%;
    }

    .switch div {
        width: 100%;
        text-align: center;
        opacity: 0;
        display: block;
        color: #FDF8EB;
        font-size: 1.15rem;
        font-weight: bold;
        transition: opacity 0.2s cubic-bezier(0.77, 0, 0.175, 1) 0.125s;
        will-change: opacity;
        position: absolute;
        top: 0;
        left: 0;
    }
    .notSelected {
        color: #081733 !important;
    }
    .switches-container input:nth-of-type(1):checked~.switch-wrapper {
        transform: translateX(0%);
    }

    .switches-container input:nth-of-type(2):checked~.switch-wrapper {
        transform: translateX(100%);
    }

    .switches-container input:nth-of-type(1):checked~.switch-wrapper .switch div:nth-of-type(1) {
        opacity: 1;
    }

    .switches-container input:nth-of-type(2):checked~.switch-wrapper .switch div:nth-of-type(2) {
        opacity: 1;
    }
    /*END SWITCH STYLES*/

</style>