<template>
    <div class="homeless-information">
        <div class="d-flex flex-column">
            <span>Ubicación</span>
            <strong class="two-line-ellipsis">{{ information.data.location }}</strong>
        </div>
        <div class="d-flex gap">
            <div class="d-flex flex-column justify-content-center me-5">
                <i class="pi pi-user" style="font-size: 2rem;"></i>
                <strong style="text-align: center; color: #984EAE;">{{ information.data.people_eat }}</strong>
            </div>
            <div class="d-flex flex-column justify-content-center ms-3">
                <i class="fa-solid fa-xmark fa-xl" style="color: #B52A2A; cursor: pointer; transition: transform 0.3s;" @click="handleRemoveMarker(information.data.id_marker, information.data.people_eat)"></i>
            </div>
        </div>
        
    </div>
</template>

<script>
export default{
    props: {
      information: Object
    },
    data() {
        return {
        }
    },
    mounted() {

    },
    methods: {
        handleRemoveMarker(id, peopleEat) {
            this.$emit('marker-removed', { id, peopleEat });
        }
    }
}
</script>

<style>
    .two-line-ellipsis {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .fa-xmark:hover {
        transform: scale(1.1);
    }
</style>