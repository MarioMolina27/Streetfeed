<template>
    <Chart type="line" :data="chartDataEvolutionUsers" :options="chartOptionsEvolutionUsers" class="line-graphic" />
</template>

<script>
import Chart from 'primevue/chart';
export default {
    name: "EvolutionUsersGraphic",

    components: {
        Chart,
    },

    data() {
        return {
            chartDataEvolutionUsers: null,
            chartOptionsEvolutionUsers: null
        };
    },
    mounted() {
        this.chartDataEvolutionUsers = this.setchartDataEvolutionUsers();
        this.chartOptionsEvolutionUsers = this.setchartOptionsEvolutionUsers();
    },
    methods: {
        setchartDataEvolutionUsers() {
            const documentStyle = getComputedStyle(document.documentElement);

            return {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [
                    {
                        label: 'Riders',
                        data: [65, 59, 80, 81, 56, 55, 40],
                        fill: false,
                        borderColor: '#B48753',
                        tension: 0.4
                    },
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