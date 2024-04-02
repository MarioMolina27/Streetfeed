<template>
<h1>AAA</h1>
</template>

<script>
export default {
    props: {
        provider: {
            information: Object
        }
    },
    data() {
        return {
            active: false
        }
    },
    methods: {
        toggleActive() {
            this.active = !this.active;
        }
    },
    mounted() {
        console.log(this.information);
    }
}
</script>

<style>

</style>