<template>
    <div>
        <Dialog v-model:visible="visible" modal header="Cambiar Contraseña" style="width: 90%;">
            <div class="flex flex-column gap-2 mb-3">
                <label for="oldpassword">Contraseña antigua</label>
                <InputText id="oldpassword" name="oldPassword" v-model="oldPassword" aria-describedby="oldpassword-help" />
                <small id="oldpassword-help">Introduce tu antigua contraseña</small>
            </div>
            <div class="flex flex-column gap-2 mb-3">
                <label for="newpassword">Nueva contraseña</label>
                <InputText name="newPassword"id="newpassword" v-model="newPassword" aria-describedby="newpassword-help" />
                <small id="newpassword-help">Introduce la nueva contraseña</small>
            </div>
            <div class="flex flex-column gap-2 mb-3">
                <label for="newpassword2">Repite la nueva contraseña</label>
                <InputText id="newpassword2" name="newPassword2" v-model="newPassword2" aria-describedby="newpassword2-help" />
                <small id="newpassword2-help">Reptie correctamente tu nueva contraseña</small>
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
                        let data = response.response.data;
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
