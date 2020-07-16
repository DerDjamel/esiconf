<template>
    <v-container>
        <v-row class="flex-column" justify="center" align="center">

            <!-- Login title -->
            <v-col cols="5">
                <v-card flat>
                    <v-card-title class="justify-center">
                        <h2 class="title font-weight-bold text-uppercase">Login</h2>
                    </v-card-title>
                </v-card>
                
            </v-col>

            <!-- the Form for the login -->
            <v-col md="4" sm="6" cols="10">
                <v-form ref="loginForm" v-model="valid">
                    
                    <!-- Email field -->
                    <v-text-field
                    label="Email"
                    type="text"
                    v-model="email"
                    autofocus
                    clearable
                    outlined
                    dense
                    :rules="emailRules"
                    ></v-text-field>

                    <!-- Password field -->
                    <v-text-field
                    type="password"
                    label="Password"
                    v-model="password"
                    clearable
                    outlined
                    dense
                    :rules="passwordRules"
                    ></v-text-field>
                </v-form>
                
            </v-col>

            <!-- Login button -->
            <v-col cols="5" class="d-flex justify-center align-center">
                <v-btn 
                depressed
                large
                color="primary"
                @click="login"
                :loading="loading"
                :disabled="!valid"
                >Login</v-btn>
            </v-col>
            <!-- Errors -->
            <v-col  cols="5">
                <v-alert :value="error" dismissible border="left" type="error">
                    {{ error }}
                </v-alert>
            </v-col>

        </v-row>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex';
import AuthenticationService from '@/services/AuthenticationService';


export default {
    name : "Login",

    data(){
        return {
            email : '',
            password : '',
            remembre : false, // later
            emailRules: [
                value => !!value || 'Required.',
            ],
            passwordRules: [
                value => !!value || 'Required.',
                value => value.length >= 6 || 'Password is less than 6 characters'
            ],
            valid : true
        }
    },

    computed : {
        ...mapGetters({
            loading : 'auth/isLoading',
            error   : 'auth/error'
        }),
    },

    methods : {
        login(){
            if (this.$refs.loginForm.validate()) {
                // starting the login process
                this.$store.dispatch('auth/isLoggingIn');
                // call the backend api and sending the credentials
                AuthenticationService.login({
                    email       : this.email,
                    password    : this.password
                })
                // if the login was seccessfule
                .then( ({ data }) => {
                    this.$store.dispatch('auth/loginSuccess', data);
                    // fethc the user
                     this.$store.dispatch('auth/fetchUser');

                    this.$router.push({ name : "Home" });
                })
                // if the login failed
                .catch( error => {
                    this.$store.dispatch("auth/loginFailure", error.response.data);
                });
            }
        }
    },
}
</script>
