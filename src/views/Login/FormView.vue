
<script setup>
    import { VApp, VCard, VContainer, VRow, VCol, VBtn, VTextField, VCardText } from 'vuetify/components';
    import axios from 'axios';

    const name = $ref('')
    const show1 = $ref(false)
    const password = $ref('')
    const rules = {
        required: value => !!value || 'Pole jest wymagane',
        min: v => v.length >= 8 || 'Minimum 8 znaków',
    };

    const submit = () => {
        axios.post(`/auth/login`, {
            name: name,
            password: password
        }).then(response => {
            console.log(response);
        });
    }
</script>

<template>
    <v-app>
        <v-container>
            <v-row align="center" justify="center">
                <v-col
                    class="d-flex justify-center">
                    <img width="150px" src="https://forum.veritas-rp.pl/uploads/monthly_2022_03/godlo.png.de0cddd87ba5e002f326bf78fc57c711.png" />
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
                                :rules="[rules.required, rules.min]"
                                :type="show1 ? 'text' : 'password'"
                                name="input-10-1"
                                label="Hasło"
                                hint="Minimum 8 znaków"
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