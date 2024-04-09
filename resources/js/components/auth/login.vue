<template>
    <div class="container-fluid vh-100">
        <div class="row h-100 position-relative overflow-hidden">
            <span class="logo-text">STREETFEED</span>
            <!-- primera columna: LOGIN -->
            <div class="col-md-6 d-flex flex-column justify-content-center" id="loginColumn">
                <div class="content-wrapper px-5" style="margin: 0 5rem;">
                    <!-- Contenido de la primera columna -->
                    <div class="container-fluid text-center ">
                        <img src="img/login/logoEQ7.svg" class="" alt="Logo Streetfeed">
                        <h1>
                            <span class="title-primary">STREET</span><span class="title-secondary">FEED</span class="title-secondary">
                        </h1>
                    </div>
                    <!-- Buttons Type User -->
                    <div class="container-fluid my-3 sign-in-google ">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <button 
                                    type="button" 
                                    class="btn w-100 btn-type-user" 
                                    :class="{ 'selected': selectedUserType === 'Provider' }" 
                                    @click="selectUserType('Provider')"
                                >
                                    PROVIDER
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button
                                    type="button"
                                    class="btn w-100 btn-type-user"
                                    :class="{ 'selected': selectedUserType === 'Rider' }"
                                    @click="selectUserType('Rider')"
                                >
                                    RIDER
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- divider line -->
                    <div class="container-fluid my-3 divider-login ">
                        <div class="line my-3"></div>
                    </div>
                    <!-- form login -->
                    <div class="container-fluid login-form d-flex flex-column align-items-center justify-content-center ">
                        <div class="form-login">
                            <label for="nickname-login" class="form-label">Nickname</label>
                            <div class="mb-3 input-wrapper">
                                <input class="form-control input-login" type="text" name="nickname-login" id="nickname-login" v-model="nickname" placeholder="Your nickname">
                                <i class="fa fa-user"></i>
                            </div>
                            <label for="password-login" class="form-label">Password</label>
                            <div class="mb-3 input-wrapper">
                                <input class="form-control input-login" type="password" name="password-login" id="password-login" v-model="password" placeholder="Your password">
                                <i class="fa fa-lock"></i>
                            </div>
                            <div class="mb-3">
                                <button class="btn w-100 btn-login" type="submit" @click="login()">Sign In</button>
                            </div>
                        </div>

                        <div class="register-access">
                            Don’t have an account? <a href="#" id="registerLink">Sign Up Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- segunda columna: REGISTER d-none  d-flex d-md-block justify-content-center -->
            <div class="position-relative col-md-6 d-flex flex-column h-100" id="registerColumn">
                <!-- Contenido de la segunda columna -->
                <div class="content-wrapper position-relative ">
                    <div class="container-fluid mb-3 d-flex justify-content-between login-access sticky-top" id="content-register">
                        <img src="img/login/logoEQ7.svg" class="" alt="Logo Streetfeed" style="height: 35px;">
                        <span>Already a member? <a href="#" id="loginLink">Log In Now</a></span>
                    </div>
                    
                    <!-- section steps -->
                    <div class="w-100 mb-3 d-flex justify-content-center align-items-center ">
                        <div class="step-nav step-active">1</div>
                        <div class="conector"></div>
                        <div class="step-nav">2</div>
                        <div class="conector"></div>
                        <div class="step-nav">3</div>
                        <div class="conector"></div>
                        <div class="step-nav">4</div>
                        <div class="conector"></div>
                        <div class="step-nav">5</div>
                    </div>

                    <!-- title -->
                    <h1 class="text-center mt-5 mb-5" id="title-register">Registrate y unete al cambio</h1>
                    
                    <!-- form register -->
                    <div class="container-fluid register-form d-flex flex-column align-items-center justify-content-center">
                        <form action="" autocomplete="off" class="d-flex px-5">
                            <!-- Step 1 -->
                            <div id="step-1" class="flex-column step" style="display: flex;">
                                <!-- title step 1 -->
                                <h2 class="text-center">Type <span class="title-secondary">User</span></h2>
                                <h5 class="text-center">¿Como deseas apoyar?</h5>
                                <!-- ckeck type user -->
                                <div class="row mb-5 align-items-center h-100">
                                    <div class="col d-flex justify-content-center align-items-center check-type-user">
                                        <div class="type-user-container">
                                            <!-- checkbox user -->
                                            <input type="checkbox" class="checkbox-user" name="" id="check-rider">
                                            <!-- image user -->
                                            <img src="" alt="" class="img-user">
                                        </div>
                                    </div>
                                    <div class="col d-flex justify-content-center align-items-center check-type-user">
                                        <div class="type-user-container">
                                            <!-- checkbox user -->
                                            <input type="checkbox" class="checkbox-user" name="" id="check-provider">
                                            <!-- image user -->
                                            <img src="" alt="" class="img-user">
                                        </div>
                                    </div>
                        
                                </div>
                                <div class="mb-3 btn-step">
                                    <!-- <a href="">PREV</a> -->
                                    <button class="btn btn-register next-step prev-step" type="submit">NEXT</button>
                                </div>
                            </div>
                            <!-- Step 2 -->
                            <div id="step-2" class="flex-column step" style="display: none;">
                                <!-- title step 2 -->
                                <h2 class="text-center">You <span class="title-secondary">Info</span></h2>
                                <!-- Content Step 2 -->
                                <div class="mb-3">
                                    <label for="email-login" class="form-label">Name</label>
                                    <input class="form-control input-login" type="text" name="email-login" placeholder="Your name">
                                </div>
                                <div class="mb-3">
                                    <label for="email-login" class="form-label">Surnames</label>
                                    <input class="form-control input-login" type="text" name="email-login" placeholder="Your surnames">
                                </div>
                                <div class="mb-3">
                                    <label for="email-login" class="form-label">E-mail</label>
                                    <input class="form-control input-login" type="text" name="email-login" placeholder="you@example.com">
                                </div>
                                <div class="mb-3">
                                    <label for="password-login" class="form-label">Password</label>
                                    <input class="form-control input-login" type="password" name="password-login" placeholder="Your password">
                                </div>
                                <div class="mb-3 btn-step">
                                    <a href="#" class="prev-step">PREV</a>
                                    <button class="btn btn-register next-step prev-step" type="submit">NEXT</button>
                                </div>
                            </div>
                            <!-- Step 3 -->
                            <div id="step-3" class="flex-column step" style="display: none;">
                                <!-- title step 3 -->
                                <h2 class="text-center">You <span class="title-secondary">Address</span></h2>
                                <!-- content step 3 -->
                                <div class="mb-3">
                                    <label for="country-register" class="form-label">Country</label>
                                    <input class="form-control input-login" type="text" name="country-register" id="country-register" placeholder="Select a country" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="city-register" class="form-label">City</label>
                                    <input class="form-control input-login" type="text" name="city-register" id="city-register" placeholder="Select a city" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="p-code-register" class="form-label">Postal Code</label>
                                    <input class="form-control input-login" type="text" name="p-code-register" id="p-code-register" placeholder="Your postal code" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="address-register" class="form-label">Address</label>
                                    <input class="form-control input-login" type="text" name="address-register" id="address-register" placeholder="Your address">
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="number-address-register" class="form-label">Number</label>
                                        <input class="form-control input-login" name="number-address-register" id="number-address-register" type="number" placeholder="1">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="floor-address-register">Floor</label>
                                        <input class="form-control input-login" name="floor-address-register" id="floor-address-register" type="text" placeholder="Primero (1º)">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="door-address-register">Door</label>
                                        <input class="form-control input-login" name="door-address-register" id="door-address-register" type="text" placeholder="Primera (1ª)">
                                    </div>
                                </div>
                                <div class="mb-3 btn-step">
                                    <a href="#" class="prev-step">PREV</a>
                                    <button class="btn btn-register next-step prev-step" type="submit">NEXT</button>
                                </div>
                            </div>
                            <!-- Step 4 -->
                            <div id="step-4" class="flex-column step" style="display: none;">
                                <!-- title step 4 -->
                                <h2 class="text-center">Business <span class="title-secondary">Info</span></h2>
                                <h5 class="text-center fw-light">HORARY</h5>
                                <!-- content step 4 -->
                                <template v-for="(day, index) in daysOfWeek" :key="index">
                                    <div class="row mt-3 d-flex align-items-center justify-content-center">
                                            <div class="col-lg-4 col-12 d-flex flex-row align-items-center">
                                                <img src="img/Alarmclock.svg" alt="img-first-category-game" class="img-profile-stats" />
                                                <p class="text-profile-schedule mb-0">{{ day }}</p>
                                            </div>
                                            <div class="col-lg-7 col-12 d-flex flex-row ms-4">
                                                <div class="d-flex flex-column gap-2">
                                                    <div class="d-flex flex-row">
                                                        <Calendar :id="'calendar-timeonly-' + index + '-morning'" class="ms-2" timeOnly />
                                                        <Calendar :id="'calendar-timeonly-' + index + '-afternoon'" class="ms-2" timeOnly />
                                                        <div class="d-flex justify-content-center align-items-center delete-shift-btn" @click="deleteShift(index + 1, day)"><i class="fa fa-trash"></i></div>
                                                        <!-- <div v-if="shiftIndex === getNumberShifts(index + 1) - 1 && getNumberShifts(index + 1) === 1" @click="addShift(index+1)" class="d-flex justify-content-center align-items-center add-shift-btn"><i class="fa fa-add"></i></div> -->
                                                    </div>
                                                    <div class="d-flex flex-row">
                                                        <Calendar :id="'calendar-timeonly-' + index + '-morning'" class="ms-2" timeOnly />
                                                        <Calendar :id="'calendar-timeonly-' + index + '-afternoon'"  class="ms-2" timeOnly />
                                                        <div class="d-flex justify-content-center align-items-center delete-shift-btn" @click="deleteShift(index + 1, day)"><i class="fa fa-trash"></i></div>
                                                        <!-- <div v-if="shiftIndex === getNumberShifts(index + 1) - 1 && getNumberShifts(index + 1) === 1" @click="addShift(index+1)" class="d-flex justify-content-center align-items-center add-shift-btn"><i class="fa fa-add"></i></div> -->
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div v-if="index !== daysOfWeek.length - 1" class="divider-schedule"></div>
                                </template>
                                <div class="mb-3 btn-step">
                                    <a href="#" class="prev-step">PREV</a>
                                    <button class="btn btn-register next-step prev-step" type="submit">NEXT</button>
                                </div>
                            </div>
                            <!-- Step 5 -->
                            <div id="step-5" class="step border" style="display: none;">
                                <!-- title step 5 -->
                                <h2 class="text-center">You <span class="title-secondary">Summary</span></h2>
                                <div class="mb-3 btn-step">
                                    <a href="" class="prev-step">PREV</a>
                                    <button class="btn btn-register next-step" type="submit">FINISH</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
            <img class="logo-column" src="img/login/Logo-EQ7.svg" alt="">
        </div>
    </div>

</template>

<script>
import { gsap } from "gsap";
import Calendar from 'primevue/calendar';
import { homeRouteAdmin, mainRiderPage, mainProviderPage} from '../../utilities/constant.js';

export default {
    data() {
        return {
            nickname: '',
            password: '',
            daysOfWeek: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
            shifts : [],
            displayShifts: false,
            selectUserType: null, // Tipo de usuario seleccionado
        };
    },
    methods: {
        selectUserType(userType) {
            this.selectedUserType = userType;
        },
        login() {
            axios.post('users/login', {
                nickname: this.nickname,
                password: this.password
            })
            .then(response =>{
                console.log(response.data)
                if (response.data != null) {
                    const typeUser = response.data.type_users[0].id_type_user;
                    if(typeUser == '1') {
                        window.open(mainProviderPage,"_self")
                    } else if((typeUser == '2')) {
                        window.open(mainRiderPage,"_self")
                    } else if((typeUser == '3')) {
                        window.open(homeRouteAdmin,"_self")
                    }
                } else {
                    //mensaje de error
                    console.log('incorrct')
                }
                
            })
            .catch(error => {
                console.error('Error al loguearse', error);
                console.log('incorrct')
            });

            //si es correcto -> auth
            //si es incorrecto msg error
        },
        getShift(day, shift) {
            return this.shifts.find(s => s.day === day && s.shift === shift);
        },
        deleteShift(day, shift) {
            const index = this.shifts.findIndex(s => s.day === day && s.shift === shift);
            if (index !== -1) {
                const otherShift = this.shifts.find(s => s.day === day && s.shift !== shift);
                if (otherShift) {
                    this.shifts.splice(index, 1);
                    otherShift.shift = 1;
                }
            }
        },
        getNumberShifts(day) {
            return this.shifts.filter(s => s.day === day).length;
        },

        addShift(day) {
            this.shifts.push({
                id_schedule: '',
                day: day,
                shift: 2,
                start_time: "",
                finish_time: "",
                id_user: this.user.id
            });
        },
        intercambiarContenido() {
            let loginColumn = document.getElementById('loginColumn');
            let registerColumn = document.getElementById('registerColumn');

            // Cambiar la opacidad de la columna de login a 0 y el background
            this.cambiarOpacidad();
            this.trasladarTexto();
            this.trasladarLogo();
            gsap.to(loginColumn, {
                duration: 1,
                backgroundColor: '#B48753'
            });

            gsap.to(registerColumn, {
                duration: 1,
                backgroundColor: '#FDF8EB'
            });
        },
        cambiarOpacidad() {
            const contentLoginColumn = document.querySelectorAll('#loginColumn .content-wrapper');
            const contentRegisterColumn = document.querySelectorAll('#registerColumn .content-wrapper');

            gsap.to(contentLoginColumn, {
                duration: 1,
                autoAlpha: 0
            });
            
            gsap.to(contentRegisterColumn, {
                duration: 1,
                autoAlpha: 1
            });
        },
        trasladarTexto() {
            const logoText = document.querySelector('.logo-text');
            gsap.to(logoText, {
                duration: 1,
                rotation: 90,
                top: '2em',
                right: 'auto',
                left: '45%'
            });
        },
        trasladarLogo() {
            const logoImg = document.querySelector('.logo-column');
            gsap.to(logoImg, {
                duration: 1,
                x: '-50%'
            });
        },
        mostrarLogin() {
            let loginColumn = document.getElementById('loginColumn');
            let registerColumn = document.getElementById('registerColumn');

            // Revertir contenido, texto y logo
            this.cambiarOpacidadLogin();
            this.trasladarLogoLogin();
            this.trasladarTextoLogin();
            
            // Revertir el cambio de color de fondo
            gsap.to(loginColumn, {
                duration: 1,
                backgroundColor: '#FDF8EB' //color inicial
            });

            gsap.to(registerColumn, {
                duration: 1,
                backgroundColor: '#B48753'
            });
        },
        cambiarOpacidadLogin() {
            const contentLoginColumn = document.querySelectorAll('#loginColumn .content-wrapper');
            const contentRegisterColumn = document.querySelectorAll('#registerColumn .content-wrapper');

            gsap.to(contentLoginColumn, {
                duration: 1,
                autoAlpha: 1 // aumentar opacidad
            });
            
            gsap.to(contentRegisterColumn, {
                duration: 1,
                autoAlpha: 0 // reducir opacidad
            });
        },
        trasladarTextoLogin() {
            const logoText = document.querySelector('.logo-text');

            gsap.to(logoText, {
                duration: 1,
                rotation: -90,
                top: 'auto',
                right: 'auto',
                left: '55%',
                zIndex: '10'
            });
        },
        trasladarLogoLogin() {
            const logoImg = document.querySelector('.logo-column');

            gsap.to(logoImg, {
                duration: 1,
                x: '50%',
                immediateRender: false,
                overwrite: 'auto'
            });
        },
        navigateToFormStep(stepNumber) {
            // Ocultamos todos los pasos
            const steps = document.querySelectorAll('.step');
            steps.forEach(step => step.style.display = 'none');

            // Mostrar el paso seleccionado
            const currentStep = document.getElementById(`step-${stepNumber}`);
            currentStep.style.display = 'block';

            // Actualizar la barra de progreso y las lineas conectoras
            const stepNavs = document.querySelectorAll('.step-nav');
            const connectors = document.querySelectorAll('.conector');
            stepNavs.forEach((nav, index) => {
                if (index + 1 <= stepNumber) {
                    nav.classList.add('step-active');
                    if (connectors[index]) {
                        connectors[index].classList.add('conector-active');
                    }
                } else {
                    nav.classList.remove('step-active');
                    if (connectors[index]) {
                        connectors[index].classList.remove('conector-active');
                    }
                }
            })
        }
    },
    mounted() {

        /*
        document.querySelectorAll('.btn-type-user').forEach(function(button) {
            button.addEventListener('click', function() {
                Remover la clase 'selected' de todos los botones
                document.querySelectorAll('.btn-type-user.selected').forEach(function(btn) {
                    btn.classList.remove('selected');
                });
                Agregar la clase 'selected' al botón clicado
                this.classList.add('selected');
            });
        });
        */

        document.getElementById('registerLink').addEventListener('click', function(e) {
            e.preventDefault();
            this.intercambiarContenido();
        }.bind(this));

        document.getElementById('loginLink').addEventListener('click', function(e) {
            e.preventDefault();
            this.mostrarLogin();
        }.bind(this));
        

        document.querySelectorAll('.next-step, .prev-step').forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                const currentStep = parseInt(button.closest('.step').id.replace('step-', ''));
                const nextStep = button.classList.contains('next-step') ? currentStep + 1 : currentStep -1;
                this.navigateToFormStep(nextStep);
            })
        });

        document.querySelectorAll('.prev-step').forEach(a => {
            a.addEventListener('click', (event) => {
                event.preventDefault();
                const currentStep = parseInt(button.closest('.step').id.replace('step-', ''));
                const prevStep = a.classList.contains('prev-step') ? currentStep - 1 : currentStep + 1;
                this.navigateToFormStep(prevStep);
            })
        });
            
    },
    components: {
        Calendar
    }
}

</script>

<style scoped>

a {
    text-decoration: none;
}

button {
    height: 44px;
}

/* columnas (login - register) */
#loginColumn,
#registerColumn {
    margin: 0;
}
#loginColumn {
    background-color: var(--primary-street-feed);
    box-shadow: 1px 1px 1px var(--text-color);
}

#registerColumn {
    background-color: var(--secondary-color);
    box-shadow: 1px 1px 1px var(--text-color);
}

#registerColumn .content-wrapper {
    opacity: 0;
}

#registerColumn h1,
#registerColumn h2,
#registerColumn h5 {
    color: var(--text-color);
}

/* #registerColumn */

.logo-text {
    position: absolute;
    display: inline-block;
    transform: rotate(-90deg);
    transform-origin: top left;
    bottom: 1.5rem;
    color: rgba(253, 248, 235, 10%);
    left: 55%;
    transform: rotate(270deg);
    font-family: var(--primary-font);
    font-size: 3.45rem;
    z-index: 10;
}

.logo-column {
    position: absolute;
    width: 100%;
    height: 80%;
    top: 10%;
    transform: translateX(50%);
}

.header {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.header img {
    width: 35px;
    margin-bottom: 1rem;
}

.logo span {
    font-size: 32px;
    font-weight: 500;
    font-family: var(--primary-street-feed);
}

.title-primary {
    color: var(--text-color);
}

.title-secondary {
    color: var(--action-color);
}

/*  --- header style end --- */

/* login section */

/* login section end */

/* sign-in google {}*/

.sign-in-google button {
    width: 100%;
    border: 2px solid var(--secondary-color);
    border-radius: 8px;
    font-family: var(--primary-font);
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--text-color);
    /* padding: 0 1.8rem; */
    box-shadow: 1px 1px 1px var(--text-color);
    white-space: nowrap;
}

.sign-in-google button i {
    margin-right: 1.2rem;
    color: inherit;
}

.sign-in-google button:hover {
    color: var(--secondary-color);
}

.sign-in-google button.btn-type-user {
    font-size: 80%;
    transition: font-size 0.1s ease;
}

.sign-in-google button.btn-type-user:hover {
    color: var(--primary-street-feed);
    background-color: var(--secondary-color);
    font-size: 100%;
}

.sign-in-google button.btn-type-user.selected {
    background-color: var(--secondary-color);
    color: var(--primary-street-feed);
    font-size: 120%;
    
}

.selected {
    /* Estilos para el boton seleccionado */
    background-color: var(--secondary-color);
    color: var(--primary-street-feed);
    font-size: 120%;
}

/* Divider Login */
.divider-login {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.line {
    border-top: 2px solid var(--secondary-color);
    flex-grow: 1;
    flex-shrink: 0;
    min-width: 100px;
}

.line:first-child {
    margin-right: 10px;
}

.line:last-child {
    margin-left: 10px;
}

.divider-login p {
    font-family: var(--primary-font);
    font-weight: 500;
    font-size: 1.5rem;
    color: var(--text-color);
}
/* --- Divider end --- */

.login-form,
.register-form {
    width: 100%;
    /* padding: 2.5rem 1rem; */
    font-size: 1.3rem;
    margin: 1rem 0;
}

.login-form .form-login,
.register-form form {
    display: flex;
    flex-direction: column;
    width: 100%;
}

.login-form .row {
    margin: 0;
}

.login-form label,
.register-form label {
    padding: 0;
    margin-bottom: .5rem;
    font-weight: 600;
    color: var(--text-color);
}

.login-form .input-wrapper {
    position: relative;
    display: inline-block
}

.login-form input {
    padding-right: 30px;
}

.login-form i {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--secondary-color);
}

.input-login {
    width: 100%;
    padding: 0 0 0 .8rem;
    margin: 0;
    border: 2px solid var(--secondary-color);
    border-radius: 8px;
    line-height: 2.5rem;
    background: none;
}

.input-wrapper:focus-within i {
    color: var(--action-color);
}

.input-login:focus {
    border-color: var(--action-color);
    color: rgb(152, 78, 174);
    box-shadow: 0 1px 1px rgba(152, 78, 174, 0.075)inset, 0 0 8px rgba(152, 78, 174,0.6);
    outline: 0 none;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;;
}

.btn-login {
    border: none;
    background: var(--action-color);
    font-family: var(--primary-font), sans-serif;
    font-size: 1.3rem;
    font-weight: 700;
    padding: .5rem 0;
    border-radius: 8px;
    color: var(--primary-street-feed);
    box-shadow: 1px 1px 1px var(--text-color);
}

.btn-register {
    background: var(--action-color);
    font-family: var(--primary-font), sans-serif;
    font-size: 1.3rem;
    font-weight: 700;
    border-radius: 8px;
    color: var(--primary-street-feed);
    box-shadow: 1px 1px 1px var(--text-color);
}

.register-access,
.login-access {
    margin-top: 1.8rem;
    text-align: center;
    font-family: var(--primary-font), sans-serif;
}

.login-access span {
    font-size: 1.3rem;
}

.register-access a,
.login-access a {
    color: var(--text-color);
    font-weight: bold;
}

/* --- FORM REGISTER --- */

#title-register {
    font-weight: 600;
}

.step-nav {
    width: 50px;
    height: 50px;
    background: var(--primary-street-feed);
    border: 1px solid var(--secondary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--secondary-color);
    position: relative;
}

.step-active {
    background: var(--action-color);
    border: 1px solid var(--action-color);
    color: var(--primary-street-feed);
    box-shadow: 0 1px 1px rgba(152, 78, 174, 0.075)inset, 0 0 8px rgba(152, 78, 174,0.6);
}

.conector {
    height: 2px;
    width: 5.5rem;
    background: var(--secondary-color);
}

.conector-active {
    height: 3px;
    width: 5.5rem;
    background-color: var(--action-color);
    box-shadow: 0 1px 1px rgba(152, 78, 174, 0.075)inset, 0 0 8px rgba(152, 78, 174,0.6);
}

/* form register */
/* step */
.step {
    height: 600px;
    /* overflow-y: auto; */
    margin: 0 3rem;
}

.btn-step {
    display: flex;
    flex-direction: row;
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    justify-content: space-around;
    padding: 0 3rem;
}

.btn-step a {
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: var(--primary-font), sans-serif;
    font-size: 1.3rem;
    font-weight: 700;
    border: 1px solid var(--text-color);
    border-radius: 8px;
    color: var(--text-color);
    box-shadow: 1px 1px 1px var(--text-color);
}

.btn-step a,
.btn-step button {
    width: 25%;
}

.check-type-user {
    width: 430px;
    position: relative;
}

.type-user-container {
    border: 2px solid var(--secondary-color);
    width: 230px;
    height: 230px;
    border-radius: 20px;
}

.type-user-container input {
    position: absolute;
    top: 1.5rem;
    right: 3rem;
    right: 25%;
}

.checkbox-user {
    width: 45px;
    height: 45px;
    clip-path: circle(50% at 50% 50%);
    position: relative;
    border: 2px solid var(--secondary-color);
}

.checkbox-user::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    clip-path: circle(50% at 50% 50%);
    border: 2px solid var(--secondary-color);
}

.checkbox input {
    height: 0;
    width: 0;
    visibility: hidden;
}

.checkbox {
    display: block;
    position: relative;
    padding-left: 35px;
    cursor: pointer;
    font-size: 22px;
}

.ckeckmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background: var(--primary-street-feed);
    border: 2px solid var(--secondary-color);
    border-radius: 50%;
}

.checkbox input:checked ~ .checkmark {
    background-color: var(--action-color);
}

.checkbox input:checked ~ .checkmark::after {
    content: '';
    position: absolute;
    display: block;
    width: 12px;
    height: 12px;
    background: var(--primary-street-feed);
    border-radius: 50%;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

/* step 4 */
.label-day::before {
    font-family: 'Font Awesome 5 Free';
    content: "\f017";
    display: inline-block;
    margin-right: 5px;

}

.btn-add-horary {
    border: 1px solid var(--secondary-color);
    border-radius: 50%;
}

</style>