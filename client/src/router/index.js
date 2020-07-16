import Vue from 'vue'
import VueRouter from 'vue-router'

import store from '@/store';

import Home from '@/views/Home.vue'
import Login from '@/views/auth/Login.vue'

// middlewares
import guest from '@/middlewares/guest';
import auth from '@/middlewares/auth';
import authCheck from '@/middlewares/auth-check'
import middlewarePipeline from '@/router/middlewarePipeline';

Vue.use(VueRouter)

  const routes = [
    {
      path: '/',
      name: 'Home',
      component: Home,
      meta : {
        middleware : [auth, authCheck]
      }
    },
    {
      path: '/login',
      name: 'Login',
      component: Login,
      meta : {
        middleware : [guest]
      }
    },

]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})


router.beforeEach((to, from, next) => {
  // if there are no middlewares to this route just skip
  if ( !to.meta.middleware ) return next();

  const middleware = to.meta.middleware;
  const context = {to, from, next, store};

  return middleware[0]({...context, next: middlewarePipeline(context, middleware, 1)});
});

export default router
