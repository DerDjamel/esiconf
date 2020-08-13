<template>
    <v-container>
        <v-row class="justify-center  align-center">
            <v-col cols="8">
                <article>
                    <v-card outlined>
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

                    </v-card>
                </article>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import ReviewService from '@/services/ReviewService';



export default {
    props: ['id'],
    data(){
        return {
            review : null,
            loading : false,
            error : null,
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

    },
}
</script>