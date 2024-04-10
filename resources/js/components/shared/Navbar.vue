
<!--La nav tiene que estar dentro de un container-fluid para funcionar correctamente, si quieres que ocupe todo el width quita los margenes del container-->

<template>
    <nav class=" row nav-header d-flex flex-column justify-content-center me-0" style="position: sticky; top: 0;">
      <div class="d-flex flex-row">
        <div class="ps-4 me-2" :class="{ 'col-6 d-flex align-items-center justify-content-start': isMobile, 'col-1 d-flex align-items-center justify-content-center': !isMobile }">
            <img :src="logoUrl" alt="logo-white" height="40">
        </div>
        <div :class="{ 'col-6 d-flex align-items-center justify-content-end': isMobile, 'col-7 d-flex flex-row justify-content-start ': !isMobile }">
          
          <div v-if="!isMobile" v-for="(item, index) in menuItems" :key="index" class="d-flex flex-row justify-content-center align-items-center me-5">
              <a class="mb-0 item-nav" :href="item.href">{{ item.name }}</a>
            </div>
            
            <div v-if="isMobile" @click="toggleMenu" class="col-5 d-flex justify-content-end align-items-center p-3 item-nav d">
              <div id="nav-icon" :class="{ 'open': showMenu }">
                <span></span>
                <span></span>
                <span></span>
              </div>
            </div>

        </div>
        <div v-if="!isMobile" class="col-4 d-flex align-items-center justify-content-end">
              <div class="me-5 d-flex gap-3">
                <button class="lang-btn" :class="{ 'active': language === 'ca' }" @click="changeLanguage('ca')">CAT</button>
                <button class="lang-btn" :class="{ 'active': language === 'es' }" @click="changeLanguage('es')">ESP</button>
                <button class="lang-btn" :class="{ 'active': language === 'en' }" @click="changeLanguage('en')">ENG</button>
              </div>
              <a class="log-out-nav mb-0 me-3">Cerrar session</a>
            </div>
        </div>
      <div v-if="isMobile && showMenu" class="burger-menu">
          <div class="submenu d-flex flex-column"> 
            <div class="submenu-top d-flex flex-column" style="flex:1">
              <h3 class="title-nav mt-5">STREET<span class="title-2-nav">FEED</span></h3>
              <a v-for="(item, index) in menuItems" :key="index" class="mb-0 item-nav item-nav-mobile ms-4 mt-5" :href="item.href">{{ item.name }}</a>
            </div>
            <div class="d-flex flex-column justify-content-center align-items-center mb-5">
              <button class="mobile-lang-btn mb-3" :class="{ 'active': language === 'ca' }" @click="changeLanguage('ca')">CAT</button>
              <button class="mobile-lang-btn mb-3" :class="{ 'active': language === 'es' }"@click="changeLanguage('es')">ESP</button>
              <button class="mobile-lang-btn" :class="{ 'active': language === 'en' }"@click="changeLanguage('en')">ENG</button>
            </div>
            <div class="d-flex justify-content-center align-items-end">
              <a class="log-out-nav mb-5">Cerrar session</a>
            </div>
          </div>
      </div>
    </nav>
    
</template>

<script>
import { logoUrl } from '../../utilities/constant.js';
export default {
  name: 'Navbar',

  props: {
    menuItems: {
      type: Array,
      required: true,
    },
    currentLanguage: String
  },
  data() {
    return {
      isMobile: false,
      showMenu: false,
      bodyOverflow: false,
      logoUrl,
      language: this.currentLanguage,
    };
  },
  mounted() {
    window.addEventListener('resize', this.checkScreenWidth);
    this.checkScreenWidth();
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.checkScreenWidth);
  },
  methods: {
    checkScreenWidth() {
      this.isMobile = window.innerWidth <= 985;
    },
    toggleMenu() {
      this.showMenu = !this.showMenu;
      this.bodyOverflow = !this.bodyOverflow;

      
      if (this.bodyOverflow) {
        document.body.classList.add('menu-open'); 
      } else {
        document.body.classList.remove('menu-open'); 
      }
    },
    changeLanguage(lang) {
      this.language = lang;
      // Enviar una solicitud al servidor para cambiar el idioma
      axios.get(`/set-language/${lang}`)
          .then(response => {
              // Actualizar la página o realizar cualquier otra acción necesaria
              // Por ejemplo, podrías recargar los datos para reflejar el nuevo idioma
              window.location.reload();
          })
          .catch(error => {
              console.error(error);
          });
    }
  },
}
</script>

<style scoped>
    .nav-header {
        background-color: #ffffff;
        z-index: 4;
        height: 10vh;
        top: 0px;
        position: relative;
    }

    .burger-menu {
      background-color: #ffffff;
      width: 100%;
      position: absolute;
      top: 10vh;
      box-shadow: 0 1px 5px rgba(0,0,0,.2), 0 2px 2px rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.12);
      animation: fadeIn 0.3s ease-in-out;
      z-index: 3;
      
    }

    .item-nav {
      cursor: pointer;
      border-radius: 6px;
      color: #081733;
      font-family: 'Rubik', sans-serif;
      font-weight: 500;
      font-size: 18px;
    }

    .submenu {
      height: 90vh;
    }

    .title-nav{
      font-family: 'Rubik', sans-serif;
      text-align: center;
      color: #081733;
      font-weight: 700;
      font-size: 40px;
    }

    .title-2-nav{
      color: #984eae;
    }

    @keyframes fadeIn {
      0% {
        opacity: 0;
        filter:blur(5px)
      }
      10% {
        opacity: 1;
        filter: brightness(2) blur(20px);
      }
      
    }

    #nav-icon {
      width: 30px;
      height: 20px;
      position: relative;
      transform: rotate(0deg);
      transition: .5s ease-in-out;
      cursor: pointer;
    }

    #nav-icon span {
      display: block;
      position: absolute;
      height: 3px;
      width: 100%;
      background: #081733;
      border-radius: 9px;
      opacity: 1;
      left: 0;
      transform: rotate(0deg);
      transition: .25s ease-in-out;
    }

    #nav-icon span:nth-child(1) {
      top: 0px;
    }

    #nav-icon span:nth-child(2) {
      top: 7px;
    }

   #nav-icon span:nth-child(3) {
      top: 14px;
    }

    #nav-icon span:nth-child(4) {
      top: 21px;
    }

    #nav-icon.open span:nth-child(1) {
      top: 10px;
      width: 0%;
      left: 50%;
    }

    #nav-icon.open span:nth-child(2) {
      transform: rotate(45deg);
      top: 10px;
    }

    #nav-icon.open span:nth-child(3) {
      transform: rotate(-45deg);
      top: 10px;
    }

    #nav-icon.open span:nth-child(4) {
      top: 10px;
      width: 0%;
      left: 50%;
    }

    .log-out-nav {
      color: #b52a2a;
      font-family: 'Poppins', sans-serif;
      font-weight: 700;
      font-size: 18px;
      cursor: pointer;
    }

    .item-nav-mobile{
      font-size: 24px;
    }
    .lang-btn {
      border: none;
      background: none;
      cursor: pointer;
      padding: 0;
      font-size: 16px;
      color: #081733; /* Color del texto */
    }

  .lang-btn:hover {
    text-decoration: underline;
  }

  .lang-btn.active {
    
    padding: 7px;
    border-radius: 3px;
    background-color: #b17a3b;
    color: #FDF8EB;
  }
  .mobile-lang-btn {
      width: 50%;
      background: #FDF8EB;
      cursor: pointer;
      padding: 7px;
      font-size: 16px;
      border-radius: 5px;
      border: none;
      color: #b17a3b;
    }

  .mobile-lang-btn:hover {
    text-decoration: underline;
  }

  .mobile-lang-btn.active {
    background-color: #b17a3b;
    color: #FDF8EB;
  }
</style>