<template>
    <div class="list-container">
        <template v-for="delivery in deliveries">
            <providerCard :delivery="delivery"></providerCard>
        </template>
    </div>
</template>

<script>
import providerCard from './providerCard.vue';
export default {
    props: {
        deliveries: Object
    },
    components: {
        providerCard
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