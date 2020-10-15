<template>
  <v-snackbar
      v-model="snackbar"
      :timeout="timeout"
      color="info"
      outlined
      top right
    >
      {{ body }}

      <template v-slot:action="{ attrs }">
        <v-btn
          color="blue"
          text
          v-bind="attrs"
          @click="snackbar = false"
        >
          Close
        </v-btn>
      </template>
    </v-snackbar>
</template>

<script>
export default {
    props: ['message'],
    data(){
        return {
            snackbar: false,
            timeout: 3000,
            body : this.message
        };
    },

    methods: {
        flash(message){
            this.snackbar = true;
            this.body = message;
        }
    },


    created(){
        if (this.message) {
            this.flash(this.message);
        }
        window.events.$on('flash', message => { this.flash(message); });
    }
}
</script>

<style>

</style>