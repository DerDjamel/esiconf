<template>
    <v-container>
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
        <v-row v-else-if="editMode == false && !error" class="justify-center  align-center" >
            <v-col cols="8">
                <article>
                    <v-card :loading="loading" outlined>
                        <div v-if="review">
                            <v-card-title class="text-h6 flex-column align-start mb-5"> 
                            <div>Review for :</div>
                            <div class="text-h4">{{ review.paper.title }}</div>
                            </v-card-title>
                            <v-divider></v-divider>
                            <v-simple-table>
                                <tbody>
                                    <tr>
                                        <td>Reviewer</td>
                                        <td>{{ review.reviewer.user.name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Conference</td>
                                        <td>{{ review.paper.conference.name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Opinion</td>
                                        <td>{{ review.opinion }}</td>
                                    </tr>
                                </tbody>
                            </v-simple-table>
                            <v-divider></v-divider>

                            <v-card-subtitle class="text-h6">The Review :</v-card-subtitle>
                            <v-card-text>{{ review.comment }}</v-card-text>
                            <v-card-actions v-if="review.is_reviewer">
                                <v-btn :loading="delete_review_loading" tile outlined color="red" @click.stop="delete_review">Delete Review</v-btn>

                                <v-btn color="primary" @click.stop="editMode = !editMode" tile class="mr-2"> <v-icon left>mdi-pencil</v-icon> Edit Review</v-btn>
                            </v-card-actions>
                        </div>
                    </v-card>
                </article>
                
            </v-col>
        </v-row>
        <EditReview :review="review" v-if="editMode == true" @closeEditMode="closeedit">Edit Review</EditReview>
    </v-container>
</template>

<script>
import ReviewService from '@/services/ReviewService';
import EditReview from '@/components/review/edit-review.vue';
export default {
    props: ['id'],
    components : {EditReview},
    data(){
        return {
            review : null,
            loading : false,
            error : null,
            editMode: false,
            delete_review_error : null,
            delete_review_loading : false,

            edit_review_error : null,
            edit_review_loading : false,
        };
    },

    created(){
        this.fetchReview();
    },

    watch : {
        '$route' : 'fetchReview',
    },

    methods : {
        async fetchReview(){
            this.error = false;
            this.review = null;
            this.loading = true;
            
            try {
                const { data } = await ReviewService.show(this.id);
                this.error = null;
                this.loading = false;
                this.review = data;
            } catch (error) {
                this.loading = false;
                this.review = null;
                this.error = error.response.data;
            }
                

        },

        async delete_review(){
            this.delete_review_error = null;
            this.delete_review.loading = true;
            try {
                const { data } = await ReviewService.delete(this.id);
                this.delete_review_error = null;
                this.delete_review.loading = false;
                console.log(data);
                this.$router.push('/my-reviews');
            } catch (error) {
                this.delete_review_error = error;
                this.delete_review.loading = false;
                console.log(error);
            }
        },

        closeedit(review){
            this.review = review;
            this.editMode = false;
            
        },

    },
}
</script>