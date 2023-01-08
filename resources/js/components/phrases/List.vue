<script setup>
import { defineProps } from 'vue';
import { useRouter } from 'vue-router';
import { VBtn } from 'vuetify/components';

const router = useRouter()
const emit = defineEmits(['fetchCustomer'])

const deletePhrase = (customerID, phraseID) => {
    axios.delete(`/api/customer/${customerID}/phrase/${phraseID}`).then((response) => {
        if (response.status == 200 && response.data.result == true) {
            emit('fetchCustomer', customerID);
        }
    }).catch((err) => {
        console.log(err);
    });
}

const props = defineProps({
    customerName: String,
    phrases: Object,
    customer: Number
})
</script>

<template>
    <div v-if="customer">
        <h3 class="mt-2">Raport dla: {{ customerName }}</h3>

        <div v-if="(phrases.length > 0)">
            <div class="table margin--top-15">
                <div class="table__row table__row--subheader">
                    <div class="table__col table__col--10">
                        Pozycjonowana fraza
                    </div>
                    <div class="table__col justify-center" v-for="index in 31" :key="index">
                        {{ index }}
                    </div>
                </div>
                <div class="table__row" v-for="phrase in phrases">
                    <div class="table__col table__col--10">
                        <p><strong>{{ phrase.name }}</strong></p>
                        <router-link :to="{name: 'phraseEdit', params: { customerID: customer, phraseID: phrase.id }}">edytuj</router-link>&nbsp;
                        <a href="#" @click="deletePhrase(customer, phrase.id)">usuń</a>
                    </div>
                    <template v-if="(phrase.positions.length > 0)">
                        <div class="table__col flex align-center justify-center" v-for="position in phrase.positions">
                            {{ position.value }}
                        </div>
                    </template>
                    <template v-else>
                        <div class="table__col flex align-center justify-center" v-for="index in 31" :key="'zero-' + index">
                            -
                        </div>
                    </template>
                </div>
            </div>
            <div class="flex justify-center mt-4">
                <v-btn
                    class="mr-4"
                    color="black"
                    @click="router.push({name: 'phraseAdd', params: { customerID: customer }})">
                    Dodaj frazę
                </v-btn>
            </div>
        </div>
        
        
        <div v-else>
            Brak fraz zdefiniowanych dla wybranego klienta.
        </div>
    </div>
</template>