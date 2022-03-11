import Vue from "vue";
import Application from './../vue/Views/App/Application.vue';
import vuetify from './../vue/Plugins/vuetifyImport.js';

import { router as r } from "../Router";

import './../styles/app.scss';

Vue.config.productionTip = false

new Vue({
  vuetify,
  router: r,
  render(h) {
    return h(Application)
  },
}).$mount('#app')