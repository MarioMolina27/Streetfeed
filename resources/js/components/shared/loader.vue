<template>
    <div class="loader-container">
        <div class="loader-frame">
            <div class="wave-loader wave-bg">
                <svg class="wave-svg" viewBox="0 0 8985 4304" xmlns="http://www.w3.org/2000/svg">
                    <path d="M956 201.651C576.068 23.1979 367.977 56.391 0 201.651V4304H8984.5V201.651C8444 -29.5282 8121.66 -102.445 7399 201.651C6887.01 378.914 6596.33 464.216 5971 201.651C5516.9 -41.6093 5241.52 -15.5667 4728.5 201.651C4093.9 387.065 3738.1 436.456 3103.5 201.651C2629.56 -8.61696 2377.76 -23.1882 1962.5 201.651C1580.53 362.031 1361.56 382.33 956 201.651Z"/>
                </svg>
            </div>
            <div class="wave-loader wave-fg">
                <svg class="wave-svg" viewBox="0 0 8985 4304" xmlns="http://www.w3.org/2000/svg">
                    <path d="M956 201.651C576.068 23.1979 367.977 56.391 0 201.651V4304H8984.5V201.651C8444 -29.5282 8121.66 -102.445 7399 201.651C6887.01 378.914 6596.33 464.216 5971 201.651C5516.9 -41.6093 5241.52 -15.5667 4728.5 201.651C4093.9 387.065 3738.1 436.456 3103.5 201.651C2629.56 -8.61696 2377.76 -23.1882 1962.5 201.651C1580.53 362.031 1361.56 382.33 956 201.651Z"/>
                </svg>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        loading: Boolean
    },
    watch: {
        loading: function (val) {
            if (!val) {
                setTimeout(() => this.finishLoading(), 500);
            }
        }
    },
    mounted() {
        setTimeout(() => Array.from(document.querySelectorAll('.wave-loader')).forEach(wave => wave.classList.add('start-loading')), 20);
    },
    methods: {
        finishLoading() {
            Array.from(document.querySelectorAll('.wave-loader')).forEach(wave => {
                wave.classList.add('end-loading');
                wave.addEventListener('transitionend', () => {
                    document.querySelector('.loader-frame').classList.add('fade-out')
                    setTimeout(() => this.$emit('loading-finished'), 500);
                });
            });
        }
    }
}

</script>

<style scoped>
.loader-container {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 999;
}

.loader-frame{
    position: relative;
    width: 20vw;
    aspect-ratio: 1/1;
    mask-image: url(/public/img/logo.svg);
    mask-repeat: no-repeat;
    mask-size: contain;
    overflow: hidden;
    z-index: 2000;
}

.fade-out.loader-frame{
    animation: fadeOut 0.6s;
    animation-iteration-count: 1;
    transform: scale(0);
}

.wave-loader{
    position: absolute;
    top: 100%;
    width: 300%;
    height: 115%;
    opacity: 1;
}

.wave-loader.start-loading{
    top: 40%;
    transition: top 5s cubic-bezier(0.31, 0.75, 0.58, 0.99);

}

.wave-loader.end-loading{
    top: -15%;
    transition: top 1s cubic-bezier(0.36, 0.11, 0.82, 0.29);
}

.wave-bg .wave-svg path{
    fill: #984EAE;
    /* filter: brightness(0.8); */
}

.wave-fg .wave-svg path{
    fill: #b48753;
}

.wave-bg{
    left: 0;
    transform: translateY(-20%);
    animation: horizontalMovementBg 7s infinite linear;
}

.wave-fg{
    right: 0;
    animation: horizontalMovementFg 7s infinite linear;
}

@keyframes horizontalMovementFg {
    0% {transform: translateX(calc(100% - 20vw))}
    50% {transform: translateX(0)}
    100% {transform: translateX(calc(100% - 20vw))}
}

@keyframes horizontalMovementBg {
    0% {transform: translate(calc(-100% + 20vw), -5%)}
    50% {transform: translate(0)}
    100% {transform: translate(calc(-100% + 20vw), -5%)}
}
@keyframes fadeOut {
    0%{ transform: scale(1);}
    75%{ transform: scale(1.3);}
    100%{ transform: scale(0);}
}
</style>