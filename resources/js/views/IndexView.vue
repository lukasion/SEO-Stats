<script setup>
    import { ref, onMounted } from '@vue/runtime-core'
    import { useStore } from 'vuex'
    import { computed, defineProps } from 'vue';
    import { useRoute, useRouter } from 'vue-router';
    import { VRow, VCol, VBtn, VSelect } from 'vuetify/components';

    const store = useStore()
    const router = useRouter()
    const route = useRoute()

    const phrases = $ref([]);
    const customer = $ref(null);
    const customers = $ref([
        { id: null, name: '--' }
    ]);
    const user = computed(() => store.state.user)
    const authenticated = computed(() => store.state.authenticated)
    const customerName = computed(() => {
        const found = customers.filter((item) => item.id == customer);
        if (found?.length > 0) {
            return found[0].name;
        }
    })

    const click = async (action) => {
        if (action == 'logout') {
            await store.dispatch('logout');

            router.push({name: 'login'})
        }
    }

    const fetchCustomer = (customerID) => {
        axios.get(`/api/customer/${customerID}`).then((response) => {
                if (response.status == 200) {
                    const data = response.data;

                    if (data.phrases) {
                        phrases = data.phrases;
                        phrases.forEach((phrase) => {
                            phrase.positions = [];

                            if (phrase.position) {
                                for (const [key, value] of Object.entries(phrase.position.position)) {
                                    phrase.positions.push({
                                        name: key, 
                                        value: value
                                    });
                                }
                            }
                        });
                    }
                }
            }).catch((err) => {
                console.log(err);
            });
    }

    const fetchCustomers = () => {
        axios.get('/api/customers').then((response) => {
            if (response.status == 200) {
                const data = response.data;

                if (data.length > 0) {
                    data.forEach((el) => {
                        customers.push(el);
                    });

                    if (route.query.customerID) {
                        const customerID = parseInt(route.query.customerID);
                        customer = customerID;

                        changeCustomer(customerID)
                    }
                }
            }
        }).catch((err) => {
            console.log(err);
        });
    }

    const deletePhrase = (customerID, phraseID) => {
        axios.delete(`/api/customer/${customerID}/phrase/${phraseID}`).then((response) => {
            if (response.status == 200 && response.data.result == true) {
                fetchCustomer(customerID);
            }
        }).catch((err) => {
            console.log(err);
        });
    }

    const changeCustomer = (customerID) => {
        if (route.query.customerID != customerID) {
            route.query.customerID = null;

            router.replace(route.query);
        }

        if (customerID !== null) {
            fetchCustomer(customerID);
        }
    }

    onMounted(() => {
        if (!authenticated.value) {
            router.push({ name: 'login' });
        }

        fetchCustomers();
    });

</script>

<template>
    <div>
        <div class="bar__title">
            <v-row>
                <v-col class="flex align-center py-0">
                    <h1>Klienci</h1>
                </v-col>
                <v-col class="py-0">
                    <v-select
                        class="my-2"
                        :items="customers"
                        v-model="customer"
                        item-title="name"
                        @update:modelValue="changeCustomer"
                        item-value="id"
                        hide-details
                        label="Klient">
                    </v-select>
                </v-col>
            </v-row>
        </div>
        
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
                                0
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
    </div>
</template>