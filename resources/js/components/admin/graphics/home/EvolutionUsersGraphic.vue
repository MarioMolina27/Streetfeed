<template>
    <Chart type="line" :data="chartDataEvolutionUsers" :options="chartOptionsEvolutionUsers" class="line-graphic" />
</template>

<script>
import Chart from 'primevue/chart';
import { getEvolutionUsers } from '../../../../services/users.js'
export default {
    name: "EvolutionUsersGraphic",

    components: {
        Chart,
    },

    data() {
        return {
            chartDataEvolutionUsers: null,
            chartOptionsEvolutionUsers: null,
        };
    },
    mounted() {
        this.chartOptionsEvolutionUsers = this.setchartOptionsEvolutionUsers();
        this.loadData();
    },
    methods: {
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
        },

        loadData() {

            let labelsRiders
            let riders
            let labelsProviders
            let providers

            let promises = [
                getEvolutionUsers(1).then((response) => {
                    let keys = Object.keys(response[0]);
                    labelsRiders = keys;
                    riders = Object.values(response[0]);
                }),
                getEvolutionUsers(2).then((response) => {
                    let keys = Object.keys(response[0]);
                    labelsProviders = keys;
                    providers = Object.values(response[0]);
                })
            ];

            Promise.all(promises).then(() => {

                let ridersList = [];
                let providersList = [];

                for (let i = 0; i < Math.max(labelsRiders.length, labelsProviders.length); i++) {
                    ridersList.push({
                        label: labelsRiders[i] || labelsProviders[i],
                        data: riders[i] || (ridersList[i - 1] ? ridersList[i - 1].data : 0),
                    });

                    providersList.push({
                        label: labelsProviders[i] || labelRiders[i],
                        data: providers[i] || (providersList[i - 1] ? providersList[i - 1].data : 0),
                    });
                }


                this.chartDataEvolutionUsers = {
                    labels: providersList.map((item) => item.label),
                    datasets: [
                        {
                            label: 'Riders',
                            data: ridersList.map((item) => item.data),
                            fill: false,
                            borderColor: '#B48753',
                            tension: 0.4
                        },
                        {
                            label: 'Providers',
                            data: providersList.map((item) => item.data),
                            fill: false,
                            borderColor: '#984EAE',
                            tension: 0.4
                        }
                    ]
                };
            });
        }
    }
};
</script>

<style scoped>
.line-graphic {
    height: 40vh;
}
</style>