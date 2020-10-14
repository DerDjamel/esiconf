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
            <v-btn depressed color="primary" @click.stop="updateReview">Edit Review</v-btn>
            <v-btn depressed color="primary" @click.stop="cancelUpdate">Cancel</v-btn>
          </v-card-actions>

        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import ReviewService from '@/services/ReviewService';


export default {
  props: ['review'],
  data: () => ({
    opinions : ['strong accept', 'accept', 'weak accept', 'borderline paper', 'weak reject', 'reject', 'strong reject'],
    loading: false,
    error: null,
    opinion : null,
    comment: null,
    paper : null,
    }),

    methods : {
      async updateReview(){
      try {
        this.loading = true;
        this.error = null;
        const { data } = await ReviewService.update(this.review, {
          comment : this.comment,
          opinion: this.opinion,
        }); // and of request
        this.loading = false;
        this.error = null;
        console.log(data);
        this.$emit('closeEditMode', data.review);

      } catch (error) {
        this.loading = false;
        this.loading = false;
        this.error = error.response.data;
      }
    },

    cancelUpdate(){
      this.$emit('closeEditMode', this.review);
    }
    }, // end methods

    
    created(){
        this.comment = this.review.comment;
        this.opinion = this.review.opinion;
        this.paper  = this.review.paper;
    }
    

}
</script>
