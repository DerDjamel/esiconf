<template>
  <v-app>
    <v-navigation-drawer
      v-model="drawer"
      :clipped="$vuetify.breakpoint.lgAndUp"
      app
    >
      
    </v-navigation-drawer>

    <v-app-bar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      app
      color="blue darken-3"
      dark >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title
        style="width: 300px"
        class="ml-0 pl-4"
      >
        <!-- <v-img class="mr-3" alt="esiconf" src="./assets/logo.svg" max-height="40px" max-width="40px"></v-img> -->
        <span class="hidden-sm-and-down font-weight-bold">
          EsiConf
        </span>
      </v-toolbar-title>
      <v-text-field
        flat
        solo-inverted
        hide-details
        prepend-inner-icon="mdi-magnify"
        label="Search"
        class="hidden-sm-and-down"
      ></v-text-field>
      <v-spacer></v-spacer>

      <v-btn icon>
        <v-icon>mdi-plus</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon>mdi-bell</v-icon>
      </v-btn>

    <!-- End of v-app-bar -->
    </v-app-bar>


    <!-- Main Content -->
    <v-main>
      <router-view></router-view>
    </v-main>


  </v-app>
  <!-- End of the v-app -->
</template>

<script>


export default {
  name: 'App',

  data: () => ({
    drawer : false,
    under: true,
  }),
};
</script>
