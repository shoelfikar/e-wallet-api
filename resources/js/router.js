import Vue from 'vue';
import Router from 'vue-router';
import Index from './view/index';
import Login from './view/Login.vue';
import Register from './view/Register.vue';

Vue.use(Router)


const routes = [
  {
    path: "/",
    name: 'test',
    component: Index
  },
  {
    path: "/login",
    name: 'login',
    component: Login
  },
  {
    path: "/register",
    name: 'register',
    component: Register
  }
]

const router = new Router({
  routes: routes
})


export default router;
