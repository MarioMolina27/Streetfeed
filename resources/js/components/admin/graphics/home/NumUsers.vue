<template>
    <Chart type="pie" :data="chartDataNumUsers" :options="chartOptionsNumUsers" class="pie-chart" />
</template>

<script>
import Chart from 'primevue/chart';
import { getUsersTypesNumbers } from '../../../../services/users.js';

export default {
    name: "NumUsersGraphic",

    components: {
        Chart,
    },

    data() {
        return {
            chartDataNumUsers: null,
            chartOptionsNumUsers: null,
        };
    },
    mounted() {
        this.chartOptionsNumUsers = this.setchartOptionsNumUsers();
        this.getNums();
    },
    methods: {
        
        setchartOptionsNumUsers() {
            const documentStyle = getComputedStyle(document.documentElement);
            const textColor = documentStyle.getPropertyValue('--text-color');

            return {
                plugins: {
                    legend: {
                        labels: {
                            usePointStyle: true,
                            color: textColor
                        }
                    }
                }
            };
        },
        getNums() {
            getUsersTypesNumbers().then((response) => {
                this.chartDataNumUsers = {
                    labels: ['Riders', 'Providers'],
                    datasets: [
                        {
                            data: [response.riders, response.providers],
                            backgroundColor: ['#B48753', '#984EAE' ],
                            hoverBackgroundColor: ['#B48753', '#984EAE']
                        }
                    ]
                };
            })   
        }
    }
}

</script>

<style scoped>
    .pie-chart{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 40vh;
    }
</style>