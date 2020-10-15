<template>
  <v-app>
    <navigation v-if="isLogged"></navigation>
    <!-- Main Content -->
    <v-main>
      <router-view></router-view>
      <flash message=""></flash>
    </v-main>


  </v-app>
  <!-- End of the v-app -->
</template>

<script>
import navigation from "@/components/globale/navigation.vue";

export default {
  name: 'App',
  components : {navigation},
  computed: {
    isLogged(){
      return this.$store.getters['auth/isLogged'];
    }
  },
};
</script>
