<template>
  <div class="home">
    <h1>This is your home man</h1>
    <BidForm></BidForm>
  </div>
</template>

<script>
import BidForm from '@/components/bid/bid-form.vue';

export default {
  name: 'Home',
  components: {BidForm},
  data(){
    return {
      
    };
  },
}
</script>
