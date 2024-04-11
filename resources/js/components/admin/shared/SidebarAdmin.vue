<template>
    <Sidebar v-model:visible="visible" header=" ">
                <div
                    class="col-12 d-flex justify-content-center align-items-center flex-column"
                >
                    <img :src="logoUrl" alt="StreetFeed Logo" height="60" />
                    <h3 class="sidebar-title">{{translations.streetFeedName}}</h3>
                </div>
                <div class="col-12 mt-5">
                    <a class="d-flex flex-row align-items-center mt-5" :href="homeRouteAdmin">
                        <img
                            :src="sideNavFirstImg"
                            alt="Home Logo Nav"
                            class="logo-nav-admin ms-2"
                        />
                        <p class="mb-0 ms-3 title-nav-admin">{{translations.homeMenuTab}}</p>
                    </a>

                    <div class="d-flex flex-row align-items-center mt-5">
                        <Accordion class="w-100">
                            <AccordionTab>
                                <template #header>
                                    <div class="d-flex flex-row align-items-center">
                                        <img
                                            :src="sideNavSecondImg"
                                            alt="Home Logo Nav"
                                            class="logo-nav-admin ms-2"
                                        />
                                        <p class="mb-0 ms-3 title-nav-admin">
                                            {{translations.statsMenuTab}}
                                        </p>
                                    </div>
                                </template>
                               <div class="d-flex flex-column">
                                <a class="mt-5" :href="statisticsProviderRouteAdmin">
                                    <a class="mb-0 ms-5 mt-5 title-nav-admin">{{translations.providersMenuTab}}</a>
                               </a>
                                <a class="mt-5"  :href="statisticsRiderRouteAdmin">
                                    <a class="mb-0 ms-5 mt-4 title-nav-admin">{{translations.ridersMenuTab}}</a>
                                </a>
                               </div>
                            </AccordionTab>
                        </Accordion>
                    </div>

                    <a class="d-flex flex-row align-items-center mt-5"  :href="usersRouteAdmin">
                        <img
                            :src="sideNavThirdImg"
                            alt="Home Logo Nav"
                            class="logo-nav-admin ms-2"
                        />
                        <p class="mb-0 ms-3 title-nav-admin">{{translations.usersMenuTab}}</p>
                    </a>

                    <a class="d-flex flex-row align-items-center mt-5" :href="mapAdminRoute">
                        <img
                            :src="sideNavFourthImg"
                            alt="Home Logo Nav"
                            class="logo-nav-admin ms-2"
                        />
                        <p class="mb-0 ms-3 title-nav-admin">{{translations.mapMenuTab}}</p>
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
import { logoUrl, sideNavFirstImg, sideNavSecondImg, sideNavThirdImg, sideNavFourthImg, homeRouteAdmin, usersRouteAdmin , statisticsProviderRouteAdmin, statisticsRiderRouteAdmin, mapAdminRoute} from '../../../utilities/constant.js';

 

export default {
    name: "SidebarAdmin",
    props: {
        translations: Object
    },
    components: {
        Sidebar,
        Accordion,
        AccordionTab
    },

    data() {
        return {
            visible: false,
            logoUrl: logoUrl,
            sideNavFirstImg: sideNavFirstImg,
            sideNavSecondImg: sideNavSecondImg,
            sideNavThirdImg: sideNavThirdImg,
            sideNavFourthImg: sideNavFourthImg,
            homeRouteAdmin: homeRouteAdmin,
            usersRouteAdmin: usersRouteAdmin,
            statisticsProviderRouteAdmin: statisticsProviderRouteAdmin,
            statisticsRiderRouteAdmin: statisticsRiderRouteAdmin,
            mapAdminRoute: mapAdminRoute
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