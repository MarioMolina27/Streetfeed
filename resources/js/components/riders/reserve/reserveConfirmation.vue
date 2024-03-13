<template>
    <div class="centered-content">
        <svg v-if="this.reserve" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
            <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
            <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
        </svg>
        
        <svg v-if="!this.reserve" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
            <circle class="path circle" fill="none" stroke="#B52A2A" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
            <line class="path line" fill="none" stroke="#B52A2A" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/>
            <line class="path line" fill="none" stroke="#B52A2A" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/>
        </svg>
        <div class="d-flex justify-content-center">
            <div v-if="this.reserve">
                <h2 style="text-align: center;">Reparto reservado <strong>correctamente</strong></h2>
                <button class="button-pdf" @click="generatePDF">Generar PDF</button>
            </div>
            <div v-else>
                <h2 style="text-align: center;">Ha ocurrido un error al reservar y asignar el reparto</h2>
            </div>
        </div>
        <button class="button-confirm" @click="redirectToRoute">{{ !this.reserve ? 'Vuelve a realizar tu pedido' : 'Mira tu entrega!'}}</button>
    </div>
</template>

<script>
import jsPDF from 'jspdf';
export default {
    props: {
        datareserve: String 
    },
    data() {
        return {
            reserve: JSON.parse(this.datareserve)
        }
    },
    mounted() {
        console.log(this.datareserve)
        console.log(this.reserve);
    },
    methods: {
        generatePDF() {
            let doc = new jsPDF();
            let reserve = this.reserve;
            let yPos = 5;

            let imageWidth = 15;
            let imageHeight = 15;
            let centerXImage = 10;
            let centerYImage = yPos;

            let imagePath = '../img/logo.png';
            this.loadImage(imagePath, function(imgData) {
                doc.addImage(imgData, 'PNG', centerXImage, centerYImage, imageWidth, imageHeight);
                yPos += 30;
                             
                let text = 'Resumen de la reserva';
                let textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
                let centerX = (doc.internal.pageSize.getWidth() - textWidth) / 2;
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(30);
                doc.text(text, centerX - (textWidth / 2), yPos);
                doc.setFont('helvetica', 'normal');
                doc.setFontSize(20);

                yPos += 20;
                reserve.forEach(function(value) {
                    let line1 = "Repartir en la ubicación: " + value.location + "\n";
                    let line2 = "Van a comer: " + value.people_eat;

                    let lines = doc.splitTextToSize(line1 + line2, 180);

                    lines.forEach(function(line, index) {
                        doc.text(line, 10, yPos + (index * 10));
                    });

                    yPos += (lines.length * 10) + 10;
                });

                doc.save('reserva.pdf');
            });
        },
        loadImage(url, callback) {
            let img = new Image();
            img.onload = function() {
                let canvas = document.createElement('canvas');
                let ctx = canvas.getContext('2d');
                canvas.width = this.width;
                canvas.height = this.height;
                ctx.drawImage(this, 0, 0);
                callback(canvas.toDataURL('image/png'));
            };
            img.src = url;
        },
        redirectToRoute() {
            if (!this.reserve) {
                window.location.href = '../explore';
            } else {
                window.location.href = '../delivery';
            }
        }
    }
}
</script>

<style scoped>
    .centered-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
    .button-pdf {
        margin-top: 20px;
        width: 100%;
        height: 50px;
        font-size: 1.25rem;
        background-color: #B48753;
        color: #FDF8EB;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: background-color 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .button-pdf::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.3) 50%, rgba(255, 255, 255, 0));
        transition: left 0.5s ease;
        z-index: 1;
    }

    .button-pdf:hover::before {
        left: 100%;
    }
    .button-confirm {
        position: absolute;
        bottom: 20px;
        right: 0;
        left: 0;
        margin: 0 auto;
        width: 90%;
        height: 70px;
        background-color: #984EAE;
        color: white;
        font-size: 2rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s ease;
    }
    .button-confirm:hover {
        background-color: #7a3a81;
        transform: scale(1.01);
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