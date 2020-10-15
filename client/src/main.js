import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify';
import flash from './components/globale/flash.vue';
Vue.config.productionTip = false


Vue.component('flash', flash);


window.events = new Vue();
window.flash = function(message){
  window.events.$emit('flash', message);
}

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')

