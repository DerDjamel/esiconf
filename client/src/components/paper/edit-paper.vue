<template>
  <v-container>
    <v-row class="justify-center align-center">
      <v-col cols="7">
        <v-card outlined>
          <v-card-title class="text-h6">Submit Paper to {{ paper.conference.name }}:</v-card-title>
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

              <v-col cols="12">
                <v-textarea
                  outlined
                  v-model="comment"
                  label="Comment :"
                  placeholder="Give you meesage to the Chairman here."
                ></v-textarea>
              </v-col>

              <v-col cols="5">
                <v-file-input disabled v-model="paper" label="Upload your Paper here" outlined dense></v-file-input>
              </v-col>

            </v-row>
          </v-form>
          <v-divider></v-divider>
          <v-card-actions class="d-flex justify-center my-2">
            <v-btn :loading="loading" depressed color="primary" @click.stop="updatePaper">Update Paper</v-btn>
            <v-btn depressed color="primary" @click.stop="cancelUpdate">Cancel</v-btn>
          </v-card-actions>

        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import PaperService from '@/services/PaperService';

export default {
  props: ['paper'],
  data: () => ({
    title   : null,
    abstract: null,
    comment : null,
    loading : false,
    error : null

  }),

  computed : {
    setError(){
      return Object.values(this.error)[0][0];
    }
  },

  methods : {
    async updatePaper(){
      try {
        this.loading = true;
        this.error = null;

        const {data} = await PaperService.update(this.paper.id, {
            title    : this.title,
            abstract : this.abstract,
            comment  : this.comment,
        });
        this.loading = false;
        this.error = null;
        console.log(data.paper);
        window.flash('Paper Updated successfully');
        this.$emit('closeEditMode', data.paper);
        

      } catch (error) {
        this.loading = false;
        this.error = error.response.data.errors;
      }
    },

    cancelUpdate(){
      this.$emit('closeEditMode', this.paper);
    }

  },

  created(){
        this.comment = this.paper.comment;
        this.title = this.paper.title;
        this.abstract = this.paper.abstract;
    }
}
</script>
