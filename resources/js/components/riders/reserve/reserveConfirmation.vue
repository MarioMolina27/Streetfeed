<template>
    <div>
        <h1>Reserve Confirmation</h1>
        <button @click="generatePDF">Generar PDF</button>
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
        console.log(this.reserve);
        
    },
    methods: {
        generatePDF() {
            let doc = new jsPDF();
            doc.text('Reserva confirmada', 10, 10);
            this.reserve.forEach(function(value) {
                doc.text("En la ubicación: " + value.location + "\t van a comer: " + value.people_eat, 10, 10);
                doc.text("\n", 10, 10);
            });
            doc.save('reserva.pdf');               
        }
    }
}
</script>

<style>

</style>