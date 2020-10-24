<template>
  <div>
      <v-navigation-drawer
      v-model="drawer"
      :clipped="$vuetify.breakpoint.lgAndUp"
      app
      :mini-variant='!mini'
    >
      <v-list dense nav>
        <v-list-item link v-for="(item, i) in user_items" :key="i" :to="item.link">
           <v-list-item-icon>
            <v-icon color="primary" v-text="item.icon"></v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title v-text="item.text"></v-list-item-title>
          </v-list-item-content>
        </v-list-item>

      </v-list>

      <v-divider></v-divider>

      <v-list dense nav>
        <v-list-item link v-for="(item, i) in resources_items" :key="i" :to="item.link">
           <v-list-item-action>
            <v-icon color="primary">{{item.icon}}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>{{ item.text }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>

      <v-divider></v-divider>

      <v-list dense nav>
        <v-list-item link v-for="(item, i) in owned_items" :key="i" :to="item.link">
           <v-list-item-icon>
            <v-icon color="primary" v-text="item.icon" ></v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title v-text="item.text"></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>

    </v-navigation-drawer>

    <!-- Notifications side bar -->
    <v-navigation-drawer
                temporary
                :right="right"
                v-model="notifications"
                fixed
                app
                width="300px"
        >
            <v-toolbar flat dark class="primary">
                <v-toolbar-title class="font-weight-bold">Notifications</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn icon @click.stop="notifications = false">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-toolbar>

            <v-list dense>
                <div v-for="i in 15" :key="i">
                  <v-list-item>
                    <v-list-item-content>
                      <v-list-item-content class="text-subtitle-2">Lorem ipsum dolor, sit amet consectet adipisicing elit cing elit cing elit</v-list-item-content>
                    </v-list-item-content>
                  </v-list-item>
                  <v-divider></v-divider>
                </div>
            </v-list>
            
        </v-navigation-drawer>

    <v-app-bar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      app
      color="blue darken-3"
      dark >
      <v-app-bar-nav-icon @click.stop="mini = !mini"></v-app-bar-nav-icon>
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

      <v-tooltip color="primary" bottom>
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon class="mr-1" v-on="on" v-bind="attrs" to="/conference/create"> 
            <v-icon>mdi-plus</v-icon>
          </v-btn>  
        </template>
        <span>Create a new Conference</span>
      </v-tooltip>

      <v-tooltip color="primary" bottom>
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon class="mr-1" v-on="on" v-bind="attrs" @click.stop="notifications = true"> 
            <v-icon>mdi-bell</v-icon>
          </v-btn>  
        </template>
        <span>Notifications</span>
      </v-tooltip>
      
      <v-tooltip color="primary" bottom>
        <template v-slot:activator="{ on, attrs }">
          <v-btn @click="logout" :loading="logout_loading" icon class="mr-1" v-on="on" v-bind="attrs"> 
            <v-icon>mdi-exit-to-app</v-icon>
          </v-btn>  
        </template>
        <span>Logout</span>
      </v-tooltip>

    <!-- End of v-app-bar -->
    </v-app-bar>
  </div>
</template>

<script>
import AuthenticationService from "@/services/AuthenticationService";

export default {
    name: "navigation",
    data: () => ({
        drawer : true,
        notifications: false,
        right: true,
        mini: true,
        under: true,
        user_items : [
        {icon : 'mdi-account-circle', text: 'Profile', link : '/'}
        ],
        resources_items : [
        {icon : 'mdi-text-box-search-outline', text: 'Browse Conferences', link : "/conferences"}
        ],
        owned_items : [
        {icon : 'mdi-desk', text: 'My Conferences', link : "/my-conferences"},
        {icon : 'mdi-file-outline', text: 'My Papers', link: '/my-papers'},
        {icon : 'mdi-file-find', text: 'My Reviews', link :'/my-reviews'},
        {icon : 'mdi-gavel', text: 'My Bids', link : '/my-bids'},
        ],

        //logout
        logout_loading : false,
  }), // end of data
  methods: {
      async logout(){
          try {
            this.logout_loading = true;
            this.$store.dispatch('auth/logout');
            await AuthenticationService.logout();
            this.$router.push('/login');
          } catch (error) {
              this.logout_loading = false;
              console.log(error);
          }
      }
  }
}
</script>

<style>

</style>