<template>
    <div class="list-container">
        <template v-for="(delivery) in deliveries">
            <deliveryCard :delivery = delivery></deliveryCard>
        </template>
    </div>
</template>

<script>
import deliveryCard from './deliveryCard.vue';
export default {
    props: {
        deliveries: Object
    },
    components: {
        deliveryCard
    }
}
</script>

<style scoped>
    .list-container {
        display: flex;
        flex-direction: column;
        width: 100%;
        height: calc(100vh - 10vh);
    }

</style>