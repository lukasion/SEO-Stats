<script setup>
import { ref, onMounted } from '@vue/runtime-core'
import { useStore } from 'vuex'
import { computed, defineProps } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { VRow, VCol, VSelect } from 'vuetify/components';
import PhraseList from '../components/phrases/List.vue'

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
        
        <phrase-list 
            :phrases="phrases"
            :customer-name="customerName"
            :customer="customer"
            @fetch-customer="fetchCustomer"
        ></phrase-list>
    </div>
</template>