<template>
  <v-container fluid style="overflow: auto">
      <v-row class="justify-center align-center">
          <v-col cols="12">
              <v-card outlined>
                <v-card-title class="my-n2">{{user.name}} Conferences :</v-card-title>
                <v-divider></v-divider>
                <v-data-table
                    dense
                    fixed-header
                    :headers="headers"
                    :items="conferences"
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
    data(){
        return {
            headers: [
                {
                    text : 'Conference Name',
                    value : 'name',
                    align: 'start',
                    width: '400',
                },
                {
                    text : 'Description',
                    value : 'description',
                    align: 'start',
                    width: '300',
                },
                {
                    text : 'Country',
                    value : 'country',
                    width: '100',
                },
                {
                    text : 'City',
                    value : 'city',
                    width: '100',
                },
                {
                    text : 'Start',
                    value : 'start',
                    width: '150',
                },
                {
                    text : 'End',
                    value : 'end',
                    width: '150',
                },
                {
                    text : 'Web Page',
                    value : 'webpage',
                    width: '300',
                },
            ], // end of headers
            conferences : [],
        }
    }, // end of data

    methods : {
        async fetchUserConferences(){
            this.error = false;
            this.loading = true;
            this.conferences = [];
            
            try {
                const { data } = await ConferenceService.user_conferences();
                this.error = null;
                this.loading = false;
                this.conferences = data;
            } catch (error) {
                this.loading = false;
                this.conferences = [];
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
        this.fetchUserConferences();
    },

    watch : {
        '$route' : 'fetchUserConferences',
    },
}
</script>

<style>

</style>