<template>
    <div class="container-fluid ps-0 pe-0">
        <Navbar :menuItems = 'menuItems'></Navbar>
        <h1>MENUS</h1>
    </div>
</template>
  
<script >
import Navbar from '../../shared/Navbar.vue';
export default{
    data(){
        return {
            menuItems: [
                {name: 'Repartos', href: './managedelivery'},
                {name: 'Tus Menus', href: './menu'},
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