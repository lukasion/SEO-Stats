<script setup>
    import { ref, onMounted } from '@vue/runtime-core'
    import { useStore } from 'vuex'
    import { computed } from 'vue';
    import { useRouter } from 'vue-router';
    import { VImg, VApp, VCard, VContainer, VListItemTitle, VIcon, VList, VListItem, VNavigationDrawer, VRow, VCol, VBtn  } from 'vuetify/components';

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

    onMounted(() => {
        if (!authenticated.value) {
            router.push({ name: 'login' });
        }
    });

    const user = computed(() => store.state.user)
    const authenticated = computed(() => store.state.authenticated)

    const click = async (action) => {
        if (action == 'logout') {
            await store.dispatch('logout');

            router.push({name: 'login'})
        }
    }
</script>

<template>
    <v-app>
        <v-container>
            <v-card min-height="90vh">
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
                                        Panel gracza
                                    </div>
                                </div>
                            </div>
                        </div>
                        <v-row v-if="user">
                            <v-col>
                                <v-img
                                    :aspect-ratio="1"
                                    width="50"
                                    src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                                    cover
                                    style="border-radius: 50%; border: 2px solid #fff;"
                                ></v-img>
                            </v-col>
                            <v-col>
                                <v-list-item-title>{{ user.members_seo_name }}</v-list-item-title>
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
                        <div class="bar__title">Stajnia azjaty</div>
                        
                        <div class="table margin--top-15">
                            <div class="table__row--header">
                                <div class="table__col">
                                    Szczegóły
                                </div>
                            </div>
                            <div class="table__row">
                                <div class="table__col">
                                    <div class="table__placeholder">Nazwa</div>
                                    <div class="table__content">Stajnia Azjaty Pod Latarnią</div>
                                </div>
                                <div class="table__col">
                                    <div class="table__placeholder">Sakwa</div>
                                    <div class="table__content">1,895,633.36$</div>
                                </div>
                                <div class="table__col">
                                    <div class="table__placeholder">Typ</div>
                                    <div class="table__content">LEA</div>
                                </div>
                                <div class="table__col">
                                    <div class="table__placeholder">Pierwotny lider</div>
                                    <div class="table__content">Maczu Piczu</div>
                                </div>
                            </div>
                            <div class="table__row">
                                <div class="table__col">
                                    <div class="table__placeholder">Skrót</div>
                                    <div class="table__content">SAPL</div>
                                </div>
                                <div class="table__col">
                                    <div class="table__placeholder">Dotacja</div>
                                    <div class="table__content">3000 $</div>
                                </div>
                                <div class="table__col">
                                    <div class="table__placeholder">Data utworzenia</div>
                                    <div class="table__content">30 luty 2021</div>
                                </div>
                                <div class="table__col">
                                    <div class="table__placeholder">Kolor</div>
                                    <div class="table__content">rgba(250,20,150,0.5)</div>
                                </div>
                            </div>
                            <div class="table__row">
                                <div class="table__col">
                                    <div class="table__placeholder">Numer konta bankowego</div>
                                    <div class="table__content">464123168684</div>
                                </div>
                                <div class="table__col">
                                    <select class="table__select" name="">
                                        <option>Minimalna wypłata</option>
                                    </select>
                                </div>
                                <div class="table__col">
                                    <select class="table__select" name="">
                                        <option>Marża</option>
                                    </select>
                                </div>
                                <div class="table__col">
                                    
                                </div>
                            </div>
                        </div>

                        <div class="table margin--top-15">
                            <div class="table__row--header">
                                <div class="table__col">
                                    <strong>Pracownicy</strong>
                                </div>
                            </div>
                            <div class="table__row table__row--subheader">
                                <div class="table__col">
                                    
                                </div>
                                <div class="table__col">
                                    Gracz
                                </div>
                                <div class="table__col">
                                    Data zatrudnienia
                                </div>
                                <div class="table__col">
                                    Ostatnio w grze
                                </div>
                                <div class="table__col">
                                    Status
                                </div>
                                <div class="table__col">
                                    Służba
                                </div>
                                <div class="table__col">
                                    Służba w tym tygodniu
                                </div>
                                <div class="table__col">
                                    Ranga
                                </div>
                            </div>
                            <div class="table__row" v-for="i in 10" :key="i">
                                <div class="table__col">
                                    <div class="table__content text--center">
                                        <input class="input__checkbox" type="checkbox" name="employee[{{ i }}]" />
                                    </div>
                                </div>
                                <div class="table__col">
                                    <div class="table__content">1,895,633.36$</div>
                                </div>
                                <div class="table__col">
                                    <div class="table__content">LEA</div>
                                </div>
                                <div class="table__col">
                                    <div class="table__content">Maczu Piczu</div>
                                </div>
                                <div class="table__col">
                                    <div class="table__content">Maczu Piczu</div>
                                </div>
                                <div class="table__col">
                                    <div class="table__content">Maczu Piczu</div>
                                </div>
                                <div class="table__col">
                                    <div class="table__content">Maczu Piczu</div>
                                </div>
                                <div class="table__col">
                                    <div class="table__content">Maczu Piczu</div>
                                </div>
                            </div>
                        </div>
                    </v-container>
                </div>
            </v-card>
        </v-container>
    </v-app>
</template>