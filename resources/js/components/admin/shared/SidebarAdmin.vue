<template>
    <Sidebar v-model:visible="visible" header=" ">
        <div>
            <div
                class="col-12 d-flex justify-content-center align-items-center flex-column"
            >
                <img
                    class="admin-img-land-decored"
                    :src="logoUrl"
                    alt="StreetFeed Logo"
                    height="60"
                    @click="goLanding()"
                />
                <h3 class="sidebar-title">{{ translations.streetFeedName }}</h3>
            </div>
            <div class="col-12 mt-5">
                <a
                    class="d-flex flex-row align-items-center mt-5"
                    :href="homeRouteAdmin"
                >
                    <img
                        :src="sideNavFirstImg"
                        alt="Home Logo Nav"
                        class="logo-nav-admin ms-2"
                    />
                    <p class="mb-0 ms-3 title-nav-admin">
                        {{ translations.homeMenuTab }}
                    </p>
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
                                        {{ translations.statsMenuTab }}
                                    </p>
                                </div>
                            </template>
                            <div class="d-flex flex-column">
                                <a
                                    class="mt-5"
                                    :href="statisticsProviderRouteAdmin"
                                >
                                    <a class="mb-0 ms-5 mt-5 title-nav-admin">{{
                                        translations.providersMenuTab
                                    }}</a>
                                </a>
                                <a
                                    class="mt-5"
                                    :href="statisticsRiderRouteAdmin"
                                >
                                    <a class="mb-0 ms-5 mt-4 title-nav-admin">{{
                                        translations.ridersMenuTab
                                    }}</a>
                                </a>
                            </div>
                        </AccordionTab>
                    </Accordion>
                </div>

                <a
                    class="d-flex flex-row align-items-center mt-5"
                    :href="usersRouteAdmin"
                >
                    <img
                        :src="sideNavThirdImg"
                        alt="Home Logo Nav"
                        class="logo-nav-admin ms-2"
                    />
                    <p class="mb-0 ms-3 title-nav-admin">
                        {{ translations.usersMenuTab }}
                    </p>
                </a>

                <a
                    class="d-flex flex-row align-items-center mt-5"
                    :href="mapAdminRoute"
                >
                    <img
                        :src="sideNavFourthImg"
                        alt="Home Logo Nav"
                        class="logo-nav-admin ms-2"
                    />
                    <p class="mb-0 ms-3 title-nav-admin">
                        {{ translations.mapMenuTab }}
                    </p>
                </a>
            </div>
        </div>
        <div class="col-12">
            <div class="d-flex flex-row align-items-center gap-3 mt-4">
                <button
                    class="admin-lang-btn"
                    :class="{ active: language === 'ca' }"
                    @click="changeLanguage('ca')"
                >
                    CAT
                </button>
                <button
                    class="admin-lang-btn"
                    :class="{ active: language === 'es' }"
                    @click="changeLanguage('es')"
                >
                    ESP
                </button>
                <button
                    class="admin-lang-btn"
                    :class="{ active: language === 'en' }"
                    @click="changeLanguage('en')"
                >
                    ENG
                </button>
            </div>
            <a
                class="log-out-nav d-flex flex-column align-items-center mt-5"
                @click="logout()"
                >Cerrar session</a
            >
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
import {
    logoUrl,
    sideNavFirstImg,
    sideNavSecondImg,
    sideNavThirdImg,
    sideNavFourthImg,
    homeRouteAdmin,
    usersRouteAdmin,
    statisticsProviderRouteAdmin,
    statisticsRiderRouteAdmin,
    mapAdminRoute,
    loginPage
} from "../../../utilities/constant.js";

export default {
    name: "SidebarAdmin",
    props: {
        translations: Object,
        currentLanguage: String,
    },
    components: {
        Sidebar,
        Accordion,
        AccordionTab,
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
            mapAdminRoute: mapAdminRoute,
            language: this.currentLanguage,
            loginPage: loginPage,
        };
    },

    methods: {
        changeLanguage(lang) {
            if (lang === this.language) return;
            this.language = lang;
            axios
                .get(`/set-language/${lang}`)
                .then((response) => {
                    window.location.reload();
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        logout() {
            axios
                .get("/logout")
                .then((response) => {
                    window.location.href = this.loginPage;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        goLanding() {
            let url = window.location.href;
            let baseUrl = url.split("public/")[0] + "public/";
            window.location.href = baseUrl;
        },
    },
};
</script>

<style>
.burger-menu {
    background: transparent;
    border: none;
}

.p-sidebar-content {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    overflow: hidden;
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

a {
    text-decoration: none;
    font-weight: 400;
    color: #081733;
}

.p-accordion .p-accordion-header .p-accordion-header-link {
    padding: 0;
}
.admin-lang-btn {
    width: 90%;
    background: #fdf8eb;
    cursor: pointer;
    padding: 7px;
    font-size: 16px;
    border-radius: 5px;
    border: none;
    color: #b17a3b;
}

.admin-lang-btn:hover:not(.active) {
    text-decoration: underline;
}

.admin-lang-btn.active {
    background-color: #b17a3b;
    color: #fdf8eb;
}
.log-out-nav {
    color: #b52a2a;
    font-weight: bold;
    font-size: 1.25rem;
    cursor: pointer;
}
.log-out-nav:hover {
    text-decoration: underline;
}
.admin-img-land-decored {
    cursor: pointer;
}
</style>
