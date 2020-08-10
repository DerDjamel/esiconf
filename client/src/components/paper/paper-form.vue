<template>
  <v-container>
    <v-row class="justify-center align-center">
      <v-col cols="7">
        <v-card outlined>
          <v-card-title class="text-h6">Submit Paper to the Title of conference :</v-card-title>
          <v-divider></v-divider>
          <v-form class="pa-5">
            <v-row class="justify-start">
              <v-col cols="10">
                <v-text-field
                  label="Title :"
                  placeholder="Title of the Paper"
                ></v-text-field>
              </v-col>

              <v-col cols="12">
                <v-textarea
                  outlined
                  label="Abstract :"
                  placeholder="Description about the Paper"
                ></v-textarea>
              </v-col>

              <v-col cols="12">
                <v-textarea
                  outlined
                  label="Comment :"
                  placeholder="Give you meesage to the Chairman here."
                ></v-textarea>
              </v-col>

              <v-col cols="5">
                <v-file-input label="Upload your Paper here" outlined dense></v-file-input>
              </v-col>

            </v-row>
          </v-form>
          <v-divider></v-divider>
          <v-card-actions class="d-flex justify-center my-2">
            <v-btn depressed color="primary">Submit Paper</v-btn>
          </v-card-actions>

        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
    data: () => ({
        opinions : ['strongly good', 'not good']
    }),
}
</script>
