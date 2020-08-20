<template>
  <v-container fluid style="overflow: auto">
      <v-row class="justify-center align-center">
          <v-col cols="12">
              <v-card outlined>
                <v-card-title class="my-n2">{{user.name}} Bids :</v-card-title>
                <v-divider></v-divider>
                <v-data-table
                    dense
                    fixed-header
                    :headers="headers"
                    :items="bids"
                    :items-per-page="10"
                    class="elevation-1"
                ></v-data-table>

              </v-card>
          </v-col>
      </v-row>
  </v-container>
</template>

<script>
import BidService from '@/services/BidService';

export default {
    data(){
        return {
            headers: [
                {
                    text : 'Paper',
                    value : 'paper.title',
                    align: 'start',
                    width: '300',
                },
                {
                    text : 'Conference',
                    value : 'paper.conference.name',
                    align: 'start',
                    width: '250',
                },
                {
                    text : 'Reviewer',
                    value : 'reviewer.user.name',
                    width: '100',
                },
                {
                    text : 'Intrest Level',
                    value : 'intrest_level',
                    width: '100',
                },
            ], // end of headers
            bids : [],
        }
    }, // end of data

    methods : {
        async fetchUserBids(){
            this.error = false;
            this.loading = true;
            this.bids = [];
            
            try {
                const { data } = await BidService.user_bids();
                this.error = null;
                this.loading = false;
                this.bids = data;
            } catch (error) {
                this.loading = false;
                this.bids = [];
                this.error = error.response.data;
            }
                

        },

    },

    computed : {
        user(){
            return this.$store.getters['auth/user'];
        },
    },
        

    created(){
        this.fetchUserBids();
    },

    watch : {
        '$route' : 'fetchUserBids',
    },
}
</script>

<style>

</style>