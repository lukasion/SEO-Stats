<script setup>
    import { VMain, VApp, VCard, VContainer, VListItemTitle, VIcon, VList, VListItem, VNavigationDrawer, VRow, VCol, VBtn } from 'vuetify/components';
    import { onMounted } from 'vue';
    import { useStore } from 'vuex';
    const store = useStore()
    const loaded = $ref(false)

    const drawer = $ref(false)
    const items = [
        { title: 'Statystyki', icon: 'mdi-chart-bar', action: 'start', type: 'title' },
        { title: 'Strona główna', icon: 'mdi-home-city', action: 'start', type: 'href' },
        { title: 'Gracz', icon: 'mdi-chart-bar', action: 'characters', type: 'title' },
        { title: 'Postacie', icon: 'mdi-account', action: 'characters', type: 'href' },
        { title: 'Grupy', icon: 'mdi-account-group-outline', action: 'groups', type: 'href' },
        { title: 'Wyloguj się', icon: 'mdi-logout', action: 'logout', type: 'href' },
    ]

    onMounted(async () => {
        const isAuthenticated = localStorage.getItem('USER_AUTHENTICATED');
        
        if (isAuthenticated && isAuthenticated === 'true') {
            await store.dispatch('me');

            loaded = true;
        } else {
            loaded = true;
        }
    });
</script>

<template>
    <v-app>
        <v-main>
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
                                            <router-link :to="{name: 'dashboard'}">Klienci</router-link>
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
                    </div>  

                    <v-container fluid v-if="loaded">
                        <router-view></router-view>
                    </v-container>
                </v-card>
            </v-container>
        </v-main>
    </v-app>
</template>