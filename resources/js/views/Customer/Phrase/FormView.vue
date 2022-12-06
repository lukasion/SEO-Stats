
<script setup>
    import { useRoute, useRouter } from 'vue-router';
    import { VRow, VBtn, VTextField, VCol } from 'vuetify/components';
  
    const name = $ref('')
    const route = useRoute()
    const router = useRouter()

    const submit = () => {
        axios.post(`/api/customer/${route.params.customerID}/phrase`, {
            name: name,
        }).then(response => {
            if (response.status == 201) {
                router.push({name: 'dashboard', query: { customerID: route.params.customerID }});
            }
        }).catch(data => {
            console.error(data);
        });
    }
</script>

<template>
    <div>
        <div class="bar__title mb-4">
            <v-row>
                <v-col class="flex align-center py-0">
                    <h1>Dodawanie frazy</h1>
                </v-col>
            </v-row>
        </div>

        <form @submit.prevent="submit">
            <v-text-field
                v-model="name"
                :counter="10"
                label="Nazwa frazy"
                required
                @keydown.enter="submit"
            ></v-text-field>
            <v-row justify="center">
                <v-btn
                    color="primary"
                    class="mr-4 mt-2 mb-2"
                    @click="submit"
                    >
                    Zapisz
                </v-btn>
                
                <v-btn
                    color="black"
                    class="mr-4 mt-2 mb-2"
                    :to="{ name: 'dashboard', query: { customerID: route.params.customerID } }">
                    Powrót
                </v-btn> 
                
            </v-row>
        </form>
    </div>
</template>