import { createRouter, createWebHistory } from 'vue-router';
import SteamProfilePage from '../components/SteamProfilePage.vue';

const routes = [
  {
    path: '/steam',
    redirect: '/steam/1',
  },
  {
    path: '/steam/:id',
    name: 'SteamProfile',
    component: SteamProfilePage,
    props: true,
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL || '/app/'),
  routes,
});

export default router;