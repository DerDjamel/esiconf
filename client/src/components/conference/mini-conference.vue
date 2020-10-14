<template>
  <article class="mini-conference">
      <v-card max-width="560px" min-height="200px" outlined>
          <!-- Confernce Name -->
          <v-card-title>
              {{ conference.name }}
          </v-card-title>

          <v-divider></v-divider>
          <!-- Conference Description -->
          <v-card-text>
              <section class="conference-description pb-2">
                  {{ conference_description }}
              </section>
              <v-divider></v-divider>
              <section class="conference-dates mt-2 d-flex justify-start align-center">
                  <div class="mr-2">
                      <span class="font-weight-bold">start</span> : <v-chip class="pa-2" label small> {{ conference.start }} </v-chip>
                  </div>
                  <div>
                      <span class="font-weight-bold ml-2">end</span> : <v-chip class="pa-2" label small> {{ conference.end }} </v-chip> 
                  </div>
              </section>
          </v-card-text>
      </v-card>
  </article>
</template>

<script>
export default {
    props : ['conference'],
    computed: {
        conference_description(){
            return this.conference.description.substr(0, 200) + "...";
        }
    }
}
</script>

<style>

</style>