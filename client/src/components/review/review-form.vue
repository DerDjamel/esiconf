<template>
  <v-container>
    <v-row class="justify-center align-center">
      <v-col cols="7">
        <v-card outlined>
          <v-card-subtitle class="mb-n5">Review for :</v-card-subtitle>
          <v-card-title class="text-h6">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Repudianda</v-card-title>
          <v-divider></v-divider>
          <v-form class="pa-5">
            <v-row class="justify-start">
              <v-col cols="6">
                <v-select
                  dense
                  :items="opinions"
                  label="Your Opinion"
                  outlined
                ></v-select>
              </v-col>

              <v-col cols="12">
                <v-textarea
                  outlined
                  label="Comment :"
                  placeholder="Write your Review about this paper here"
                ></v-textarea>
              </v-col>
         
            </v-row>
          </v-form>
          <v-divider></v-divider>
          <v-card-actions class="d-flex justify-center my-2">
            <v-btn depressed color="primary">Send Review</v-btn>
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
