<template>
    <div class="container-fluid ps-0 pe-0">
        <Navbar :menuItems = 'menuItems'></Navbar>
        <h1>REPARTOS</h1>
    </div>
</template>
  
<script >
import Navbar from '../../shared/Navbar.vue';
export default{
    data(){
        return {
            menuItems: [
                {name: 'Tus Menus', href: './menu'},
                {name: 'Repartos', href: './managedelivery'},
                {name: 'Perfil', href: './profile'}
            ]
        }
    },
    mounted() {
        
    },
    methods: {
        
    },
    components: {
        Navbar
    },
}
</script>
  
<style scoped>
    
</style>