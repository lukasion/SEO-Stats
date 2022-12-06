import { createRouter, createWebHistory } from 'vue-router'
import IndexView from '../views/IndexView.vue'
import LoginView from '../views/Login/FormView.vue'
import PhraseFormView from '../views/Customer/Phrase/FormView.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/dashboard',
      name: 'dashboard',
      component: IndexView,
    },
    {
      path: '/customer/:customerID/phrase/add',
      name: 'phraseAdd',
      component: PhraseFormView,
    },
    {
      path: '/',
      name: 'login',
      component: LoginView
    },
  ]
})

export default router
