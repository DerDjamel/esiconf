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
                    :items="papers"
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
                    text : 'Title',
                    value : 'title',
                    align: 'start',
                    width: '400',
                },
                {
                    text : 'Conference',
                    value : 'conference.name',
                    align: 'start',
                    width: '400',
                },
                {
                    text : 'Status',
                    value : 'status',
                    width: '100',
                },
                {
                    text : 'Authors',
                    value : 'authors',
                    width: '200',
                },
                {
                    text : 'Reviewers',
                    value : 'reviewers',
                    width: '200',
                },
            ], // end of headers
            papers : [],
        }
    }, // end of data

    methods : {
        async fetchConferencePapers(){
            this.error = false;
            this.loading = true;

            this.conference = null;
            this.papers = [];
            
            try {
                const [firstResponse, secondRespons] = await Promise.all([
                    ConferenceService.show(this.slug),
                    ConferenceService.papers(this.slug)
                ]);
                this.error = null;
                this.loading = false;
                this.conference = firstResponse.data;
                this.papers = secondRespons.data;
            } catch (error) {
                this.loading = false;
                this.conference = null;
                this.papers = [];
                this.error = error.response.data;
            }
                

        },

    },

    created(){
        this.fetchConferencePapers();
    },

    watch : {
        '$route' : 'fetchConferencePapers',
    },
}
</script>

<style>

</style>