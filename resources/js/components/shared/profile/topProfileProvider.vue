<template>
    <div class="container">
        <div class="progressBar">
        <div class="container-step d-flex flex-column" :class="{ 'active': deliveriesUser >= 0 && deliveriesUser <= 5 }">
            <div class="circle">
                <img v-if="this.deliveriesUser >= 0 && this.deliveriesUser <= 5" src="img/logo_blanco.svg" alt="img-first-category-game" class="logo-stats"/>
                <img v-else src="img/logo.svg" alt="img-first-category-game" class="logo-stats"/>
            </div>
            <p class="step-text">0-5 entregas</p> 
        </div>
        
        <div>
            <div class="line mt-2"></div> 
        </div>

        <div class="container-step d-flex flex-column" :class="{ 'active': deliveriesUser >= 5 && deliveriesUser <= 20 }">
            <div class="circle">
                <img v-if="this.deliveriesUser >=5 && this.deliveriesUser <=20" src="img/logo_blanco.svg" alt="img-first-category-game" class="logo-stats"/>
                <img v-else src="img/logo.svg" alt="img-first-category-game" class="logo-stats"/>
            </div>
            <p class="step-text">5-20 entregas</p> 
        </div>

        <div>
            <div class="line mt-2"></div> 
        </div>

        <div class="container-step d-flex flex-column" :class="{ 'active': deliveriesUser > 20 }">
            <div class="circle">
                <img v-if="this.deliveriesUser >20" src="img/logo_blanco.svg" alt="img-first-category-game" class="logo-stats"/>
                <img v-else src="img/logo.svg" alt="img-first-category-game" class="logo-stats"/>
            </div>
            <p class="step-text">+20 entregas</p> 
        </div>
    </div>
    </div>
</template>

<script>

export default {
    props: {
        user: {
            type: Object,
            required: true
        },
        deliveriesUser: {
            type: Number,
            required: true
        },
    },

    data() {
        
    },
  
}
</script>

<style scoped>
.progressBar {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 80px;
}

.container-step {
    display: flex;
    align-items: center;
    cursor: pointer;
    transform: scale(1.5);
    margin: 0 calc(1 * 1.5em);
}

/* Styling for the lines between circles */
.line {
    width: 10vw;
    height: 3px;
    border-radius: 4px;
    background: #b48753;
}

.circle {
    border-radius: 50%; 
    border: 2px solid #b48753;
    background-color: transparent; 
    padding: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.container-step.active .circle::before {
    opacity: 1;
}

.container-step.active .circle {
    background-color: #b48753;
    border-color: #b48753;
}

.step-text {
    text-align: center;
    font-size: 0.8em;
    margin-top: 10px;
}

.progressBar > * {
   height: 100px;
}

.logo-stats{
    width: 2vh;
}
</style>