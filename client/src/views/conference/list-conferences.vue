<template>
  <div>
      <v-container class="py-1">
          <v-row>
              <v-col cols="6" v-for="c in conferences" :key="c.id">
                <MiniConference :conference="c"></MiniConference>
              </v-col>
          </v-row>
          <v-pagination @input="fetch" @next="fetch" @previous="fetch" :length="meta.last_page" ref="pagination" color="primary" class="mt-0" v-model="page" total-visible="10"></v-pagination>
      </v-container>
  </div>
</template>

<script>
import MiniConference from '@/components/conference/mini-conference.vue';
import ConferenceService from '@/services/ConferenceService';
export default {
    name : 'ListConferences',
    components: {MiniConference},
    data(){
        return {
            page : 1,
            loading : false,
            error: null,
            conferences : null,
            links : null,
            meta: null,

        };
    },

    methods: {
        fetch(){
            this.fetchConferencesPage(this.page);
        },
        // prev
        async fetchConferencesPage(page){
            this.error = null;
            this.loading = true;
            this.conferences = null;

            try {
                const { data } = await ConferenceService.index_page(page);
                this.loading = false;
                this.error = null;
                this.conferences = data.data;
            } catch (error) {
                console.log(error);
            }
        },


        async fetchConferences(){
            this.error = null;
            this.loading = true;
            this.conferences = null;
            this.links = null;
            this.meta = null;

            try {
                const { data } = await ConferenceService.index();

                this.loading = false;
                this.error = null;
                this.conferences = data.data;
                this.links = data.links;
                this.meta = data.meta;
            } catch (error) {
                console.log(error);
            }
        },
    },

    created(){
        this.fetchConferences();
    },

    watch : {
        '$route' : 'fetchConferencesPage',
    },
    
}
</script>

<style>

</style>