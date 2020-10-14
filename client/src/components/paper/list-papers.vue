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
              <v-card outlined :loading="loading">
                <v-card-title class="my-n2">
                    Papers of the conference :  {{ conference.name }} 
                    </v-card-title>
                <v-divider></v-divider>
                <v-data-table v-if="papers"
                    show-expand
                    fixed-header
                    :headers="headers"
                    :items="papers"
                    :items-per-page="10"
                    class="elevation-1"
                    :search="search"
                >
                    <template v-slot:expanded-item="{ headers, item }">
                        <td :colspan="headers.length">
                            <v-btn class="ma-2" small tile outlined color="red" @click="reject_paper(item.id)">Reject</v-btn>
                            <v-btn class="ma-2" small tile outlined color="primary" @click="accept_paper(item.id)">Accept</v-btn>
                            <v-btn class="ma-2" small tile outlined color="primary" :to="{ name: 'SinglePaper', params: { id: item.id }}">show</v-btn>
                            

                            <v-dialog v-model="dialog" scrollable max-width="400px">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn @click.stop="open_dialog" v-bind="attrs" v-on="on" class="ma-2" small tile outlined color="primary">Assign Reviewers</v-btn>
                                </template>
                                <v-card>
                                    <v-card-title>Assign Reviewers</v-card-title>
                                    <v-card-subtitle>All the Conference Reviewers are shown below :</v-card-subtitle>
                                    <v-divider></v-divider>
                                    <v-card-text style="height: 300px;">
                                    
                                        <v-checkbox v-for="reviewer in reviewers" :key='reviewer.id' v-model="selected_reviewers" :value='reviewer.id' :label='reviewer.user.name'></v-checkbox>
                                    
                                    </v-card-text>
                                    <v-divider></v-divider>
                                    <v-card-actions>
                                    <v-btn tile outlined color="red" @click="dialog = false">Cancel</v-btn>
                                    <v-btn tile outlined color="primary" @click="assign_reviewers(item.id)">Assign</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </td>
                    </template>
                    <template v-slot:no-data>
                        <span class="font-weight-bold">There are no Papers !</span>
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
            search : '',
            dialog: false,
            selected_reviewers : [],
            conference : null,
            reviewers: [],
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
            loading: false,
            error : null
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

        async assign_reviewers(paper_id){
            try {
                const { data } = await PaperService.assign_reviewers(paper_id, { ids : this.selected_reviewers});
                console.log(data);
                let reviewers_names = '';
                this.selected_reviewers.forEach( id => {
                    reviewers_names += this.reviewers[this.reviewers.findIndex( reviewer => reviewer.id == id )].user.name + ', ';
                });
                
                this.papers[this.papers.findIndex(paper => paper.id == paper_id)].reviewers = reviewers_names.trim();
                this.reviewers = [];
                this.selected_reviewers = [];
                this.dialog = false;


            } catch (error) {
                console.log(error);
            }
        },

        change_paper_status(id, status){
            const i = this.papers.findIndex(paper => paper.id = id);
            this.papers[i].status = status;
            return;
        },

        open_dialog(){
            this.dialog = true;
            this.get_reviewers();
        },

        async get_reviewers(){
            try {
                const { data } = await ConferenceService.reviewers(this.conference.slug);
                this.reviewers = data;
            } catch (error) {
                console.log(error);
            }
        }

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