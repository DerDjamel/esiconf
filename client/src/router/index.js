import Vue from 'vue'
import VueRouter from 'vue-router'

import store from '@/store';

// views
import Home from '@/views/Home.vue'
import Login from '@/views/auth/Login.vue'
import ListConferences from '@/views/conference/list-conferences.vue';
import SingleConference from '@/views/conference/single-conference.vue';
import SingleReview from '@/views/review/single-review.vue';
import SinglePaper from '@/views/paper/single-paper.vue';
import ConferenceForm from '@/components/conference/conference-form.vue';
import ReviewForm from '@/components/review/review-form.vue';
import PaperForm from '@/components/paper/paper-form.vue';


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
    {
      path: '/conferences',
      name: 'Conferences',
      component: ListConferences,
      meta : {
        middleware : [auth, authCheck]
      }
    },
    {
      path: '/conference/create',
      name: 'ConferenceForm',
      component: ConferenceForm,
      meta : {
        middleware : [auth, authCheck]
      }
    },
    {
      path: '/conference/:slug',
      name: 'SingleConference',
      component: SingleConference,
      props : true,
      meta : {
        middleware : [auth, authCheck]
      }
    },
    {
      path: '/review/create',
      name: 'ReviewForm',
      component: ReviewForm,
      meta : {
        middleware : [auth, authCheck]
      }
    },
    {
      props: true,
      path: '/review/:id',
      name: 'SingleReview',
      component: SingleReview,
      meta : {
        middleware : [auth, authCheck]
      }
    },
    {
      path: '/paper/create',
      name: 'PaperForm',
      component: PaperForm,
      meta : {
        middleware : [auth, authCheck]
      }
    },
    {
      props: true,
      path: '/paper/:id',
      name: 'SinglePaper',
      component: SinglePaper,
      meta : {
        middleware : [auth, authCheck]
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
