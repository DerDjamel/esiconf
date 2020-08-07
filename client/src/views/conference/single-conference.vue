<template>
  <v-container>
      <v-row>
          <v-col cols="8">
              <v-card outlined tag="article">
                <v-card-title>This is a conference title</v-card-title>
                <v-divider></v-divider>
                <v-card-text>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo quasi iusto eveniet dolor perspiciatis nihil reiciendis? Repellat at minus, porro modi consectetur est deleniti esse numquam dolor iure unde veniam. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sapiente repellat est reprehenderit optio error quaerat quam corporis, ipsa animi et quisquam aliquam, a delectus expedita earum eveniet velit voluptate. Similique. Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo quasi iusto eveniet dolor perspiciatis nihil reiciendis? Repellat at minus, porro modi consectetur est deleniti esse numquam dolor iure unde veniam. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sapiente repellat est reprehenderit optio error quaerat quam corporis, ipsa animi et quisquam aliquam, a delectus expedita earum eveniet velit voluptate. Similique. l</v-card-text>
            </v-card>

            <section class="my-5">
                <v-card outlined>
                    <v-card-title>Information : </v-card-title>
                    <v-simple-table>
                        <tbody>
                            <tr>
                                <td>Start</td>
                                <td>22-05-2020</td>
                            </tr>
                        </tbody>
                    </v-simple-table>
                </v-card>
            </section>

            <section>
                <v-card outlined>
                    <v-card-title>Programe Commitee : </v-card-title>
                    <v-card-subtitle><span>Chairman : name of the admin here</span></v-card-subtitle>

                    <v-card-title class="subtitle-2 mb-n3">Reviewers :</v-card-title>
                    <v-list dense>
                        <v-list-item v-for="n in 5" :key="n">
                            <v-list-item-content>
                                <v-list-title>name of reviewer</v-list-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>
            </section>
          </v-col>

          <v-col cols="3">
              <v-card outlined>
                <v-list dense nav >
                    <v-list-item link v-for="(item, i) in side_menu" :key="i">
                    <v-list-item-icon>
                        <v-icon color="primary" v-text="item.icon" ></v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title v-text="item.text"></v-list-item-title>
                    </v-list-item-content>
                    </v-list-item>
                </v-list>
              </v-card>
          </v-col>
      </v-row>
  </v-container>
</template>

<script>
export default {
    data(){
        return {
            side_menu : [
                {icon : 'mdi-cog-outline', text: 'Settings',},
                {icon : 'mdi-file-document-multiple-outline', text: 'Papers',},
                {icon : 'mdi-file-find', text: 'Reviews',},
                {icon : 'mdi-gavel', text: 'Bids',},
                {icon : 'mdi-chart-bar', text: 'Stats',},
            ]
        };
    }
}
</script>

<style>

</style>