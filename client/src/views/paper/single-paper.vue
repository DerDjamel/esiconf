<template>
    <v-container>
        <v-row class="justify-center  align-center">
            <v-col cols="8">
                <article>
                    <v-card outlined>
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
                        </v-card-actions>

                    </v-card>
                </article>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import PaperService from '@/services/PaperService';
import DownloadButton from '@/components/paper/download-btn.vue';


export default {
    props: ['id'],
    components : {DownloadButton},
    data(){
        return {
            paper : null,
            loading : false,
            error : null,
        };
    },

    computed : {
        paper_name(){
            return this.paper.path.slice(7);
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

    },
}
</script>