<template>
  <v-container fluid style="overflow: auto">
      <v-row class="justify-center align-center">
          <v-col cols="12">
              <v-card outlined>
                <v-card-title class="my-n2">Papers of the conference :  {{ conference.name }} </v-card-title>
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
import ConferenceService from '@/services/ConferenceService';
export default {
    props: ['slug'],
    data(){
        return {
            conference : null,
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
        async fetchConferenceBids(){
            this.error = false;
            this.loading = true;

            this.conference = null;
            this.bids = [];
            
            try {
                const [firstResponse, secondRespons] = await Promise.all([
                    ConferenceService.show(this.slug),
                    ConferenceService.bids(this.slug)
                ]);
                this.error = null;
                this.loading = false;
                this.conference = firstResponse.data;
                this.bids = secondRespons.data;
            } catch (error) {
                this.loading = false;
                this.conference = null;
                this.bids = [];
                this.error = error.response.data;
            }
                

        },

    },

    created(){
        this.fetchConferenceBids();
    },

    watch : {
        '$route' : 'fetchConferenceBids',
    },
}
</script>

<style>

</style>