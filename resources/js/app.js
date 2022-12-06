/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import vuetify from './plugins/vuetify'
import { loadFonts } from './plugins/webfontloader'
import store from './store/store'
import './assets/sass/app.scss'

import axios from 'axios'
axios.defaults.baseURL = import.meta.env.VITE_APP_BASE_URL
axios.defaults.withCredentials = true;

import VueAxios from 'vue-axios'

const app = createApp(App)
  .use(router)
  .use(vuetify)
  .use(store)
  .use(VueAxios, axios)
  .mount('#app')