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
      <v-row class="justify-center align-center">
          <v-col cols="12">
              <v-card outlined>
                <v-card-title class="my-n2">{{user.name}} Reviews :</v-card-title>
                <v-divider></v-divider>
                <v-data-table
                    dense
                    fixed-header
                    :headers="headers"
                    :items="reviews"
                    :items-per-page="10"
                    class="elevation-1"
                >
                    <template v-slot:no-data>
                        <span class="font-weight-bold">You have no Reviews !</span>
                    </template>
                </v-data-table>

              </v-card>
          </v-col>
      </v-row>
  </v-container>
</template>

<script>
import ReviewService from '@/services/ReviewService';

export default {
    data(){
        return {
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
            reviews : [],
        }
    }, // end of data

    methods : {
        async fetchUserReviews(){
            this.error = false;
            this.loading = true;
            this.reviews = [];
            
            try {
                const { data } = await ReviewService.user_reviews();
                this.error = null;
                this.loading = false;
                this.reviews = data;
            } catch (error) {
                this.loading = false;
                this.reviews = [];
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
        this.fetchUserReviews();
    },

    watch : {
        '$route' : 'fetchUserReviews',
    },
}
</script>

<style>

</style>