<template>
    <div class="list-container">
        <template v-for="delivery in deliveries">
            <providerCard :delivery="delivery" @collectDelivery="doCollect"></providerCard>
            <div v-if="isScanning" class="scanner-container">
                <qrScanner :deliveryIds="deliveryIds" @closeFrame="closeFrame"></qrScanner>
            </div>
        </template>
    </div>
</template>

<script>
import providerCard from './providerCard.vue';
import qrScanner from './qrScanner.vue';
export default {
    props: {
        deliveries: Object,
    },
    data(){
        return {
            isScanning: false,
            deliveryIds: []
        }
    },
    methods: {
        doCollect(deliveryIds) {
            window.scrollTo(0, 0);
            this.isScanning = true;
            this.deliveryIds = deliveryIds;
            
        },
        closeFrame(isChanging) {
            this.isScanning = false;
            if (isChanging) {
                this.$emit('isChanging');
            }
        }
    },
    components: {
        providerCard,
        qrScanner
    }
}
</script>

<style scoped>
    .list-container {
        display: flex;
        flex-direction: column;
        width: 100%;
        height: calc(100vh - 10vh);
        position: relative;
    }
    .scanner-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
    }
</style>