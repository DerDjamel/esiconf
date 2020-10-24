<template>
    <v-dialog v-model="dialog" persistent max-width="500px">
    <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="primary"
          dark
          tile
          outlined
          v-bind="attrs"
          v-on="on"
        >
          Bid
        </v-btn>
    </template>

    <v-card>
        <v-card-title><span class="headline font-weight-medium">Place your Bid :</span></v-card-title>
        <v-divider></v-divider>
        <v-card-text>
            <v-container class="mb-n8">
                <v-row>
                    <v-col>
                        <v-select
                        :items="intrest_level"
                        v-model="thebid"
                        label="Your Bid"
                        outlined
                        ></v-select>
                    </v-col>
                </v-row>
            </v-container>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="red" tile outlined @click="dialog = false">Close</v-btn>
            <v-btn color="primary" tile outlined @click="bid(paper_id)">Save</v-btn>
        </v-card-actions>
    </v-card>
    </v-dialog>
</template>

<script>
import BidService from '@/services/BidService';
export default {
    props: ['paper_id'],
    data(){
        return {
            dialog: false,
            loading: false,
            error: null,
            thebid: null,
            intrest_level: ['eager', 'willing', 'neutral', 'not willing'],
        }
    },
    methods: {
        async bid(paper_id){
            try {
                this.loading = true;
                this.error = false;
                await BidService.store(paper_id, {
                    'intrest_level' : this.thebid
                });
                this.loading = false;
                this.error = null;
                window.flash('Your Bid was successfully');
                this.dialog = false;

            } catch (error) {
                console.log(error);
            }
        },
    },
}
</script>
