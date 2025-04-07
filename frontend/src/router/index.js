import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'myFirstComponent',
      component: () => import('../views/FirstVueComponent.vue')
    }
  ]
})

export default router
