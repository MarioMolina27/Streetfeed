<template>
    <div class="delivery-rider-card">
        <div class="tag-id-deliver">
           {{ delivery.id }}
        </div>
        <div class="progressBar">
            <div class="container-step d-flex flex-column" :class="{ 'active': delivery.id_state == 1 }">
                <div class="circle">
                    <i class="fa-regular fa-calendar-check logo-stats" :style="delivery.id_state === 1 ? { color: '#FDF8EB' } : { color: '#b48753' }"></i>
                </div>
                <p class="step-text">{{translations.inReserveLabel}}</p> 
            </div>
            
            <div>
                <div class="line mt-2"></div> 
            </div>

            <div class="container-step d-flex flex-column" :class="{ 'active': delivery.id_state == 2 }">
                <div class="circle">
                    <i class="fa-solid fa-truck logo-stats" :style="delivery.id_state === 2 ? { color: '#FDF8EB' } : { color: '#b48753' }"></i>
                </div>
                <p class="step-text">{{translations.inDeliveryLabel}}</p> 
            </div>
        </div>
        <div class="menu-items">
            <p>{{translations.firstMealLabel}}: <strong class="fs-5">{{ delivery.menu.first_product }}</strong> </p>
            <p>{{translations.secondMealLabel}}: <strong class="fs-5">{{ delivery.menu.second_product }}</strong></p>
            <p>{{translations.drinkLabel}}: <strong class="fs-5">{{ delivery.menu.drink_product }}</strong></p>
        </div>
    </div>

</template>

<script>
export default {
    props: {
        delivery: Object,
        translations: Object
    },
    data() {
        return {
            
        }
    },
    mounted() {
        console.log(this.delivery)
    },
    methods: {
        
    }
}
</script>

<style scoped>
.delivery-rider-card {
    position: relative;
    border: #b17a3b 2px solid;
    border-radius: 10px;
    padding: 10px;
    margin-top: 10px;
}
.tag-id-deliver {
    position: absolute;
    top: -10px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #b48753;
    color: #FDF8EB;
    padding: 5px;
    padding-inline: 10px;
    border-radius: 5px;
    font-size: 1.3em;
}
.progressBar {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 30px;
}

.container-step {
    display: flex;
    align-items: center;
    cursor: pointer;
    transform: scale(1.5);
    margin: 0 calc(1 * 1.5em);
}

.line {
  position: relative;
  width: 20vw;
  height: 4px;
  border-radius: 4px;
  outline: 1px solid #b48753;
  background: linear-gradient(to right, #b48753 50%, #FDF8EB 50%);
  background-size: 200% 100%;
  background-position: left bottom;
  animation: fillAnimation 2s infinite linear;
}
@keyframes fillAnimation {
  0% {
    background-position: right bottom;
  }
  100% {
    background-position: left bottom;
  }
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
}

.progressBar > * {
   height: 100px;
}

.logo-stats{
    width: 2vh;
    justify-content: center;
    display: flex;
}
.menu-items {
    display: flex;
    justify-content: space-evenly;
    margin-top: 20px;
}
</style>