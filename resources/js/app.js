import Vue from 'vue'
import Vuetify from 'vuetify';
import App from './App';
import router from './router';
Vue.use(Vuetify);

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    router,
    components: { App },
    template: '<App/>'
  });
