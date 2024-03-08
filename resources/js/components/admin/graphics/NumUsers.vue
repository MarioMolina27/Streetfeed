<template>
    <Chart type="pie" :data="chartDataNumUsers" :options="chartOptionsNumUsers" class="pie-chart" />
</template>

<script>
import Chart from 'primevue/chart';

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
        this.chartDataNumUsers = this.setchartDataNumUsers();
        this.chartOptionsNumUsers = this.setchartOptionsNumUsers();
    },
    methods: {
        setchartDataNumUsers() {
            return {
                labels: ['Riders', 'Providers'],
                datasets: [
                    {
                        data: [540, 325],
                        backgroundColor: ['#B48753', '#984EAE' ],
                        hoverBackgroundColor: ['#B48753', '#984EAE']
                    }
                ]
            };
        },
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