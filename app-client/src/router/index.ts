/**
 * router/index.ts
 *
 * Automatic routes for `./src/pages/*.vue`
 */

// Composables
import { createRouter, createWebHistory } from 'vue-router'
import { setupLayouts } from 'virtual:generated-layouts'

const routes = [
  {
    name: 'Login',
    path: '/login',
    component: () => import('../pages/login.vue'),
    meta: { layout: 'blank' }
  },
  {
    name: 'Home',
    path: '/home',
    component: () => import('../pages/home.vue'),
    meta: { layout: 'default'},
  },
  {
    name: 'Favoritos',
    path: '/favoritos',
    component: () => import('../pages/favoritos.vue'),
    meta: { layout: 'default'},
  },
  {
    name: 'Profile',
    path: '/profile',
    component: () => import('../pages/profile.vue'),
    meta: { layout: 'default'},
  },
  {
    name: 'PontoNovo',
    path: '/pontos/novo',
    component: () => import('../pages/pontos/novo.vue'),
    meta: { layout: 'default'},
  },
  {
    name: 'PontoId',
    path: '/pontos/:id',
    component: () => import('../pages/pontos/[id].vue'),
    meta: { layout: 'default'},
  },
  {
    name: 'Usuarios',
    path: '/usuarios',
    component: () => import('../pages/usuarios/index.vue'),
    meta: { layout: 'default'},
  },
  {
    name: 'UsuariosNovo',
    path: '/usuarios/novo',
    component: () => import('../pages/usuarios/novo.vue'),
    meta: { layout: 'default'},
  },
  {
    name: 'HospedagemNova',
    path: '/pontos/:id/hospedagens/nova',
    component: () => import('../pages/hospedagens/nova.vue'),
    meta: { layout: 'default'},
  },
  {
    name: 'Hospedagens',
    path: '/hospedagens',
    component: () => import('../pages/hospedagens/index.vue'),
    meta: { layout: 'default'},
  },
  {
    name: 'mais-acessados',
    path: '/mais-acessados',
    component: () => import('../pages/MaisAcessados.vue'),
    meta: { layout: 'default'},
  },

]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: setupLayouts(routes),
})

// Workaround for https://github.com/vitejs/vite/issues/11804
router.onError((err, to) => {
  if (err?.message?.includes?.('Failed to fetch dynamically imported module')) {
    if (localStorage.getItem('vuetify:dynamic-reload')) {
      console.error('Dynamic import error, reloading page did not fix it', err)
    } else {
      console.log('Reloading page to fix dynamic import error')
      localStorage.setItem('vuetify:dynamic-reload', 'true')
      location.assign(to.fullPath)
    }
  } else {
    console.error(err)
  }
})

router.isReady().then(() => {
  localStorage.removeItem('vuetify:dynamic-reload')
})

export default router
