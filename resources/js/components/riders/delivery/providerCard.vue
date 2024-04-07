<template>
    <div class="provider-card" style="margin-top: 30px; display: flex;">
      <div class="provider-card-content" style="flex: 1;">
        <div class="provider-card-header mb-4">
          <h2 class="mb-0"><strong>{{delivery[0].provider.nickname}}</strong></h2>
          <button v-if="isCollectButtonActive" class="collect-delivery-btn" :disabled="!isCollectButtonActive" @click="doCollect">Recoger</button>
          <span v-if="!isWithinSchedule" class="not-open ms-5" style="font-size: 15px; text-align: end;">El recinto se encuentra cerrado</span> 
        </div>
        <div class="provider-card-body row gx-3 ps-0">
          <div class="col-lg-6 col-sm-12">
              <div class="provider-products">
                  <p class="label-type-product mb-0 fs-6">Ubicación</p>
                  <p class="type-product"><strong>{{ delivery[0].provider.location }}</strong></p>
              </div>
          </div>
          <div class="col-lg-5 col-8">
              <div class="provider-products">
                    <p class="label-type-product mb-0 fs-6">Horario</p>
                    <template v-if="delivery[0].provider.schedules.length > 0">
                        <p class="type-product"><strong>{{ closestSchedule.start_time }} - {{ closestSchedule.finish_time }}</strong><span v-if="!isWithinSchedule" class="not-open ms-2">(Cerrado)</span></p>
                    </template>
                    <template v-else>
                        <p class="type-product"><strong>No hay horarios disponibles</strong></p>
                    </template>
              </div>
          </div>
          <div class="col-lg-1 col-4 d-flex justify-content-end">
              <div v-if="isChatAvailable" class="button-chat" @click.stop="showChat(delivery[0].provider)">
                <i class="fa-solid fa-comment" style="color: #FDF8EB;"></i>
              </div>
          </div>
        </div>
        <div class="d-flex justify-content-center flex-column">
            <template v-for="homeless in delivery">
                <markerCard :homeless="homeless.homeless" @notifyDeliver="notifyDeliver"></markerCard>
            </template>
        </div>
    </div>
  </div>
  <Dialog v-model:visible="showChatDialog" modal class="dialog-responsive">
    <Chat :user="userChat" :loggedUser="userLogged"/>
  </Dialog>
</template>

<script>
import markerCard from './markerCard.vue';
import Dialog from 'primevue/dialog';
import Chat from '../../shared/chat/chat.vue';
export default {
    props: {
        delivery: Object
    },
    data() {
      return {
        showChatDialog: false,
        userChat: {},
        userLogged: 4,
      }
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
      isCollectButtonActive() {
        if (!this.areAllDeliveriesHomeless && this.isWithinSchedule) {
            return true;
        }
        return false;
      },
      areAllDeliveriesHomeless() {
          let allDeliveriesHomeless = true;
          let i = 0;
          while (i < this.delivery.length && allDeliveriesHomeless) {
              if (this.delivery[i].homeless.status !== 2) {
                  allDeliveriesHomeless = false;
              }
              i++;
          }
          return allDeliveriesHomeless;
      },
      isWithinSchedule() {
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
      },
      isChatAvailable() {
        for (let i = 0; i < this.delivery.length; i++) {
            if (this.delivery[i].homeless.status === 1) {
                return true;
            }
        }
      },
    },
    methods: {
        doCollect() {
          this.$emit('collectDelivery', this.getIdDeliveriesWithStatusOne());
        },
        getIdDeliveriesWithStatusOne() {
            let ids = [];
            for (let i = 0; i < this.delivery.length; i++) {
                if (this.delivery[i].homeless.status === 1) {
                    ids.push(this.delivery[i].homeless.idDelivery);
                }
            }
            return ids;
        },
        notifyDeliver(idDelivery) {
          this.$emit('notifyDeliver', idDelivery);
        },
        showChat(user) {
          console.log(user);
          this.userChat = user;
          this.showChatDialog = true;
        }
    },
    components: {
        markerCard,
        Dialog,
        Chat,
    }
}
</script>

<style scoped>
.provider-card {
    margin: 0 auto;
    width: 90%;
    border: 2px solid #B48753;
    border-radius: 5px;
    box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
  }

  .provider-card-content {
      padding: 10px;
  }

  .provider-card-header {
      margin-bottom: 10px;
      display: flex;
      justify-content: space-between;
  }
  .p-tag {
      background-color: #B48753;
      color: #FDF8EB;
      padding: 0rem 0.4rem;
  }
  .button-chat {
    width: 40px;
    height: 40px;
    background-color: #B48753;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: 0.3s ease;
  }
  .button-chat:hover {
    background-color: #b17a3b;
    transform: scale(1.05);
  }
  .collect-delivery-btn {
    background-color: #B48753;
    color: #FDF8EB;
    width: 15%;
    height: 40px;
    min-width: 100px;
    font-size: 1rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  .collect-delivery-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    }
  .not-open {
      color: #B52A2A;
      font-weight: 600;
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