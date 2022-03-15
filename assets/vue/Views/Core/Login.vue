<template>
  <v-app id="inspire">
    <h1>Connexion</h1>
    <v-form>
      <v-text-field v-model="datas.email" outlined label="Email" required type="email" :rules="[rules.required, rules.min]"></v-text-field>
      <v-text-field v-model="datas.password" @click:append="show = !show" outlined label="Mot de passe" required :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'" :rules="[rules.required, rules.min]" :type="show ? 'text' : 'password'"></v-text-field>
      <v-btn outlined @click="login">Connexion</v-btn>
    </v-form>
    <router-link to="/register">Pas de compte ? Inscrivez-vous</router-link>

    <v-snackbar v-model="snackPost" :timeout="timeoutSnack">
      {{ textSnack }}
      <template v-slot:action="{ attrs }">
        <v-btn :color="`${loged ? 'green' : 'red'}`" text v-bind="attrs" @click="snackPost = false">
          Fermer
        </v-btn>
      </template>
    </v-snackbar>
  </v-app>
</template>


<script>
import axios from 'axios';

export default {
  data() {
    return {
      datas: {
        email: "",
        password: ""
      },

      show: false,
      password: 'Password',
      rules: {
        required: value => !!value || 'Required.',
        min: v => v.length >= 3 || 'Min 3 characters',
      },

      loged: false,
      textSnack: "",
      snackPost: false,
      timeoutSnack: 1500
    }
  },
  methods: {
    login() {
      let xhr = new XMLHttpRequest(),
          data = new FormData(),
          vm = this;

      data.append('user_email', this.datas.email);
      data.append('user_password', this.datas.password);
      xhr.open('POST', `${this.$domain}login-user-logic`, true)
      xhr.send(data)
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          vm.loged = true;
          vm.textSnack = xhr.response;
          vm.snackPost = !vm.snackPost;
        } else if (xhr.status == 400) {
          vm.loged = false;
          vm.textSnack = xhr.response;
          vm.snackPost = !vm.snackPost
        }
      }
    }
  }
}
</script>