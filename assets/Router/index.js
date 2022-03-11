import VueRouter from 'vue-router';
Vue.use(VueRouter)


// Pages App
import Home from './../vue/Views/App/home.vue';

// Pages Core
import Login from './../vue/Views/Core/Login.vue';
import Register from './../vue/Views/Core/Register.vue';
import Account from './../vue/Views/Core/Account.vue';
import Vue from 'vue';


const routes = [
  { path: '', component: Home },
  { path: 'login', component: Login },
  { path: 'register', component: Register },
  { path: 'account', component: Account },
]

const router = new VueRouter({
  routes // short for `routes: routes`
})


export { router };