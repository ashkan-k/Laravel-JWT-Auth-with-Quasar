
const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import('pages/Index.vue') },
      { path: 'profile', component: () => import('pages/Profile.vue') }
    ]
  },
  {
    path: '/login',
    component: () => import('pages/login')
  },

  {
    path: '/register',
    component: () => import('pages/register.vue')
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
