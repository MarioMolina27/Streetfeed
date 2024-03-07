<template>
    <div class="homeless-information">
        <div class="d-flex flex-column">
            <span>Ubicación</span>
            <strong>{{ information.location }}</strong>
        </div>
        <div class="d-flex flex-column justify-content-center">
            <i class="pi pi-user" style="font-size: 2rem;"></i>
            <strong style="text-align: center; color: #984EAE;">{{ information.people_eat }}</strong>
        </div>
    </div>
</template>

<script>
export default{
    props: {
      information: Object
    },
}
</script>

<style scoped>

</style>