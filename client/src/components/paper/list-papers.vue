<template>
  <v-container fluid style="overflow: auto">
      <v-row class="justify-center align-center">
          <v-col cols="12">
              <v-card outlined>
                <v-card-title class="my-n2">Papers of the conference :  {{ conference.name }} </v-card-title>
                <v-divider></v-divider>
                <v-data-table
                    show-expand
                    fixed-header
                    :headers="headers"
                    :items="papers"
                    :items-per-page="10"
                    class="elevation-1"
                >
                    <template v-slot:expanded-item="{ headers, item }">
                        <td :colspan="headers.length">
                            <v-btn class="ma-2" small tile outlined color="red" @click="reject_paper(item.id)">Reject</v-btn>
                            <v-btn class="ma-2" small tile outlined color="primary" @click="accept_paper(item.id)">Accept</v-btn>
                            <v-btn class="ma-2" small tile outlined color="primary">show</v-btn>
                            <v-btn class="ma-2" small tile outlined color="primary">Assign Reviewers</v-btn>
                        </td>
                    </template>
                </v-data-table>

              </v-card>
          </v-col>
      </v-row>
  </v-container>
</template>

<script>
import ConferenceService from '@/services/ConferenceService';
import PaperService from '@/services/PaperService';
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

        async accept_paper(id){
            try {
                await PaperService.accept_paper(id);
                this.change_paper_status(id, 'accepted');
            } catch (error) {
                console.log(error);
            }
        },

        async reject_paper(id){
            try {
                await PaperService.reject_paper(id);
                this.change_paper_status(id, 'rejected');
            } catch (error) {
                console.log(error);
            }
        },

        change_paper_status(id, status){
            const i = this.papers.findIndex(paper => paper.id = id);
            this.papers[i].status = status;
            return;
        },

    }, // end of methods

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