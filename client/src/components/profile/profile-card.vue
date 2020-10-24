<template>
    <v-card class="mx-auto mt-8" tile max-width="400">
        <v-list-item>
            <v-list-item-avatar color="grey">
                
            </v-list-item-avatar>
            <v-list-item-content>
                <v-list-item-title class="text-h6">{{ user.name }}</v-list-item-title>
                <v-list-item-subtitle class="text-subtitle-2">{{ user.email }}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-divider class="mb-n3"></v-divider>
        <v-row class="flex-column">
            <v-col>
                <v-simple-table>
                    <tbody>
                        <tr>
                            <td>Job : </td>
                            <td>{{ user.job }}</td>
                        </tr>
                        <tr>
                            <td>Organization : </td>
                            <td>{{ user.organization }}</td>
                        </tr>
                        <tr>
                            <td>Country : </td>
                            <td>{{ user.country }}</td>
                        </tr>
                    </tbody>
                </v-simple-table>
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
export default {
    computed:{
        user(){
            return this.$store.getters['auth/user'];
        }
    }
}
</script>

<style>

</style>