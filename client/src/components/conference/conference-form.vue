<template>
  <v-container>
    <v-row class="justify-center align-center">
      <v-col cols="7">
        <v-card outlined>
          <v-card-title class="text-h6">Create a Conference :</v-card-title>
          <v-divider></v-divider>
          <v-form class="pa-5">
            <v-row class="justify-start">
              <v-col cols="10">
                <v-text-field
                  label="Name :"
                  placeholder="Name of the Conference"
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
                  outlined
                  label="Description :"
                  placeholder="Write a description that fits the Conference ."
                ></v-textarea>
              </v-col>


              <v-col cols="6">
                <v-select
                  dense
                  :items="countries"
                  label="Country"
                  outlined
                ></v-select>
              </v-col>

              <v-col cols="6">
                <v-select
                  dense
                  :items="countries"
                  label="City"
                  outlined
                ></v-select>
              </v-col>

              <v-col cols="10">
                <v-text-field
                  label="Web Page :"
                  placeholder="Conference Web Page"
                ></v-text-field>
              </v-col>

              <v-col cols="3">
                <v-text-field
                  label="Start:"
                  type="date"
                ></v-text-field>
              </v-col> 

              <v-col cols="3">
                <v-text-field
                  label="End:"
                  type="date"
                ></v-text-field>
              </v-col>          
            </v-row>
          </v-form>
          <v-divider></v-divider>
          <v-card-actions class="d-flex justify-center my-2">
            <v-btn depressed color="primary">Create Conference</v-btn>
          </v-card-actions>

        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    countries : ['country', 'country', 'country', 'country',],
  }),
}
</script>

<style>

</style>