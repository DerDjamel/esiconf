<template>
    <v-btn class="ma-2" tile outlined color="primary" @click.stop="download">
        <v-icon left>mdi-file-download-outline</v-icon> Download Paper
    </v-btn>
</template>

<script>
import PaperService from '@/services/PaperService';

export default {
    props : ['id', 'paper_name'],
    data(){
        return {
            loading : false,
            error : null,
            paper: null,
        };
    },

    methods : {
        async download(){
            try {
                this.loading = true;
                this.error = null;
                const { data } = await PaperService.download(this.id);
                this.paper = data;
                this.loading = false;
                this.error = null;

                let blob = new Blob([this.paper, {type: 'application/*'}]);
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = this.paper_name;
                link.click(); 
                
            } catch (error) {
                console.log(error);
            }
        },
    },
}
</script>
