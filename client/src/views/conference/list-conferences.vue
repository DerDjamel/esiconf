<template>
  <div>
      <v-container class="py-1">
          <v-row>
              <v-col cols="4" v-for="n in 6" :key="n">
                  <MiniConference></MiniConference>
              </v-col>
          </v-row>
          <v-pagination color="primary" class="mt-0" :length="5" v-model="page"></v-pagination>
      </v-container>
  </div>
</template>

<script>
import MiniConference from '@/components/conference/mini-conference.vue';

export default {
    name : 'ListConferences',
    data(){
        return {
            page : 1,
        };
    },
    components: {MiniConference}
}
</script>

<style>

</style>