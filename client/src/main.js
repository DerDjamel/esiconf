import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify';

Vue.config.productionTip = false

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: 'd1b801ab47517e6bf62d',
  cluster: 'eu',
  encrypted: true
});

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')

