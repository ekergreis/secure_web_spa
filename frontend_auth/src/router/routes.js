// [OAUTH] meta requiresAuth: true => Authentification nécessaire pour accéder à la route
// [ROLE] meta requiresAdmin: true => Contôle sur utilisateur du group "admin" pour accéder à route
const routes = [
  {
    path: '/',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/Index.vue'), meta: { requiresAdmin: false } },
      { path: '/page1', component: () => import('pages/Page1.vue'), meta: { requiresAdmin: false } },
      { path: '/page2', component: () => import('pages/Page2.vue'), meta: { requiresAdmin: false } },
      { path: '/user', component: () => import('pages/User.vue'), meta: { requiresAdmin: true } },
    ],
    meta: {
      requiresAuth: true,
      requiresAdmin: false,
    },
  },
  {
    path: '/login',
    component: () => import('pages/Login.vue'),
    meta: {
      requiresAuth: false,
      requiresAdmin: false,
    },
  },
];

// Always leave this as last one
if (process.env.MODE !== 'ssr') {
  routes.push({
    path: '*',
    component: () => import('pages/Error404.vue'),
  });
}

export default routes;
