<template>
    <div>
        <Dialog v-model:visible="visible" modal header="Cambiar Contraseña" style="width: 90%;">
            <div v-if="error" class="d-flex justify-content-center align-items-center error-container">
                <i class="pi pi-exclamation-circle"></i>
                <span class="ms-3">{{ error }}</span>
            </div>
            <div class="flex flex-column gap-2 mb-4">
                <div>
                    <label for="oldpassword" class="me-2">Contraseña antigua</label>
                    <i class="pi pi-question-circle" v-tooltip="'Aqui tienes que introducir tu contraseña actual'"></i>
                </div>
                <InputText id="oldpassword" name="oldPassword" v-model="oldPassword" aria-describedby="oldpassword-help" />
            </div>
            <div class="flex flex-column gap-2 mb-2">
                <div>
                    <label for="newpassword" class="me-2">Nueva contraseña</label>
                    <i class="pi pi-question-circle" v-tooltip="'Aqui tienes que introducir la nueva contraseña'"></i>
                </div>
                <InputText name="newPassword" id="newpassword" v-model="newPassword" aria-describedby="newpassword-help" />
            </div>
            <div class="flex flex-column gap-2 mb-3">
                <div>
                    <label for="newpassword2" class="me-2">Repite la nueva contraseña</label>
                    <i class="pi pi-question-circle" v-tooltip="'Aqui tienes que  volver a introducir la nueva contraseña'"></i>
                </div>                 
                <InputText id="newpassword2" name="newPassword2" v-model="newPassword2" aria-describedby="newpassword2-help" />
            </div>
            <Button label="Guardar" class="p-button mt-2" @click="savePassword()" />
        </Dialog>
    </div>
</template>

<script>
import Dialog from 'primevue/dialog';
import IconField from 'primevue/iconfield';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import { changePassword } from '../../../services/users.js';



export default {
    components: {
        Dialog,
        IconField,
        InputText,
        Button,
    },
    props: {
        modalVisible: {
            type: Boolean,
            default: false,
        },
        user: {
            type: Object,
            default: () => ({}),
        }
    },

    data() {
        return {
            visible: false,
            oldPassword: '',
            newPassword: '',
            newPassword2: '',
            error: ''
        };
    },

    
    watch: {
        modalVisible(newVal) {
            this.visible = newVal;
        },

        visible(newVal) {
            if(!newVal) {
                this.$emit('closeModal');
            }
        },

    },

    methods: {
        savePassword() {
            changePassword(this.user.id_user, this.oldPassword, this.newPassword, this.newPassword2)
                .then((response) => {
                    if(response.data) {
                        this.$emit('closeModal');
                    } else {
                        this.error = 'Error al cambiar la contraseña';
                    }
                })
                .catch((error) => {
                    console.log(error);
                });

        }
    },

};
</script>


<style scoped>
.map-container-dialog {
    height: 400px;
    width: 100%;
    position: relative;
}

.error-container {
    background-color: #f2d6d6;
    color: #B52A2A;
    border-radius: 6px;
    padding: 10px;
    margin-bottom: 15px;
}

.p-button {
    width: 100%;
    border: none;
    background-color: #984eae;
}

.mapbox-autofilll-results{
    position: absolute;
    z-index: 3;
    background-color: white;
    width: 100%;
    border-radius: 5px;
    box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.2);
}

li {
    padding: 10px;
    cursor: pointer;
    list-style: none;
    margin: 10px;
    display: flex;
    justify-content: start;
    align-items: center;
}

li:hover {
    background-color: #f2f2f2;
}

.p-inputtext {
    width: 100%;
}


</style>
