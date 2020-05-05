import Vue from 'vue'
import Vuetify from 'vuetify';
import App from './App';
import router from './router';
import ru from 'vuetify/es5/locale/ru'

Vue.use(Vuetify);

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify({
      lang: {
        locales: { ru },
        current: 'ru',
      },
    }),
    router,
    components: { App },
    template: '<App/>'
  });
