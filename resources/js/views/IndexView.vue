<script setup>
    import { ref, onMounted } from '@vue/runtime-core'
    import { useStore } from 'vuex'
    import { computed } from 'vue';
    import { useRouter } from 'vue-router';
    import { VImg, VApp, VCard, VContainer, VListItemTitle, VIcon, VList, VListItem, VNavigationDrawer, VRow, VCol, VBtn, VSelect } from 'vuetify/components';

    const store = useStore()
    const drawer = ref(false)
    const router = useRouter()
    const items = [
        { title: 'Statystyki', icon: 'mdi-chart-bar', action: 'start', type: 'title' },
        { title: 'Strona główna', icon: 'mdi-home-city', action: 'start', type: 'href' },
        { title: 'Gracz', icon: 'mdi-chart-bar', action: 'characters', type: 'title' },
        { title: 'Postacie', icon: 'mdi-account', action: 'characters', type: 'href' },
        { title: 'Grupy', icon: 'mdi-account-group-outline', action: 'groups', type: 'href' },
        { title: 'Wyloguj się', icon: 'mdi-logout', action: 'logout', type: 'href' },
    ]

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

    const fetchCustomers = () => {
        axios.get('/api/customers').then((response) => {
            if (response.status == 200) {
                const data = response.data;

                if (data.length > 0) {
                    data.forEach((el) => {
                        customers.push(el);
                    });
                }
            }
        }).catch((err) => {
            console.log(err);
        });
    }

    const changeCustomer = (customerID) => {
        if (customerID !== null) {
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
    }

    onMounted(() => {
        if (!authenticated.value) {
            router.push({ name: 'login' });
        }

        fetchCustomers();
    });

</script>

<template>
    <v-app>
        <v-container>
            <v-card min-height="90vh" class="elevation-10 rounded-lg">
                <v-list-item class="px-2 header__top">
                    <div class="d-flex flex-row align-center" style="width: 100%;">
                        <v-btn
                            class="mr-4"
                            @click.stop="drawer = !drawer">
                            Menu
                        </v-btn>
                        <div class="flex--1 d-flex align-center">
                            <div class="header__logo">
                                <div class="header__outbox">
                                    <div class="header__insidebox">
                                        SEO-Stats
                                    </div>
                                </div>
                            </div>
                        </div>
                        <v-row>
                            <v-col class="justify-end flex">
                                <ul class="header__menu">
                                    <li>
                                        <a href="#">Klienci</a>
                                    </li>
                                    <li>
                                        <a href="#">Statystyki</a>
                                    </li>
                                    <li>
                                        <a href="#">Ustawienia</a>
                                    </li>
                                </ul>
                            </v-col>
                        </v-row>
                    </div>
                </v-list-item>
                

                <div class="d-flex">
                    <v-navigation-drawer
                        v-model="drawer"
                        temporary>
                        <v-list dense>
                            <v-list-item
                                v-for="item in items"
                                :key="item.title"
                                link
                                :class="item.type == 'title' ? 'v-list-item-title' : ''"
                                @click="click(item.action)">

                                <v-row>
                                    <v-col cols="3">
                                        <v-icon>{{ item.icon }}</v-icon>
                                    </v-col>
                                    <v-col cols="9">
                                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                                    </v-col>
                                </v-row>
                            </v-list-item>
                        </v-list>
                    </v-navigation-drawer>
                    <v-container fluid>
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

                            <div class="table margin--top-15" v-if="(phrases.length > 0)">
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
                                        <strong>Asddsa</strong>
                                    </div>
                                    <template v-if="(phrase.positions.length > 0)">
                                        <div class="table__col" v-for="position in phrase.positions" :key="index">
                                            {{ position.value }}
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="table__col" v-for="index in 31" :key="'zero-' + index">
                                            0
                                        </div>
                                    </template>
                                </div>
                            </div>
                            
                            <div v-else>
                                Brak fraz zdefiniowanych dla wybranego klienta.
                            </div>
                        </div>
                    </v-container>
                </div>
            </v-card>
        </v-container>
    </v-app>
</template>