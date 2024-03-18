<template>
    <div class="mt-5">
        <Card>
            <template #content>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <h3 class="mb-0 label-name-user">{{user.name}}</h3>
                        <Tag>Rider</Tag>
                    </div>
                    <img src="img/edit-profile.svg" alt="Card" height="35" />
                </div>
                <p>{{user.username}}</p>
                <p class="label-card-profile">Email</p>
                <p>{{user.email}}</p>
                <p class="label-card-profile">Direcciones</p>
                <p v-for="direction in directions" :key="direction">{{direction}}</p>
            </template>
        </Card>
    </div>
</template>

<script>
import Card from 'primevue/card';
import Tag from 'primevue/tag';
import Tooltip from 'primevue/tooltip';


export default {
    components: {
        Card,
        Tag,
        Tooltip
    },

    data(){
        return{
            user: {
                name: 'Pol Crespo',
                username: '@pcrespo',
                email: 'pcrespo@politecnics.barcelona',
            },

            directions: [
                'Pl. d\'Urquinaona, 10, Ciutat Vella, 08010 Barcelona',
            ]
        }
    }
}
</script>

<style scoped>

.p-card{
    border: 1.5px solid #b48753;
}

.label-card-profile{
    margin: 0;
    color: #081733;
    opacity: 0.7;
}

.label-name-user{
    font-weight: 600;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}
.p-tag{
    background-color: #081733;
    color: white;
    margin-left: 15px;
    padding: 5px 15px;
}

@media screen and (max-width: 768px) { /* Define estilos específicos para pantallas pequeñas */
    .label-name-user {
        max-width: 150px; /* Define el ancho máximo del label */
    }
}
</style>