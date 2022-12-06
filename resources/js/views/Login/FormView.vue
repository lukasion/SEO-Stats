
<script setup>
    import { VApp, VCard, VContainer, VRow, VCol, VBtn, VTextField, VCardText, VAlert } from 'vuetify/components';
    import axios from 'axios';
    import { useStore } from 'vuex';
    import { onMounted } from 'vue'
    import router from '../../router';
    
    const name = $ref('')
    const show1 = $ref(false)
    const password = $ref('')
    const errorMessage = $ref('')
    const loginSuccess = $ref(false)
    const rules = {
        required: value => !!value || 'Pole jest wymagane',
        // min: v => v.length >= 8 || 'Minimum 8 znaków',
    };
    const store = useStore()

    const submit = () => {
        axios.post(`/user/login`, {
            name: name,
            password: password
        }).then(async response => {
            if (response.status == 204) {
                loginSuccess = true;
                errorMessage = '';

                await store.dispatch('me');

                router.push({name: 'dashboard'})
            }
        }).catch(data => {
            const err = data.response.data;

            if (err) {
                errorMessage = err.message;
            }
        });
    }

    onMounted(() => {
        if (store.state.user) {
            router.push({name: 'dashboard'})
        }
    })
</script>

<template>
    <v-app>
        <v-container>
            <v-row align="center" justify="center">
                <v-col
                    class="d-flex justify-center">
                    <h1 class="v">SEO Stats</h1>
                </v-col>
            </v-row>
            <v-row align="center"
                justify="center">
                <v-card
                    elevation="2"
                    outlined
                    max-width="600"
                    class="mt-7 flex-grow-1">
                    <v-card-text>
                        <p class="text-h4 text--primary mb-4">
                            Logowanie do Panelu
                        </p>

                        <v-alert
                            class="mb-4"
                            border="bottom"
                            color="red"
                            type="error"
                            v-if="errorMessage">
                            {{ errorMessage }}
                        </v-alert>

                        <v-alert
                            class="mb-4"
                            border="bottom"
                            color="green"
                            type="success"
                            v-if="loginSuccess">
                            Logowanie do systemu się powiodło!<br />
                            <strong>Trwa przekierowanie...</strong>
                        </v-alert>

                        <form @submit.prevent="submit">
                            <v-text-field
                                v-model="name"
                                :counter="10"
                                label="Login"
                                required
                                @keydown.enter="submit"
                            ></v-text-field>
                            <v-text-field
                            
                                v-model="password"
                                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                :rules="[rules.required]"
                                :type="show1 ? 'text' : 'password'"
                                name="input-10-1"
                                label="Hasło"
                                counter
                                @click:append="show1 = !show1"
                                @keydown.enter="submit"
                            ></v-text-field>
                            <v-row justify="center">
                                <v-btn
                                    color="primary"
                                    class="mr-4 mt-2 mb-2"
                                    @click="submit"
                                    >
                                    Zaloguj się
                                </v-btn>
                            </v-row>
                        </form>
                    </v-card-text>
                </v-card>
            </v-row>
        </v-container>
    </v-app>
</template>