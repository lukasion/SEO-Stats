
<script setup>
import { onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { VRow, VBtn, VTextField, VCol } from 'vuetify/components';

const name = $ref('')

const route = useRoute()
const router = useRouter()
const editMode = $ref(false)
const phrase = $ref(null)

const submit = () => {
    if (editMode == true) {
        editPhrase()
    } else {
        addPhrase()
    }
}

const addPhrase = () => {
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

const editPhrase = () => {
    axios.put(`/api/customer/${route.params.customerID}/phrase/${route.params.phraseID}`, {
        name: name,
    }).then(response => {
        if (response.status == 200) {
            router.push({name: 'dashboard', query: { customerID: route.params.customerID }});
        }
    }).catch(data => {
        console.error(data);
    });
}

const fetchPhrase = () => {
    axios.get(`/api/customer/${route.params.customerID}/phrase/${route.params.phraseID}`).then(response => {
        if (response.status == 200) {
            phrase = response.data.phrase;
            name = phrase.name;
        }
    }).catch(data => {
        console.error(data);
    });
}

onMounted(() => {
    if (route.name == 'phraseEdit' && route.params.phraseID !== undefined) {
        editMode = true;

        fetchPhrase(route.params.phraseID)
    }
})
</script>

<template>
    <div>
        <div class="bar__title mb-4">
            <v-row>
                <v-col class="flex align-center py-0">
                    <h1>
                        <span v-if="editMode">Edytowanie </span>
                        <span v-else>Dodawanie </span>
                        frazy
                    </h1>
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