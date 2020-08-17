<template>
  <v-container>
    <v-row class="justify-center align-center">
      <v-col cols="7">
        <v-card outlined>
          <v-card-subtitle class="mb-n5">Review for :</v-card-subtitle>
          <v-card-title class="text-h6">{{paper.title}}</v-card-title>
          <v-divider></v-divider>
          <v-form class="pa-5">
            <v-row class="justify-start">
              <v-col cols="6">
                <v-select
                  dense
                  :items="opinions"
                  label="Your Opinion"
                  v-model="opinion"
                  outlined
                ></v-select>
              </v-col>

              <v-col cols="12">
                <v-textarea
                  outlined
                  v-model="comment"
                  label="Comment :"
                  placeholder="Write your Review about this paper here"
                ></v-textarea>
              </v-col>
         
            </v-row>
          </v-form>
          <v-divider></v-divider>
          <v-card-actions class="d-flex justify-center my-2">
            <v-btn depressed color="primary" @click.stop="submitReview">Send Review</v-btn>
          </v-card-actions>

        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import ReviewService from '@/services/ReviewService';
import PaperService from '@/services/PaperService';


export default {
  props: ['id'],
  data: () => ({
    opinions : ['strong accept', 'accept', 'weak accept', 'borderline paper', 'weak reject', 'reject', 'strong reject'],
    paper : null,
    paper_loading : false,
    paper_error : null,
    loading: false,
    error: null,
    opinion : null,
    comment: null,
  }),

  created(){
      this.fetchPaper();
    },

    watch : {
      '$route' : 'fetchPaper',
    },

    methods : {
      async fetchPaper(){
        this.error = false;
        this.paper = null;
        this.loading = true;
            
        try {
          const { data } = await PaperService.show(this.id);
          this.paper_error = null;
          this.paper_loading = false;
          this.paper = data;
        } catch (error) {
          this.paper_loading = false;
          this.paper = null;
          this.paper_error = error.response.data;
        }
                

      },

      async submitReview(){
      try {
        const { data } = await ReviewService.store(this.id, {
          comment : this.comment,
          opinion: this.opinion,
          paper_id: this.paper.id,
        }); // and of request

        this.error = null;
        console.log(data);

        this.$router.push({ path : `/review/${data.review_id}` });

      } catch (error) {
        this.loading = false;
        this.error = error.response.data;
      }
    }

    }, // end methods

    
    

}
</script>
