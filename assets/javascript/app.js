import Vue from "vue";
import Application from './../vue/Views/App/Application.vue';
import vuetify from './../vue/Plugins/vuetifyImport.js'

import './../styles/app.scss'

new Vue({
  vuetify,
  render(h) {
    return h(Application)
  },
}).$mount('#app')
