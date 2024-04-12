<template>
<div class="provider-card" :class="{ 'provider-active': active }" @click="handleClick">
    <strong>{{ information.nickname }}</strong>
</div>
</template>

<script>
export default {
    props: {
        information: Object,
        active: Boolean,
        translations: Object
    },
    data() {
        return {
            
        }
    },
    computed: {
      isActive() {
          return this.active ? 'provider-active' : '';
      }  
    },
    methods: {
        handleClick() {
            if (!this.active) {
                this.$emit('childClick', this.information);
            }
        }
    },
    mounted() {
        
    },
}
</script>

<style scoped>
.provider-card {
  width: 22rem;
  display: flex;
  flex: 0 0 auto;
  align-items: center;
  justify-content: center;
  border: 3px solid #B48753;
  background-color: #FDF8EB;
  border-radius: 5px;
  transition: transform 0.2s ease;
}
.provider-card:hover:not(.provider-active) {
  cursor: pointer;
}
.provider-active {
    background-color: #B48753;
    color: #FDF8EB;
}
</style>