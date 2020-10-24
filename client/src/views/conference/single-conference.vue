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
      <div v-else-if="!error && conference">
          <v-row v-if="editMode == false">
            <v-col cols="8">
                <v-card outlined tag="article">
                    <v-card-title> {{ conference.name }} </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>{{ conference.description }}</v-card-text>
                </v-card>

                <section class="my-5">
                    <v-card outlined>
                        <v-card-title>Information : </v-card-title>
                        <v-simple-table>
                            <tbody>
                                <tr>
                                    <td>Start</td>
                                    <td> {{ conference.start }} </td>
                                </tr>
                                <tr>
                                    <td>End </td>
                                    <td>{{ conference.end }}</td>
                                </tr>
                                <tr>
                                    <td>Country</td>
                                    <td>{{ conference.country }}</td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td>{{ conference.city }}</td>
                                </tr>
                                <tr>
                                    <td>Web Page</td>
                                    <td><a :href="conference.webpage">{{ conference.webpage }}</a></td>
                                </tr>
                            </tbody>
                        </v-simple-table>
                    </v-card>
                </section>

                <section>
                    <v-card outlined>
                        <v-card-title>Programe Commitee : </v-card-title>
                        <v-card-subtitle><span>Chairman : {{ conference.chair.name }}</span></v-card-subtitle>

                        <div v-if="conference.reviewers.length > 0">
                            <v-card-title class="subtitle-2 mb-n3" >Reviewers :</v-card-title>
                            <v-list dense>
                                <v-list-item v-for="reviewer in conference.reviewers" :key="reviewer.id">
                                    <v-list-item-content>{{ reviewer.user.name }}</v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </div>
                    </v-card>
                </section>

                <section v-if="isChair == true">
                    <v-card outlined class="mt-2 pa-2">
                        <v-card-actions>
                            <v-btn color="primary" @click.stop="editMode = !editMode" tile class="mr-2"> <v-icon left>mdi-pencil</v-icon> Edit Conference</v-btn>

                            <v-btn :loading="delete_loading" color="red" dark @click="destroy" tile> <v-icon left>mdi-trash-can-outline</v-icon> Delete Conference</v-btn>
                        </v-card-actions>
                    </v-card>
                </section>
                <section>
                    <v-card v-if="isChair == false" outlined class="mt-2 pa-2">
                        <v-card-actions>
                            <v-btn color="primary" tile class="mr-2" :to="submit_paper_link">Submit Paper </v-btn>
                        </v-card-actions>
                    </v-card>
                </section>
            </v-col>

            <v-col cols="3" v-if="conference">
                <v-card outlined v-if="isChair == true">
                    <v-list dense nav >
                        <v-list-item link v-for="(item, i) in side_menu" :key="i" :to="'/conference/' + conference.slug + '/' + item.text.toLowerCase()">
                        <v-list-item-icon>
                            <v-icon color="primary" v-text="item.icon" ></v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title v-text="item.text"></v-list-item-title>
                        </v-list-item-content>
                        </v-list-item>
                        <v-divider class="mb-2"></v-divider>
                        <!-- custom buttons -->
                        <v-list-item link>
                        <v-list-item-icon>
                            <v-icon color="primary">mdi-plus</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <!-- <v-list-item-title>Add a Reviewer</v-list-item-title> -->
                            <v-dialog v-model="dialog" persistent max-width="400">
                                <template v-slot:activator="{ on, attrs }">
                                    <list-item-title
                                    color="primary"
                                    class="subtitle-2"
                                    dark
                                    v-bind="attrs"
                                    v-on="on"
                                    >
                                    Add a Reviewer
                                    </list-item-title>
                                </template>
                                <v-card>
                                    <v-card-title class="headline">Add a Reviewer :</v-card-title>
                                    <v-divider></v-divider>
                                    <div class="px-3 pt-3">
                                        <p class="caption">Enter the Reviewer's email :</p>
                                        <v-text-field
                                            label="E-mail"
                                            placeholder="enter the reviewer email"
                                            outlined dense
                                            v-model="reviewer_email"
                                        ></v-text-field>
                                    </div>
                                    <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn :loading="reviewer_loading" color="primary" text @click="add_reviewer" :disabled="!reviewer_email">Add</v-btn>
                                    <v-btn color="red" text @click="dialog = false">cancel</v-btn>
                                    </v-card-actions>
                                    <v-alert
                                    dense
                                    text
                                    type="success" v-if="reviewer_added"
                                    >
                                    Reviwer added successfully !
                                    </v-alert>
                                    <v-alert
                                        dense
                                        outlined
                                        type="error" v-if="reviewer_error"
                                        >
                                        {{ reviewer_error }}
                                    </v-alert>
                                </v-card>
                            </v-dialog>
                        </v-list-item-content>
                        </v-list-item>
                        <!-- remove reviewers -->
                        <v-list-item link>
                        <v-list-item-icon>
                            <v-icon color="primary">mdi-minus</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <!-- <v-list-item-title>Add a Reviewer</v-list-item-title> -->
                            <v-dialog v-model="dialog_remove" persistent scrollable max-width="600">
                                <template v-slot:activator="{ on, attrs }">
                                    <list-item-title
                                    color="primary"
                                    class="subtitle-2"
                                    dark
                                    v-bind="attrs"
                                    v-on="on"
                                    @click.stop="open_dialog_remove_reviewers"
                                    >
                                    Remove Reviewer
                                    </list-item-title>
                                </template>
                                <v-card>
                                    <v-card-title class="headline">Remove Reviewer :</v-card-title>
                                    <v-divider></v-divider>
                                    <div class="px-3 pt-3">
                                        <p class="caption">Select reviewers to remove from the conference :</p>

                                        <v-data-table
                                        :lodaing="get_reviewers_loading"
                                        v-model="reviewers_selected"
                                        :headers="headers"
                                        :items="reviewers"
                                        item-key="id"
                                        show-select
                                        class="elevation-1"
                                        >
                                        <template v-slot:no-data>
                                        <p class="pa-3">There are no Reviewers for this conference</p>
                                        </template>
                                    </v-data-table>
                                        
                                    </div>
                                    <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn :loading="reviewer_loading" color="red" text @click="remove_reviewers">Remove</v-btn>
                                    <v-btn color="red" text @click="dialog_remove = false">cancel</v-btn>
                                    </v-card-actions>
                                    <v-alert
                                    dense
                                    text
                                    type="success" v-if="reviewers_removed"
                                    >
                                    Reviwer added successfully !
                                    </v-alert>
                                    <v-alert
                                        dense
                                        outlined
                                        type="error" v-if="reviewers_remove_error"
                                        >
                                        {{ reviewer_error }}
                                    </v-alert>
                                </v-card>
                            </v-dialog>
                        </v-list-item-content>
                        </v-list-item>

                        
                    </v-list>
                </v-card>
            </v-col>
        </v-row>
      </div>
      <EditConference :conference="conference" v-if="editMode == true" @closeEditMode="closeedit"></EditConference>
  </v-container>
</template>

<script>
import ConferenceService from '@/services/ConferenceService';
import EditConference from '@/components/conference/edit-conference.vue';


export default {
    props: ['slug'],
    components: {EditConference},
    data(){
        return {
            side_menu : [
                {icon : 'mdi-file-document-multiple-outline', text: 'Papers'},
                {icon : 'mdi-file-find', text: 'Reviews'},
                {icon : 'mdi-gavel', text: 'Bids'},
            ],
            conference : null,
            loading : false,
            error : null,
            editMode: false,
            delete_loading: false,

            dialog : false,
            reviewer_email: null,
            reviewer_loading: false,
            reviewer_error : null,
            reviewer_added : false,

            dialog_remove : false,
            get_reviewers_loading : false,
            reviewer_remove_loading : false,
            reviewers_selected: [],
            reviewers: [],
            reviewers_removed: false,
            reviewers_remove_error: null,
            headers: [
                    {
                    text: 'Reviewer Name',
                    align: 'start',
                    sortable: false,
                    value: 'user.name',
                    },
                    {
                    text: 'Paper Title',
                    align: 'start',
                    sortable: false,
                    value: 'paper.title',
                    },
            ],
            

        };
    },

    computed : {
        isChair(){ 
            return this.$store.getters['auth/user'].id == this.conference.chair.id; 
            },
        submit_paper_link(){
            return `/paper/create/conference/${this.conference.slug}`;
        }
    },

    created(){
        this.fetchConference();
    },

    watch : {
        '$route' : 'fetchConference',
    },

    methods : {
        async fetchConference(){
            this.error = false;
            this.conference = null;
            this.loading = true;

            
            try {
                const { data } = await ConferenceService.show(this.slug);
                this.error = null;
                this.loading = false;
                this.conference = data;
            } catch (error) {
                this.loading = false;
                this.conference = null;
                this.error = error.response.data;
            }
                

        },

        closeedit(conference){
            this.conference = conference;
            this.editMode = false;
        },

        async destroy(){
            try {
                this.delete_loading = true;
                await ConferenceService.delete(this.conference.slug);
                // display message
                window.flash('Conference has been deleted');
                this.delete_loading = false;
                this.$router.push('/my-conferences');
            } catch (error) {
                console.log(error);
            }
        },

        async add_reviewer(){
            try {
                this.reviewer_loading = true;
                this.reviewer_error = null;
                this.reviewer_added = false;
                await ConferenceService.add_reviewer(this.conference.slug, {
                    email : this.reviewer_email
                });
                this.reviewer_loading = false;
                this.reviewer_error = null;
                this.reviewer_added = true;
                this.reviewer_email = '';
            } catch (error) {
                this.reviewer_added = false;
                this.reviewer_loading = false;
                this.reviewer_error = error.response.data.message;
            }
        },

        open_dialog_remove_reviewers(){
            this.dialog_remove = true;
            this.get_reviewers();
        },

        async remove_reviewers(){
            try {
                this.reviewer_remove_loading = true;
                this.reviewers_remove_error = null;
                await ConferenceService.remove_reviewers(this.conference.slug, {
                    reviewers: this.reviewers_selected
                });
                this.reviewer_removed = true;
                this.reviewer_remove_loading = false;
                this.reviewers_remove_error = null;
                this.dialog_remove = false;
            } catch (error) {
                this.reviewer_removed = false;
                this.reviewer_loading = false;
                this.reviewers_remove_error = error.response.data.message;
            }
        },

        async get_reviewers(){
            try {
                this.get_reviewers_loading = true;
                this.reviewers_remove_error = null;
                const { data } = await ConferenceService.conferences_reviewers(this.conference.slug);
                this.reviewers = data;
                this.get_reviewers_loading = false;
                this.reviewers_remove_error = null;
            } catch (error) {
                this.get_reviewers_loading = false;
                this.reviewers_remove_error = error.response.data.message;
                console.log(error);
            }
        }

    },
}
</script>
