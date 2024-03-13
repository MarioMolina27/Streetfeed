<template>
    <Chart type="bar" :data="chartData" :options="chartOptions" class="bar-graphic"  />
</template>

<script>
import Chart from 'primevue/chart';
import { getDeliveriesByMonth } from '../../../../services/delivery.js';

export default {
    name: "DeliveryHistoryGraphic",

    components: {
        Chart,
    },

    data() {
        return {
            chartData: null,
            chartOptions: null,
        };
    },
    mounted() {
        this.chartOptions = this.setChartOptions()
        this.loadData()
    },
    methods: {
        loadData() {
            getDeliveriesByMonth().then((response) => {
                let keys = Object.keys(response[0])
                let labels = keys
                let deliveries = Object.values(response[0])
                this.chartData = {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Deliveries',
                            backgroundColor: '#081733dd',
                            borderColor: '#081733',
                            data: deliveries
                        }
                    ]
                };
            })   
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