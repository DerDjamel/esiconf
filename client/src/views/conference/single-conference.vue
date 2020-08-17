<template>
  <v-container>
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
                                <td>{{ conference.webpage }}</td>
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

                        <v-btn color="red" dark @click.stop="" tile> <v-icon left>mdi-trash-can-outline</v-icon> Delete Conference</v-btn>
                    </v-card-actions>
                </v-card>
            </section>
          </v-col>

          <v-col cols="3">
              <v-card outlined v-if="isChair == true">
                <v-list dense nav >
                    <v-list-item link v-for="(item, i) in side_menu" :key="i">
                    <v-list-item-icon>
                        <v-icon color="primary" v-text="item.icon" ></v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title v-text="item.text"></v-list-item-title>
                    </v-list-item-content>
                    </v-list-item>
                </v-list>
              </v-card>
          </v-col>
      </v-row>
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
                {icon : 'mdi-cog-outline', text: 'Settings',},
                {icon : 'mdi-file-document-multiple-outline', text: 'Papers',},
                {icon : 'mdi-file-find', text: 'Reviews',},
                {icon : 'mdi-gavel', text: 'Bids',},
                {icon : 'mdi-chart-bar', text: 'Stats',},
            ],
            conference : null,
            loading : false,
            error : null,
            editMode: false,
        };
    },

    computed : {
        isChair: function () { return this.$store.getters['auth/user'].id === this.conference.chair.id; }
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
        }

    },
}
</script>
