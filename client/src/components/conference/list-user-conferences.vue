<template>
  <v-container fluid style="overflow: auto">
    <v-alert
        border="left"
        colored-border
        type="error"
        elevation="2"
        dense
        v-if="error"
    >
        Oops ! something went wrong, try again !
    </v-alert>
      <v-row v-else class="justify-center align-center">
          <v-col cols="12">
              <v-card :loading="loading" outlined>
                <v-card-title class="my-n2">{{user.name}} Conferences :</v-card-title>
                <v-divider></v-divider>
                <v-data-table v-if="conferences"
                    
                    fixed-header
                    :headers="headers"
                    show-expand
                    :items="conferences"
                    :items-per-page="10"
                    class="elevation-1"
                >
                    <template v-slot:expanded-item="{ headers, item }">
                        <td :colspan="headers.length">
                            <v-btn class="ma-2" small tile outlined color="primary" :to="{ name: 'SingleConference', params: { slug: item.slug }}">show</v-btn>
                        </td>
                    </template>
                    <template v-slot:no-data>
                        You have no conferences !
                    </template>
                </v-data-table>

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
            error: null,
            loading: false,
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