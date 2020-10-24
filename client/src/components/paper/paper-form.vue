<template>
  <v-container>
    <v-row class="justify-center align-center">
      <v-col cols="7">
        <v-card outlined v-if="conference">
          <v-card-title class="text-h6">Submit Paper to {{ conference.name }}:</v-card-title>
          <v-divider></v-divider>
          <v-alert
            dense
            outlined
            type="error" v-if="error"
          >
            {{ setError }}
          </v-alert>
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

              <v-col cols="10">
                <p class="caption mb-n1">Write the email of all the authors and press entre to store it</p>
                <v-combobox
                  v-model="emails"
                  label="Email of authors here"
                  multiple
                  chips flat
                >
                </v-combobox>
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
            <v-btn :loading="loading" depressed color="primary" @click.stop="submitPaper">Submit Paper</v-btn>
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
    author: null,

    loading: false,
    error: null,

    emails : null,
  }),

  created(){
    this.fetchConference();
  },

  computed : {
    setError(){
      return Object.values(this.error)[0][0];
    }
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
        this.loading = true;
        this.error = null;
        const paper_data = new FormData();
        paper_data.append('paper', this.paper);
        paper_data.append('abstract', this.abstract);
        paper_data.append('comment', this.comment);
        paper_data.append('title', this.title);
        paper_data.append('author[]', this.author);
        paper_data.append('conference_id', this.conference.id);

        this.emails.forEach((email) => {
          paper_data.append('author[]', email);
        });

        const {data} = await PaperService.store(paper_data);
        this.loading = false;
        this.error = null;
        window.flash('Paper Created successfully');
        this.$router.push(`/paper/${data.paper.id}`);
        

      } catch (error) {
        this.loading = false;
        this.error = error.response.data.errors;
      }
    }

  },
}
</script>
