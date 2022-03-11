import VueRouter from 'vue-router';
Vue.use(VueRouter)


// Pages App
import Home from './../vue/Views/App/home.vue';

// Pages Core
import Login from './../vue/Views/Core/Login.vue';
import Register from './../vue/Views/Core/Register.vue';
import Account from './../vue/Views/Core/Account.vue';

// Admin
import Post from './../vue/Admin/Views/Post.vue';
import Vue from 'vue';


const routes = [
  { path: '/', component: Home, name: "Home" },
  { path: '/login', component: Login, name: "Login" },
  { path: '/register', component: Register, name: "Register" },
  { path: '/account', component: Account, name: "Account" },
  { path: '/post-film', component: Post, name: "Post" },
]

const router = new VueRouter({
  routes // short for `routes: routes`
})


export { router };