<template>
    <div class="provider-card" style="margin-top: 30px; display: flex;">
      <div class="provider-card-content" style="flex: 1;">
        <div class="provider-card-header">
          <h2>{{delivery[0].provider.nickname}}</h2>
          <button class="collect-delivery-btn" :disabled="!isWithinScheduleInterval">Recoger</button>
        </div>
        <div class="provider-card-body row gx-3">
          <div class="col-lg-6 col-sm-12">
              <div class="provider-products">
                  <p class="label-type-product mb-0 fs-6">Ubicación</p>
                  <p class="type-product"><strong>{{ delivery[0].provider.location }}</strong></p>
              </div>
          </div>
          <div class="col-lg-6 col-sm-12">
              <div class="provider-products">
                    <p class="label-type-product mb-0 fs-6">Horario</p>
                    <template v-if="delivery[0].provider.schedules.length > 0">
                        <p class="type-product"><strong>{{ closestSchedule.start_time }} - {{ closestSchedule.finish_time }}</strong></p>
                    </template>
                    <template v-else>
                        <p class="type-product"><strong>No hay horarios disponibles</strong></p>
                    </template>
              </div>
          </div>
        </div>
        <div class="d-flex justify-content-center flex-column">
            <template v-for="homeless in delivery">
                <markerCard :homeless="homeless.homeless"></markerCard>
            </template>
        </div>
        
    </div>
  </div>
</template>

<script>
import markerCard from './markerCard.vue';
export default {
    props: {
        delivery: Object
    },
    computed: {
      closestSchedule() {
        if (this.delivery[0].provider.schedules.length === 0) return null;

        let currentTime = new Date().getTime();
        let closest = this.delivery[0].provider.schedules[0];
        let closestDiff = Math.abs(currentTime - new Date("1970-01-01T" + closest.start_time).getTime());

        for (let i = 1; i < this.delivery[0].provider.schedules.length; i++) {
          let scheduleTime = new Date("1970-01-01T" + this.delivery[0].provider.schedules[i].start_time).getTime();
          let diff = Math.abs(currentTime - scheduleTime);

          if (diff < closestDiff) {
            closest = this.delivery[0].provider.schedules[i];
            closestDiff = diff;
          }
        }
        return closest;
      },
      isWithinScheduleInterval() {
        if (this.delivery.length > 0 && this.delivery[0].provider.schedules.length > 0) {
            const currentDate = new Date();

            const [startHours, startMinutes, startSeconds] = this.closestSchedule.start_time.split(':');

            currentDate.setHours(parseInt(startHours));
            currentDate.setMinutes(parseInt(startMinutes));
            currentDate.setSeconds(parseInt(startSeconds));

            const startTime = currentDate.getTime();

            const [finishHours, finishMinutes, finishSeconds] = this.closestSchedule.finish_time.split(':');

            currentDate.setHours(parseInt(finishHours));
            currentDate.setMinutes(parseInt(finishMinutes));
            currentDate.setSeconds(parseInt(finishSeconds));

            const finishTime = currentDate.getTime();

            const currentTime = new Date().getTime();
            return currentTime >= startTime && currentTime <= finishTime;
        }
        return false;
        }
    },
    mounted(){
        console.log('Provider:', this.delivery);
    },
    components: {
        markerCard
    }
}
</script>

<style scoped>
.provider-card {
    margin: 0 auto;
    width: 90%;
    border: 2px solid #B48753;
    border-radius: 5px;
  }

  .provider-card-content {
      padding: 10px;
  }

  .provider-card-header {
      margin-bottom: 10px;
      display: flex;
      justify-content: space-between;
  }
  .collect-delivery-btn {
    background-color: #B48753;
    color: #FDF8EB;
    width: 15%;
    min-width: 100px;
    font-size: 1rem;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  .collect-delivery-btn:disabled {
    background-color: #ac8f70;
    color: #FDF8EB;
    cursor: not-allowed;
    }
  .provider-card-body {
      display: flex;
      justify-content: center;
      width: 100%;
  }
  .provider-products {
    display: flex;
    flex-direction: column;
  }
</style>