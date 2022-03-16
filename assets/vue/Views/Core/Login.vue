<template>
  <v-app id="inspire">
    <h1>Connexion</h1>
    <v-form>
      <v-text-field v-model="datas.email" outlined label="Email" required type="email" :rules="[rules.required, rules.min]"></v-text-field>
      <v-text-field v-model="datas.password" @click:append="show = !show" outlined label="Mot de passe" required :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'" :rules="[rules.required, rules.min]" :type="show ? 'text' : 'password'"></v-text-field>
      <v-btn outlined @click="checkLogin">Connexion</v-btn>
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
      timeoutSnack: 1500,
    }
  },
  methods: {
    async checkLogin() {
      await axios.post(`${this.$api}login`, this.datas)
        .then(res => {
          let tempToken = "";
          tempToken = res.data.token;
          if (tempToken != "") {
            this.login(tempToken)
          }
        })
    },
    async login(tok) {
      let vm = this
      axios.defaults.headers.common = {'Authorization': `Bearer ${tok}`}
      await axios.get(`${this.$api}users.json`)
        .then(res => {
          if (res.status === 200) {
            vm.textSnack = "Connexion réussi !"
            vm.snackPost = true;
            vm.loged = true;
          }
        })
    }
  }
}
</script>