import Vue from 'vue'
import Vuetify from 'vuetify';
import App from './App';
import router from './router';
import ru from 'vuetify/es5/locale/ru'
import VueI18n from 'vue-i18n'
import {languages} from './lang'
import {defaultLocale} from './lang'

const messages = Object.assign(languages);

Vue.use(Vuetify);
Vue.use(VueI18n);

var i18n = new VueI18n({
  locale: defaultLocale,
  fallbackLocale: 'de',
  messages
})

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify({
      lang: {
        locales: { ru },
        current: 'ru',
      },
    }),
    router,
    i18n,
    components: { App },
    template: '<App/>'
  });
