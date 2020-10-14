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
                <v-card-title class="my-n2">{{user.name}} Papers :</v-card-title>
                <v-divider></v-divider>
                <v-data-table v-if="papers"
                    dense
                    fixed-header
                    :headers="headers"
                    :items="papers"
                    :items-per-page="10"
                    class="elevation-1"
                >
                
                    <template v-slot:no-data>
                        <span class="font-weight-bold">You have no Papers !</span>
                    </template>
                </v-data-table>

              </v-card>
          </v-col>
      </v-row>
  </v-container>
</template>

<script>
import PaperService from '@/services/PaperService';

export default {
    data(){
        return {
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
            loading : false,
            error: null
        }
    }, // end of data

    methods : {
        async fetchUserPapers(){
            this.error = false;
            this.loading = true;
            this.papers = [];
            
            try {
                const { data } = await PaperService.user_papers();
                this.error = null;
                this.loading = false;
                this.papers = data;
            } catch (error) {
                this.loading = false;
                this.papers = [];
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
        this.fetchUserPapers();
    },

    watch : {
        '$route' : 'fetchUserPapers',
    },
}
</script>

<style>

</style>