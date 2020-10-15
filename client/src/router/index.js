import Vue from 'vue'
import VueRouter from 'vue-router'

import store from '@/store';

// views
import Profile from '@/components/profile/profile-card.vue';
//import Home from '@/views/Home.vue';
import Login from '@/views/auth/Login.vue';
import Register from '@/views/auth/Register.vue'
import ListConferences from '@/views/conference/list-conferences.vue';
import ListUserConferences from '@/components/conference/list-user-conferences.vue';
import SingleConference from '@/views/conference/single-conference.vue';
import SingleReview from '@/views/review/single-review.vue';
import SinglePaper from '@/views/paper/single-paper.vue';
import ConferenceForm from '@/components/conference/conference-form.vue';
import ReviewForm from '@/components/review/review-form.vue';
import PaperForm from '@/components/paper/paper-form.vue';
import ListPapers from '@/components/paper/list-papers.vue';
import ListUserPapers from '@/components/paper/list-user-papers.vue';
import ListReviews from '@/components/review/list-reviews.vue';
import ListUserReviews from '@/components/review/list-user-reviews.vue';
import ListBids from '@/components/bid/list-bids.vue';
import ListUserBids from '@/components/bid/list-user-bids.vue';
//import ProfileCard from '@/components/profile/profile-card.vue';

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
      component: Profile,
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
      path: '/register',
      name: 'Register',
      component: Register,
      meta : {
        middleware : [guest]
      }
    },
    {
      path: '/my-papers',
      name: 'MyPapers',
      component: ListUserPapers,
      props : true,
      meta : {
        middleware : [auth, authCheck]
      }
    },
    {
      path: '/my-reviews',
      name: 'MyReviews',
      component: ListUserReviews,
      props : true,
      meta : {
        middleware : [auth, authCheck]
      }
    },
    {
      path: '/my-bids',
      name: 'MyBids',
      component: ListUserBids,
      props : true,
      meta : {
        middleware : [auth, authCheck]
      }
    },
    {
      path: '/my-conferences',
      name: 'MyConferences',
      component: ListUserConferences,
      props : true,
      meta : {
        middleware : [auth, authCheck]
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
      path: '/conference/:slug/papers',
      name: 'ConferencePapers',
      component: ListPapers,
      props : true,
      meta : {
        middleware : [auth, authCheck]
      }
    },
    {
      path: '/conference/:slug/reviews',
      name: 'ConferenceReviews',
      component: ListReviews,
      props : true,
      meta : {
        middleware : [auth, authCheck]
      }
    },
    {
      path: '/conference/:slug/bids',
      name: 'ConferenceBids',
      component: ListBids,
      props : true,
      meta : {
        middleware : [auth, authCheck]
      }
    },
    {
      props: true,
      path: '/review/create/paper/:id',
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
      props: true,
      path: '/paper/create/conference/:slug',
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
