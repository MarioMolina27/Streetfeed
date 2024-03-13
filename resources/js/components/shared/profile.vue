<template>
    <div class="container-fluid ps-0 pe-0">
        <Navbar :menuItems = 'menuItems'></Navbar>
        <div class="delivery-container">
            <h1>Profile</h1>
        </div>
    </div>
    </template>
    
    <script>
    import Navbar from '../shared/Navbar.vue';
    export default{
        data(){
          return {
            menuItems: [
                    {name: 'Tus Repartos', href: './delivery'},
                    {name: 'Explorar', href: './explore'},
                    {name: 'Favoritos', href: './favorite'},
                    {name: 'Perfil', href: './profile'}
                ]
          }
        },
        components: {
            Navbar
        }
    }
    </script>
    
    <style scoped>
    
    </style>