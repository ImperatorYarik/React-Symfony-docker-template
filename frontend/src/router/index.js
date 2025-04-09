import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'myFirstComponent',
      component: () => import('../views/FirstVueComponent.vue')
    },
    {
      path: '/login',
      name: 'SignIn',
      component: () => import('../views/SignInPage.vue')
    },
    {
      path: '/register',
      name: 'SignUp',
      component: () => import('../views/SignUpPage.vue')
    }
  ]
})

export default router
