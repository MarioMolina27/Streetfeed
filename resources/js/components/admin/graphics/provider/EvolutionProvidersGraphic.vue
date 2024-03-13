<template>
    <Chart type="line" :data="chartDataEvolutionUsers" :options="chartOptionsEvolutionUsers" class="line-graphic" />
</template>

<script>
import Chart from 'primevue/chart';
import { getEvolutionUsers } from '../../../../services/users.js'

export default {
    name: "EvolutionProvidersGraphic",

    components: {
        Chart,
    },

    data() {
        return {
            chartDataEvolutionUsers: null,
            chartOptionsEvolutionUsers: null,
            labels: [],
            providers: []
        };
    },
    mounted() {
        this.chartOptionsEvolutionUsers = this.setchartOptionsEvolutionUsers();
        this.loadData();
    },
    methods: {
        loadData(){
            getEvolutionUsers(2).then(response => {
                console.log(response);
                let keys = Object.keys(response[0]);
                    this.labels = keys;
                    this.providers = Object.values(response[0]);
                this.chartDataEvolutionUsers = {
                    labels: this.labels,
                    datasets: [
                        {
                            label: 'Providers',
                            data: this.providers,
                            fill: false,
                            borderColor: '#984EAE',
                            tension: 0.4
                        }
                    ]
                };
            });
        },
        setchartDataEvolutionUsers() {
            const documentStyle = getComputedStyle(document.documentElement);

            return {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [
                    {
                        label: 'Providers',
                        data: [28, 48, 40, 19, 86, 27, 90],
                        fill: false,
                        borderColor: '#984EAE',
                        tension: 0.4
                    }
                ]
            };
        },
        setchartOptionsEvolutionUsers() {
            const documentStyle = getComputedStyle(document.documentElement);
            const textColor = documentStyle.getPropertyValue('--text-color');
            const textColorSecondary = documentStyle.getPropertyValue('--text-color-secondary');
            const surfaceBorder = documentStyle.getPropertyValue('--surface-border');

            return {
                maintainAspectRatio: false,
                aspectRatio: 0.6,
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
                            color: textColorSecondary
                        },
                        grid: {
                            color: surfaceBorder
                        }
                    },
                    y: {
                        ticks: {
                            color: textColorSecondary
                        },
                        grid: {
                            color: surfaceBorder
                        }
                    }
                }
            };
        }
    }
};
</script>

<style scoped>
.line-graphic {
    height: 40vh;
}
</style>