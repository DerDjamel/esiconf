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
                <v-card-title class="my-n2">Reviews of {{ conference.name }} : </v-card-title>
                <v-divider></v-divider>
                <v-data-table v-if="reviews"
                    dense
                    fixed-header
                    :headers="headers"
                    :items="reviews"
                    :items-per-page="10"
                    class="elevation-1"
                >
                    <template v-slot:no-data>
                        <span class="font-weight-bold">There are no Reviews !</span>
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
    props: ['slug'],
    data(){
        return {
            conference : null,
            loading : false,
            error : null,
            headers: [
                {
                    text : 'Paper Title',
                    value : 'title',
                    align: 'start',
                    width: '400',
                },
                {
                    text : 'Reviewer',
                    value : 'reviewer',
                    align: 'start',
                    width: '200',
                },
                {
                    text : 'Opinion',
                    value : 'opinion',
                    width: '100',
                },
                {
                    text : 'Comment',
                    value : 'comment',
                    width: '600',
                },
            ], // end of headers
            reviews : []
        }
    }, // end of data

    methods : {

        async fetchConferenceReviews(){
            this.error = false;
            this.loading = true;

            this.conference = null;
            this.reviews = [];
            
            try {
                const [firstResponse, secondRespons] = await Promise.all([
                    ConferenceService.show(this.slug),
                    ConferenceService.reviews(this.slug)
                ]);
                console.log([secondRespons.data]);
                this.error = null;
                this.loading = false;
                this.conference = firstResponse.data;
                this.reviews = secondRespons.data;
            } catch (error) {
                this.loading = false;
                this.conference = null;
                this.reviews = [];
                this.error = error.response.data;
            }
                

        },

    },

    created(){
        this.fetchConferenceReviews();
    },

    watch : {
        '$route' : 'fetchConferenceReviews',
    },


}
</script>

<style>

</style>