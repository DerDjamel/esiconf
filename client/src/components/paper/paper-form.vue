<template>
  <v-container>
    <v-row class="justify-center align-center">
      <v-col cols="7">
        <v-card outlined>
          <v-card-title class="text-h6">Submit Paper to {{ conference.name }}:</v-card-title>
          <v-divider></v-divider>
          <v-form class="pa-5">
            <v-row class="justify-start">
              <v-col cols="10">
                <v-text-field
                  label="Title :"
                  placeholder="Title of the Paper"
                  v-model="title"
                ></v-text-field>
              </v-col>

              <v-col cols="12">
                <v-textarea
                  outlined
                  v-model="abstract"
                  label="Abstract :"
                  placeholder="Description about the Paper"
                ></v-textarea>
              </v-col>

              <v-col cols="12">
                <v-textarea
                  outlined
                  v-model="comment"
                  label="Comment :"
                  placeholder="Give you meesage to the Chairman here."
                ></v-textarea>
              </v-col>

              <v-col cols="5">
                <v-file-input v-model="paper" label="Upload your Paper here" outlined dense></v-file-input>
              </v-col>

            </v-row>
          </v-form>
          <v-divider></v-divider>
          <v-card-actions class="d-flex justify-center my-2">
            <v-btn depressed color="primary" @click.stop="submitPaper">Submit Paper</v-btn>
          </v-card-actions>

        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import PaperService from '@/services/PaperService';
import ConferenceService from '@/services/ConferenceService';

export default {
  props: ['slug'],
  data: () => ({
    conference : null,
    conference_loading : false,
    conference_error : null,
    title: null,
    abstract: null,
    comment: null,
    paper: null,
  }),

  created(){
    this.fetchConference();
  },

  watch : {
    '$route' : 'fetchConference',
  },

  methods : {
    async fetchConference(){
      this.conference_error = false;
      this.conference = null;
      this.conference_loading = true;
            
      try {
          const { data } = await ConferenceService.show(this.slug);
          this.conference_error = null;
          this.conference_loading = false;
          this.conference = data;
      } catch (error) {
          this.conference_loading = false;
          this.conference = null;
          this.conference_error = error.response.data;
      }
    },

    async submitPaper(){
      try {
        const { data } = await PaperService.store({
          title : this.title,
          abstract: this.abstract,
          comment : this.comment,
          conference_id : this.conference.id,
          author: 1,
          paper: this.paper,
        }); // and of request

        this.error = null;
        console.log(data);

        // this.$router.push({ path : `/conference/${data.conference.slug}` });

      } catch (error) {
        console.log(error);
      }
    }

  },
}
</script>
