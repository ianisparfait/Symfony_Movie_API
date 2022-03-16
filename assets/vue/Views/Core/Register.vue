<template>
  <v-app id="inspire">
    <h1>Inscription</h1>
    <v-form>
      <v-text-field v-model="datas.email" outlined label="Email" required type="email" :rules="[rules.required, rules.min]"></v-text-field>
      <v-text-field v-model="datas.password" @click:append="show = !show" outlined label="Mot de passe" required :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'" :rules="[rules.required, rules.min]" :type="show ? 'text' : 'password'"></v-text-field>
      <v-btn outlined @click="register">Inscription</v-btn>
    </v-form>
    <router-link to="/login">Déjà un compte ? Connectez-vous</router-link>
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
    }
  },
  methods: {
    // register() {
    //   let xhr = new XMLHttpRequest(),
    //       data = new FormData(),
    //       vm = this;

    //   data.append('user_email', this.datas.email);
    //   data.append('user_password', this.datas.password);
    //   xhr.open('POST', `${this.$domain}register-user`, true)
    //   xhr.send(data)
    //   xhr.onreadystatechange = function() {
    //     if (xhr.readyState == 4 && xhr.status == 200) {
    //       console.log('registred')
    //     }
    //   }
    // }
    async register() {
      await axios.post(`${this.$api}users`, this.datas)
        .then(res => {
          console.log("registred");
        })
    }
  }
}
</script>