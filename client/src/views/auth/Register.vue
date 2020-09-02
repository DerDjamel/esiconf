<template>
  <v-container>
    <v-row class="justify-center align-center">
      <v-col cols="7">
        <v-card outlined>
          <v-card-title class="text-h6">Register :</v-card-title>
          <v-divider></v-divider>
          <v-form class="pa-5">
            <v-row class="justify-start">
              <v-col cols="10">
                <v-text-field
                  label="Name :"
                  placeholder="Your Full Name"
                  v-model="name"
                ></v-text-field>
              </v-col>

            <v-col cols="10">
                <v-text-field
                  label="E-mail"
                  placeholder="You E-mail"
                  v-model="email"
                  type='email'
                ></v-text-field>
            </v-col>

            <v-col cols="10">
                <v-text-field
                  label="password"
                  placeholder="Your Password"
                  v-model="password"
                  type='password'
                ></v-text-field>
            </v-col>

              <v-col cols="10">
                <v-text-field
                  label="Organization :"
                  placeholder="Your Organization"
                  v-model="org"
                ></v-text-field>
              </v-col>

              <v-col cols="10">
                <v-text-field
                  label="Job :"
                  placeholder="Your Job in this Organization"
                  v-model="job"
                ></v-text-field>
              </v-col>

              <v-col cols="4">
                <v-select
                  dense
                  :items="countries"
                  label="Country"
                  outlined
                  v-model="country"
                ></v-select>
              </v-col>


              <v-col cols="12">
                <v-row>
                    <v-col cols="2" class="mr-n8">
                        <v-avatar>
                            <v-icon v-if="!photo">mdi-account-circle-outline</v-icon>
                            <img v-else :src="avatar">
                        </v-avatar>
                    </v-col>
                    <v-col cols="5">
                        <v-file-input v-model="photo" label="Your Profile Photo" outlined dense></v-file-input>
                    </v-col>
                </v-row>
              </v-col>

            </v-row>
          </v-form>
          <v-divider></v-divider>
          <v-card-actions class="d-flex justify-center my-2">
            <v-btn depressed color="primary" @click.stop="avatar" class="pa-5">Register</v-btn>
          </v-card-actions>

        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>

import AuthenticationService from '@/services/AuthenticationService';

export default {
  props: ['slug'],
  data: () => ({
    countries : ['country', 'country', 'country', 'country',],
    name: null,
    email: null,
    password:null,
    org: null,
    country: null,
    photo: null,
    job: null,
    loading: false,
    error : null,
  }),

  computed : {
    avatar(){
        return URL.createObjectURL(this.photo);
    }
  },

  methods : {
    async register(){
      try {
        this.loading = true;
        this.error = null;

        const user = new FormData();
        user.append('name', this.name);
        user.append('email', this.email);
        user.append('password', this.password);
        user.append('organization', this.organization);
        user.append('country', this.country);
        user.append('job', this.job);
        user.append('photo', this.photo);
        await AuthenticationService.register(user);

        this.loading = false;
        this.error = null;

        this.$router.push({ name : "Login" });
      } catch (error) {
        this.loading = false;
        this.error = error.response.data;
        console.log(error);
      }
    },

  },
}

</script>
