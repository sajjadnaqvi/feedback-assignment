import Vue from 'vue';
import VueRouter from 'vue-router';

import HomeComponent from './views/HomeComponent.vue';
import LoginComponent from './views/LoginComponent.vue'
import SignupComponent from './views/SignupComponent.vue'

Vue.use(VueRouter);


const routes = [
  { path: '/', component: HomeComponent },
  { path: '/login', component: LoginComponent },
  { path: '/signup', component: SignupComponent }
];


const router = new VueRouter({
    routes
  });

export default router;