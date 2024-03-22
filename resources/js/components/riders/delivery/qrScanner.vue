<template>
    <div class="frame">
        <button class="close-button" @click="closeFrame">
            <i class="fa-solid fa-xmark" style="color: #B52A2A;"></i>
        </button>
        <qrcode-stream @detect="onDetect" class="qrcode-stream" :camera="false"/>
        <div class="bottom-info">
            <span class="bottom-text">{{textInfo}}</span>
        </div>
        <div v-if="animating" class="animation">
            <svg v-if="animationConfirm" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
            </svg>
            <svg v-if="animationError" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                <circle class="path circle" fill="none" stroke="#B52A2A" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                <line class="path line" fill="none" stroke="#B52A2A" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/>
                <line class="path line" fill="none" stroke="#B52A2A" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/>
            </svg>
        </div>
    </div>
  </template>
  
  <script>
  import { QrcodeStream } from 'vue-qrcode-reader';
  
  export default {
    props: {
      deliveryIds: Array
    },
    data() {
      return {
        animating: false,
        animationError: false,
        animationConfirm: false,
        textInfo: 'Escanea el QR del proveedor'
      };
    },
    methods: {
        closeFrame() {
            this.notifyToCloseFrame(false);
        },
        onDetect(detectedCodes) {
            if (detectedCodes[0].rawValue === this.generateQRText()) {
                axios.post('api/delivery/do-collect', {
                    deliveryIds: this.deliveryIds
                })
                .then(response => {
                    this.animateConfirm();
                    setTimeout(() => {
                        this.stopAnimation();
                        this.notifyToCloseFrame(true);
                    }, 2000);
                })
                .catch(error => {
                    this.animateError();
                    setTimeout(() => {
                        this.stopAnimation();
                    }, 2000);
                });
            } else {
                this.animateError();
                setTimeout(() => {
                    this.stopAnimation();
                }, 2000);
            }
        },
        generateQRText() {
            let qrText = '';
            for (let i = 0; i < this.deliveryIds.length; i++) {
                qrText += this.deliveryIds[i];
                if (i < this.deliveryIds.length - 1) {
                    qrText += ',';
                }
            }
            return qrText;
        },
        notifyToCloseFrame(isChanging) {
            this.$emit('closeFrame', isChanging);
        },
        animateConfirm() {
            this.animating = true;
            this.animationConfirm = true;
            this.textInfo = 'Reparto recogido';
        },
        animateError() {
            this.animating = true;
            this.animationError = true;
            this.textInfo = 'Error al recoger el reparto';
        },
        stopAnimation() {
            this.animating = false;
            this.animationConfirm = false;
            this.animationError = false;
        },
    },
    components: {
      QrcodeStream
    }
  };
  </script>
  
  <style scoped>
  .frame {
    position: relative;
    width: 400px;
    height: 400px;
    border: 2px solid #081733;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  }
  
  .close-button {
    position: absolute;
    top: 5px;
    right: 5px;
    width: 30px;
    height: 30px;
    border: none;
    cursor: pointer;
    background-color: #FDF8EB;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    z-index: 1;
   } 
    .close-button:hover {
        background-color: #F0E0C9;
    }
  .qrcode-stream {
    width: 100%;
    height: 90%;
  }
  .bottom-info {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 10%;
    background-color: #FDF8EB;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 -5px 5px rgba(0, 0, 0, 0.3);
  }
  .bottom-text {
    width: 100%;
    text-align: center;
    color: #081733;
  }
  .fa-xmark:hover {
    scale: 1;
  }
  .animation {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
  svg {
        width: 250px;
        display: block;
        margin: 15vh auto 100px;
    }
    .path {
        stroke-dasharray: 1000;
        stroke-dashoffset: 0;
        &.circle {
            -webkit-animation: dash .9s ease-in-out;
            animation: dash .9s ease-in-out;
        }
        &.line {
            stroke-dashoffset: 1000;
            -webkit-animation: dash .9s .35s ease-in-out forwards;
            animation: dash .9s .35s ease-in-out forwards;
        }
        &.check {
            stroke-dashoffset: -100;
            -webkit-animation: dash-check .9s .35s ease-in-out forwards;
            animation: dash-check .9s .35s ease-in-out forwards;
        }
    }
    @-webkit-keyframes dash {
        0% {
            stroke-dashoffset: 1000;
        }
        100% {
            stroke-dashoffset: 0;
        }
    }
    @keyframes dash {
        0% {
            stroke-dashoffset: 1000;
        }
        100% {
            stroke-dashoffset: 0;
        }
    }
    @-webkit-keyframes dash-check {
        0% {
            stroke-dashoffset: -100;
        }
        100% {
            stroke-dashoffset: 900;
        }
    }
    @keyframes dash-check {
        0% {
            stroke-dashoffset: -100;
        }
        100% {
            stroke-dashoffset: 900;
        }
    }
  </style>
  