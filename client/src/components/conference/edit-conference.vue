<template>
    <v-row class="justify-center align-center">
      <v-col cols="7">
        <v-card outlined>
          <v-card-title class="text-h6">Edit Conference :</v-card-title>
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
                  label="Name :"
                  v-model="name"
                ></v-text-field>
              </v-col>

              <v-col cols="5">
                <v-text-field
                  label="Abbreviation :"
                  placeholder="The Conference Abbreviation"
                ></v-text-field>
              </v-col>

              <v-col cols="12">
                <v-textarea
                  v-model="description"
                  outlined
                  label="Description :"
                  placeholder="Write a description that fits the Conference ."
                ></v-textarea>
              </v-col>


              <v-col cols="6">
                <v-autocomplete
                  dense
                  :items="countries"
                  label="Country"
                  outlined
                  v-model="country"
                ></v-autocomplete>
              </v-col>

              <v-col cols="6">
                <v-autocomplete
                  dense
                  :items="countries"
                  label="City"
                  outlined
                  v-model="city"
                ></v-autocomplete>
              </v-col>

              <v-col cols="10">
                <v-text-field
                  label="Web Page :"
                  placeholder="Conference Web Page"
                  v-model="webpage"
                ></v-text-field>
              </v-col>

              <v-col cols="3">
                <v-text-field
                  label="Start:"
                  type="date"
                  v-model="start"
                ></v-text-field>
              </v-col> 

              <v-col cols="3">
                <v-text-field
                  label="End:"
                  type="date"
                  v-model="end"
                ></v-text-field>
              </v-col>          
            </v-row>
          </v-form>
          <v-divider></v-divider>
          <v-card-actions class="d-flex justify-center my-2">
            <v-btn depressed color="primary" @click.stop="updateConference">Update Conference</v-btn>
            <v-btn depressed color="primary" @click.stop="cancelUpdate">Cancel</v-btn>
          </v-card-actions>

        </v-card>
      </v-col>
    </v-row>
</template>

<script>
import ConferenceService from '@/services/ConferenceService';
import countries from '@/utils/data/countries';
import cities from '@/utils/data/cities';

export default {
    props : ['conference'],
    data: () => ({
        countries : countries,
        cities : cities,
        name: null,
        description: null,
        country: null,
        city : null,
        start : null,
        end: null,
        webpage: null,
        error : null,
    }),

    computed : {
      setError(){
        return Object.values(this.error)[0][0];
      }
    },

    methods : {
        async updateConference(){

            try {
                this.loading = true;
                this.error = null;
                const { data } = await ConferenceService.update({
                name : this.name,
                description : this.description,
                country : this.country,
                city: this.city,
                start: this.start,
                end : this.end,
                webpage: this.webpage,
                slug: this.conference.slug,
                }); // and of request

                this.loading = false;
                this.error = null;
                this.$emit('closeEditMode', data.conference);

            } catch (error) {
                this.loading = false;
                this.error = error.response.data.errors;
            }
        },

        cancelUpdate(){
          this.$emit('closeEditMode', this.conference);
        }
    },

    created(){
        this.name = this.conference.name;
        this.description = this.conference.description;
        this.country = this.conference.country;
        this.city = this.conference.city;
        this.start = this.conference.start;
        this.end = this.conference.end;
        this.webpage = this.conference.webpage;   
    }

}
</script>

<style>

</style>