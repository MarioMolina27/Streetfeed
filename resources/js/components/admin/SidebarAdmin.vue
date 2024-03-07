<template>
    <Sidebar v-model:visible="visible" header=" ">
                <div
                    class="col-12 d-flex justify-content-center align-items-center flex-column"
                >
                    <img src="img/logo.svg" alt="StreetFeed Logo" height="60" />
                    <h3 class="sidebar-title">STREETFEED</h3>
                </div>
                <div class="col-12 mt-5">
                    <a class="d-flex flex-row align-items-center mt-5" href="https://es.stackoverflow.com/questions/154052/como-se-pone-un-link-a-un-div">
                        <img
                            src="img/home_nav_img.svg"
                            alt="Home Logo Nav"
                            class="logo-nav-admin ms-2"
                        />
                        <p class="mb-0 ms-3 title-nav-admin">HOME</p>
                    </a>

                    <div class="d-flex flex-row align-items-center mt-5">
                        <Accordion class="w-100">
                            <AccordionTab>
                                <template #header>
                                    <div class="d-flex flex-row align-items-center">
                                        <img
                                            src="img/stadistics_nav_img.svg"
                                            alt="Home Logo Nav"
                                            class="logo-nav-admin ms-2"
                                        />
                                        <p class="mb-0 ms-3 title-nav-admin">
                                            STADISTICS
                                        </p>
                                    </div>
                                </template>
                               <div class="d-flex flex-column">
                                <a class="mt-5"  href="https://es.stackoverflow.com/questions/154052/como-se-pone-un-link-a-un-div">
                                    <a class="mb-0 ms-5 mt-5 title-nav-admin">PROVIDERS</a>
                               </a>
                                <a class="mt-5"  href="https://es.stackoverflow.com/questions/154052/como-se-pone-un-link-a-un-div">
                                    <a class="mb-0 ms-5 mt-4 title-nav-admin">RIDERS</a>
                                </a>
                               </div>
                            </AccordionTab>
                        </Accordion>
                    </div>

                    <a class="d-flex flex-row align-items-center mt-5"  href="https://es.stackoverflow.com/questions/154052/como-se-pone-un-link-a-un-div">
                        <img
                            src="img/users_nav_img.svg"
                            alt="Home Logo Nav"
                            class="logo-nav-admin ms-2"
                        />
                        <p class="mb-0 ms-3 title-nav-admin">USERS</p>
                    </a>

                    <a class="d-flex flex-row align-items-center mt-5" href="https://es.stackoverflow.com/questions/154052/como-se-pone-un-link-a-un-div">
                        <img
                            src="img/map_nav_img.svg"
                            alt="Home Logo Nav"
                            class="logo-nav-admin ms-2"
                        />
                        <p class="mb-0 ms-3 title-nav-admin">MAP</p>
                    </a>
                </div>
            </Sidebar>
            <button class="burger-menu" @click="visible = true">
                <i class="pi pi-bars burger-logo"></i>
            </button>
</template>

<script>
import Sidebar from "primevue/sidebar";
import Accordion from "primevue/accordion";
import AccordionTab from "primevue/accordiontab";
 

export default {
    name: "SidebarAdmin",
    components: {
        Sidebar,
        Accordion,
        AccordionTab
    },

    data() {
        return {
            visible: false
        }
    }
};

</script>

<style>

.burger-menu {
    background: transparent;
    border: none;
}

.burger-logo {
    font-size: 1.8rem;
}

.sidebar-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #081733;
    font-family: "Rubik", sans-serif;
    text-align: center;
}

.logo-nav-admin {
    color: #081733;
    height: 1.9rem;
}

.title-nav-admin {
    font-size: 1.5rem;
    color: #081733;
    font-family: "Rubik", sans-serif;
}

a{
    text-decoration: none;
    font-weight: 400;
    color: #081733;
}

.p-accordion .p-accordion-header .p-accordion-header-link{
    padding: 0;
}

</style>