<template>
<dialogMap :selectedDirection="this.selectedDirection" :modalVisible="this.modalVisible" :translations="translations" @closeModal="closeModal" @addDirection="addDirection"></dialogMap>
    <div class="mt-5">
        <Card>
            <template #content>
                <form @submit="handleSubmit">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <h3 class="mb-0 label-name-user">{{user.name}}</h3>
                            <template v-if="type_user.length===1" v-for="(ts, index) in type_user" :key="ts.name">
                                <div :class="{'ms-3 d-flex align-items-center justify-content-center' : index == 0}">
                                    <Tag>
                                        {{ ts.name }}
                                    </Tag> 
                                </div>
                            </template>                       
                        </div>
                        <img v-if="!editingProfile" src="img/edit-profile.svg" alt="edit-profile-button" height="35" @click="editingProfile=true" />
                        <div v-else class="d-flex flex-row-reverse" >
                            <button type="submit" class="ms-2" style="background-color: transparent; border: none;">
                                <i class="fa fa-check save-button"></i>
                            </button>
                            <div @click="cancelEditing()">
                                <i class="fa fa-xmark save-button"></i>
                            </div>
                        </div>
                    </div>
                    <p class="me-3">{{user.username}}</p>
                    <template v-if="type_user.length>1" v-for="(ts, index) in type_user" :key="ts.name">
                        <Tag class="mb-3">
                            {{ ts.name }}
                        </Tag> 
                    </template>
                    
                    <div v-if="!editingProfile">
                        <p class="label-card-profile">{{translations.emailLabel}}</p>
                        <p>{{user.email}}</p>
                        <p class="label-card-profile">{{translations.directionLabel}}</p>
                        <p v-for="direction in directions" :key="direction">{{direction.full_address}}</p>
                    </div>
                    <div v-else class="mb-4">
                        <p class="label-card-profile">{{translations.emailLabel}}</p>
                        <input type="text" class="form-custom" v-model="user.email">
                        <p class="label-card-profile">{{translations.directionLabel}}</p>
                        <template v-if="this.directions.length > 0">
                            <div v-for="(direction, index) in directions" :key="direction.id" class="d-flex flex-row" v-i>
                                <input type="text" class="form-custom form-direction" disabled v-model="direction.full_address">
                                <div class="d-flex justify-content-center align-items-center delete-shift-btn" @click="deleteDirection(index)"><i class="fa fa-trash"></i></div>
                            </div>
                        </template>
                        <div @click="openModal({})" class="d-flex justify-content-center align-items-center add-shift-btn mt-3" style="margin-left: 0;"><i class="fa fa-add"></i></div>
                    </div>

                    <div v-if="userIsProvider" class=" mb-2">
                        <Accordion class="w-100" @tab-open="displayShifts=true" @tab-close="displayShifts=false">
                            <AccordionTab>
                                <template #header>
                                    <div class="d-flex flex-row align-items-center">
                                        <p class="mb-0 title-schedules-profile">
                                            {{translations.scheduleLabel}}
                                        </p>
                                        <i v-if="!displayShifts" class="pi pi-eye ms-3 eye-schedule"></i>
                                        <i v-else class="pi pi-eye-slash ms-3 eye-schedule"></i>
                                    </div>
                                </template>
                                <template v-for="(day, index) in daysOfWeek" :key="index">
                                    <div class="row mt-3 d-flex align-items-center justify-content-center">
                                            <div class="col-lg-4 col-12 d-flex flex-row align-items-center">
                                                <i class="fa-regular fa-clock img-profile-stats" alt="img-first-category-game"></i>
                                                <p class="text-profile-schedule mb-0">{{ day }}</p>
                                            </div>
                                            <div class="col-lg-7 col-12 d-flex flex-row ms-4 justify-content-center">
                                                <template v-if="editingProfile">
                                                    <div class="d-flex flex-column gap-2">
                                                        <template v-for="(shift, shiftIndex) in getNumberShifts(index + 1)">
                                                            <div class="d-flex flex-row">
                                                                <Calendar :id="'calendar-timeonly-' + index + '-morning'" v-model="getShift(index + 1, shift).start_time" class="ms-2" timeOnly />
                                                                <Calendar :id="'calendar-timeonly-' + index + '-afternoon'" v-model="getShift(index + 1, shift).finish_time" class="ms-2" timeOnly />
                                                                <div class="d-flex justify-content-center align-items-center delete-shift-btn" @click="deleteShift(index + 1, shift)"><i class="fa fa-trash"></i></div>
                                                                <div v-if="shiftIndex === getNumberShifts(index + 1) - 1 && getNumberShifts(index + 1) === 1" @click="addShift(index+1,2)" class="d-flex justify-content-center align-items-center add-shift-btn"><i class="fa fa-add"></i></div>
                                                            </div>
                                                        </template>
                                                        <div v-if=" getNumberShifts(index + 1) === 0" @click="addShift(index+1,1)" class="d-flex justify-content-center align-items-center add-shift-btn-0-items"><i class="fa fa-add"></i></div>
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    <div class="d-flex flex-column gap-2">
                                                        <template v-for="shift in getNumberShifts(index + 1)">
                                                            <div class="d-flex flex-row">
                                                                <Calendar disabled :id="'calendar-timeonly-' + index + '-morning'" v-model="getShift(index + 1, shift).start_time" class="ms-2" timeOnly />
                                                                <Calendar disabled :id="'calendar-timeonly-' + index + '-afternoon'" v-model="getShift(index + 1, shift).finish_time" class="ms-2" timeOnly />
                                                            </div>
                                                        </template>
                                                    </div>
                                                </template>
                                            </div>
                                    </div>
                                    <div v-if="index !== daysOfWeek.length - 1" class="divider-schedule"/>
                                </template>
                            </AccordionTab>
                        </Accordion>
                    </div>
                </form>
            </template>
        </Card>
    </div>
</template>

<script>
import Card from 'primevue/card';
import Tag from 'primevue/tag';
import Tooltip from 'primevue/tooltip';
import Calendar from 'primevue/calendar';
import Accordion from "primevue/accordion";
import AccordionTab from "primevue/accordiontab";
import dialogMap from './dialogMap.vue';
import { updateUserData } from '../../../services/users.js';

export default {
    props: {
        user: {
            type: Object,
            required: true
        },
        schedules: {
            type: Array,
            required: true
        },
        adress: {
            type: Array,
            required: true
        },
        roadTypes: {
            type: Array,
            required: true
        },
        user: {
            type: Object,
            required: true
        },
        type_user: {
            type: Object,
            required: true
        },
        translations: Object
    },
    components: {
        Card,
        Tag,
        Tooltip, 
        Calendar,
        Accordion,
        AccordionTab,
        dialogMap
    },

    computed: {
            userIsRider() {
                return this.type_user.some(userType => userType.id_type_user === 1); // Suponiendo que el id para Rider sea 1
            },
            userIsProvider() {
                return this.type_user.some(userType => userType.id_type_user === 2); // Suponiendo que el id para Provider sea 2
            }
    },

    mounted() {
        this.shifts = this.schedules;
        
        this.directions = this.adress.map(address => {
            const { id_adress, ...rest } =  address; 
            const fullAddress = `${rest.road_type.name} ${rest.name} ${rest.number}, ${rest.city}, ${rest.cp}, ${rest.country}`;
            return { ...rest, full_address: fullAddress };
        });

        this.originalDirections = this.adress.map(address => {
            const { id_adress, ...rest } =  address; 
            const fullAddress = `${rest.road_type.name} ${rest.name} ${rest.number}, ${rest.city}, ${rest.cp}, ${rest.country}`;
            return { ...rest, full_address: fullAddress };
        });        
        
        this.originalSchedules = JSON.parse(JSON.stringify(this.schedules));

        this.typeRoads = this.roadTypes;
    },

    data(){
        return{
            directions: [],
            originalDirections: [],
            selectedDirection: {},

            editingProfile: false,
            daysOfWeek: [this.translations.mondaysLabel, this.translations.tuesdaysLabel, this.translations.wednesdaysLabel, this.translations.thursdaysLabel, this.translations.fridaysLabel, this.translations.saturdaysLabel, this.translations.sundaysLabel],
            displayShifts: false,

            shifts : [],
            originalSchedules: [],
            modalVisible: false,
            typeRoads: [],
        }
    },
    methods: {
        getShift(day, shift) {
            return this.shifts.find(s => s.day === day && s.shift === shift);
        },

        cancelEditing() {
            console.log(this.originalSchedules);
            this.shifts = JSON.parse(JSON.stringify(this.originalSchedules))
            this.directions = JSON.parse(JSON.stringify(this.originalDirections))
            this.editingProfile = false;
        },

        deleteShift(day, shift) {
            const index = this.shifts.findIndex(s => s.day === day && s.shift === shift);
            if (index !== -1) {
                // const otherShift = this.shifts.find(s => s.day === day && s.shift !== shift);
                // if (otherShift) {
                //     this.shifts.splice(index, 1);
                //     otherShift.shift = 1;
                // }
                this.shifts.splice(index, 1);
            }
        },


        getNumberShifts(day) {
            return this.shifts.filter(s => s.day === day).length;
        },

        getNumDirections(){
            return this.directions.length;
        },

        addShift(day,shift) {
            console.log(day);
            this.shifts.push({
                id_schedule: '',
                day: day,
                shift: shift,
                start_time: "00:00:00",
                finish_time: "00:00:00",
                id_user: this.user.id_user
            });
            console.log(this.shifts);
        },

        addDirection(adress) {
            let idRoad;

            for (const road of this.typeRoads) {
                if (road.name && adress.name && road.name.charAt(0).toLowerCase() === adress.name.charAt(0).toLowerCase()) {
                    idRoad = road.id_road;
                }
            }

            this.directions.push({
                country: adress.country,
                city: adress.city,
                cp: adress.cp,
                name: adress.name,
                number: adress.number,
                floor: adress.floor,
                door: adress.door,
                id_road: idRoad,
                id_user: this.user.id_user
            });

            this.directions = this.directions.map(address => {
                const { id_adress, ...rest } =  address; 
                const fullAddress = `${rest.name} ${rest.number}, ${rest.city}, ${rest.cp}, ${rest.country}`;
                return { ...rest, full_address: fullAddress };
            });
        },

        deleteDirection(index) {
            this.directions.splice(index, 1);
        },

        handleSubmit(event) {
            event.preventDefault();
            this.editingProfile = false;

            const formattedShifts = this.shifts.map(shift => ({
                ...shift,
                start_time: this.formatTime(shift.start_time),
                finish_time: this.formatTime(shift.finish_time)
            }));


            updateUserData(this.user, formattedShifts, this.directions).then((response) => {
                this.originalSchedules = [...this.shifts];
                this.originalDirections = [...this.directions];
            });
        },

        formatTime(dateTime) {

            if (typeof dateTime === 'string' && /^\d{2}:\d{2}:\d{2}$/.test(dateTime)) {
                return dateTime; // No hace falta formatear
            }

            const date = new Date(dateTime);
            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            const seconds = date.getSeconds().toString().padStart(2, '0');
            return `${hours}:${minutes}:${seconds}`;
        },

        openModal(adress){
            this.selectedDirection = adress;
            this.modalVisible = true;
        },

        closeModal(){
            this.modalVisible = false;
        }
    },
}
</script>

<style scoped>
.margin-start-tag {
    margin-left: 10px !important;
}
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

.form-custom{
    width: 100%;
    padding: 10px;
    border: none;
    outline: none;
    border-bottom: 1px solid #b48753;
    margin-bottom: 10px;
}

.save-button{
    color: #984eae;
    font-size: 3rem;
    cursor: pointer;
}

.form-custom::focus{
    outline: none;
    border-bottom: 1px solid #b48753;
}


.text-profile-schedule{
    color: #081733;
    font-weight: 600;
    font-family: 'Rubik', sans-serif;
    margin-left: 10px;
}

.title-business-info{
    font-size: 2rem;
    color: #081733;
    font-weight: 600;
    font-family: 'Rubik', sans-serif;
    margin-top: 20px;
    text-align: center;
    margin-bottom: 25px;
}

.delete-shift-btn{
    cursor: pointer;
}
.delete-shift-btn i{
    color: #b52a2a;
    font-size: 1.5rem;
    margin-left: 10px;
}

.add-shift-btn, .add-shift-btn-0-items{
    cursor: pointer;
}
.add-shift-btn i{
    color: #2ab52a;
    font-size: 1.5rem;
    margin-left: 15px;
}

.add-shift-btn-0-items i{
    color: #2ab52a;
    font-size: 1.5rem;
}

.divider-schedule{
    border-top: 1px solid #c6cfc9;
    margin-top: 20px;
    margin-bottom: 20px;
}

.eye-schedule{
    color: #081733;
    font-size: 1.5rem;
    cursor: pointer;
}

.p-icon{
    display: none !important;
}

.title-schedules-profile{
    color: #081733;
    font-weight: 500;
    font-family: 'Rubik', sans-serif;
    font-size: 20px;
}

@media screen and (max-width: 768px) { 
    .label-name-user {
        max-width: 150px; 
    }
}
</style>