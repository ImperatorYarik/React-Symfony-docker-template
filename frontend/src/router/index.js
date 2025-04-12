import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'HomePage',
      component: () => import('../views/HomePage.vue'),
    },
    {
      path: '/unauthorized',
      name: 'myFirstComponent',
      component: () => import('../views/FirstVueComponent.vue'),
    },
    {
      path: '/login',
      component: () => import('../views/SignInPage.vue'),
      meta: { requiresAuth: false }
    },
    {
      path: '/register',
      component: () => import('../views/SignUpPage.vue'),
      meta: { requiresAuth: false }
    },
    {
      path: '/profile',
      name: 'myFirstComponent',
      component: () => import('../views/Adminka.vue'),
      meta: { requiresAuth: true, roles: ['ROLE_USER', 'ROLE_ADMIN'] }
    }
  ]
})


router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('access_token');
  const role = localStorage.getItem('role');

  if (to.meta.requiresAuth){
    if (!token || !role){
      return next('/login');
    }

    if (to.meta.roles && !to.meta.roles.includes(role)){
      return next('/unauthorized');
    }
  }

  next();
});

export default router
