import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import vuetify from './plugins/vuetify'
import { loadFonts } from './plugins/webfontloader'
import store from './store/store'
import './assets/sass/app.scss'

import axios from 'axios'
axios.defaults.baseURL = import.meta.env.VITE_APP_BASE_URL
import VueAxios from 'vue-axios'

loadFonts()

const app = createApp(App)
  .use(router)
  .use(vuetify)
  .use(store)
  .use(VueAxios, axios)
  .mount('#app')
