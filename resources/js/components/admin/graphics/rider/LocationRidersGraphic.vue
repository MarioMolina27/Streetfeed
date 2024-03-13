<template>
    <Chart type="bar" :data="chartData" :options="chartOptions" class="bar-graphic"  />
</template>

<script>
import Chart from 'primevue/chart';
import { getCitiesNumbers } from '../../../../services/adress.js'

export default {
    name: "LocationRidersGraphic",

    components: {
        Chart,
    },

    data() {
        return {
            chartData: null,
            chartOptions: null
        };
    },
    mounted() {
        this.loadData();
        this.chartOptions = this.setChartOptions();
    },
    methods: {
        loadData(){
            getCitiesNumbers(1).then(response => {
                let keys = Object.keys(response);
                let labels = keys;
                let values = Object.values(response);

                this.chartData = {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Locations Riders',
                            data: values,
                            backgroundColor: '#b48753dd',
                            borderColor: '#b48753',
                        }
                    ]
                };
            });
        },
        setChartOptions() {
            const documentStyle = getComputedStyle(document.documentElement);
            const textColor = documentStyle.getPropertyValue('--text-color');
            const textColorSecondary = documentStyle.getPropertyValue('--text-color-secondary');
            const surfaceBorder = documentStyle.getPropertyValue('--surface-border');

            return {
                maintainAspectRatio: false,
                aspectRatio: 0.8,
                plugins: {
                    legend: {
                        labels: {
                            color: textColor
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: textColorSecondary,
                            font: {
                                weight: 500
                            }
                        },
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    },
                    y: {
                        ticks: {
                            color: textColorSecondary
                        },
                        grid: {
                            color: surfaceBorder,
                            drawBorder: false
                        }
                    }
                }
            };
        }
    }
}
</script>

<style scoped>
    .bar-graphic {
        height: 40vh;
    }
</style>