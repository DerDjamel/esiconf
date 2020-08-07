<template>
  <article class="mini-conference">
      <v-card max-width="400px" outlined>
          <!-- Confernce Name -->
          <v-card-title>
              This is a title of a conference
          </v-card-title>

          <v-divider></v-divider>
          <!-- Conference Description -->
          <v-card-text>
              <section class="conference-description pb-2">
                  Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut possimus dolor, asperiores vitae impedit voluptate id tenetur alias aspernatur ex soluta? Obcaecati veniam atque natus repellat voluptatem nulla, sunt quibusdam.
              </section>
              <v-divider></v-divider>
              <section class="conference-dates mt-2 d-flex justify-start align-center">
                  <div class="mr-2">
                      <span class="font-weight-bold">start</span> : <v-chip class="pa-2" label small>2020-05-16</v-chip>
                  </div>
                  <div>
                      <span class="font-weight-bold ml-2">end</span> : <v-chip class="pa-2" label small>2020-05-16</v-chip> 
                  </div>
              </section>
          </v-card-text>
      </v-card>
  </article>
</template>

<script>
export default {

}
</script>

<style>

</style>