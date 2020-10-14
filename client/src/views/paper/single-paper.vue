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
        <v-row v-else-if="editMode == false && !error" class="justify-center  align-center">
            <v-col cols="8">
                <article>
                    <v-card :loading="loading" outlined>
                        <div v-if="paper">
                            <v-card-title class="text-h6 flex-column align-start mb-5"> 
                                <div>Paper :</div>
                            <div class="text-h4">{{ paper.title }}</div>
                            </v-card-title>
                            <v-divider></v-divider>
                            <v-simple-table>
                                <tbody>
                                    
                                </tbody>
                            </v-simple-table>
                            <v-simple-table>
                                <tbody>
                                    <tr>
                                        <td>Conference</td>
                                        <td>{{ paper.conference.name }}</td>
                                    </tr>
                                    <tr>
                                        <td>status</td>
                                        <td>{{ paper.status }}</td>
                                    </tr>
                                    <tr v-for="author in paper.authors" :key="author.id">
                                        <td>author</td>
                                        <td>{{author.user.name}}</td>
                                    </tr>
                                </tbody>
                            </v-simple-table>
                            <v-divider></v-divider>

                            <v-card-subtitle class="text-h6">The abstract :</v-card-subtitle>
                            <v-card-text>{{ paper.abstract }}</v-card-text>

                            <v-card-actions>
                                <DownloadButton :id='paper.id' :paper_name='paper_name'></DownloadButton>
                                <v-btn v-if="paper.is_reviewer" tile outlined color="primary" :to="review_paper_link">Review Paper</v-btn>
                                <v-btn tile outlined color="primary" @click.stop="editMode = !editMode" v-if="paper.is_author">Edit Paper</v-btn>
                                <v-btn class="mr-2" :loading="delete_loading" tile outlined color="red" v-if="paper.is_author" @click.stop="destroy">Withdraw Paper</v-btn> <br>
                                <BidForm :paper_id="paper.id" v-if="paper.is_reviewer"></BidForm>
                            </v-card-actions>
                        </div>
                    </v-card>
                </article>
            </v-col>
        </v-row>
        <EditPaper :paper="paper" v-if="editMode == true" @closeEditMode="closeedit"></EditPaper>
    </v-container>
</template>

<script>
import PaperService from '@/services/PaperService';
import DownloadButton from '@/components/paper/download-btn.vue';
import EditPaper from '@/components/paper/edit-paper.vue';
import BidForm from '@/components/bid/bid-form.vue';


export default {
    props: ['id'],
    components : {DownloadButton, EditPaper, BidForm},
    data(){
        return {
            paper : null,
            loading : false,
            error : null,

            delete_loading : false,
            delete_error : null,

            editMode: false,

        };
    },

    computed : {
        paper_name(){
            return this.paper.path.slice(7);
        },

        review_paper_link(){
            return `/review/create/paper/${this.paper.id}`;
        }
    },

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
                this.error = null;
                this.loading = false;
                this.paper = data;
            } catch (error) {
                this.loading = false;
                this.paper = null;
                this.error = error.response.data;
            }
                

        },

        async destroy(){
            try {
                this.delete_error = null;
                this.delete_loading = true;
                const { data } = await PaperService.destroy(this.paper.id);
                console.log(data);
                this.delete_error = null;
                this.delete_loading = false;
                this.$router.go(-1);

            } catch (error) {
                console.log(error);
            }
        },

        closeedit(paper){
            this.paper = paper;
            this.editMode = false;
            
        },

    },
}
</script>