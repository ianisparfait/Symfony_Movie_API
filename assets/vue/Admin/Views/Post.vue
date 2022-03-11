<template>
  <v-app id="inspire">
    <div class="post_films">
      <h2>POST</h2>
      <div class="contain_form">
        <v-form ref="form" v-model="validForm" lazy-validation>
          <div class="name_desc">
            <v-row>
              <v-col col="5">
                <v-text-field label="Nom du film" outlined v-model="data.name" :rules="emptyRule" required></v-text-field>
              </v-col>
              <v-col col="5">
                <v-textarea outlined name="film description" label="Descritpion du film" v-model="data.description" :rules="emptyRule" required></v-textarea>
              </v-col>
            </v-row>
          </div>
          <div class="infos">
            <v-row>
              <v-col cols="6" >
                <v-subheader>Note du film</v-subheader>
                <v-slider v-model="data.notation" class="align-center" :max="5" :min="0" thumb-label step="1"></v-slider>
              </v-col>
              <v-col cols="6" >
                <v-menu
                  v-model="menuDate"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  transition="scale-transition"
                  offset-y
                  min-width="auto"
                  required
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="data.date"
                      label="Date de sortie"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="data.date"
                    @input="menuDate = false"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-spacer></v-spacer>
            </v-row>
          </div>
          <v-row>
            <v-col class="d-flex" cols="5">
              <v-select v-model="data.categories" :items="allCategs" chips label="Catégories" multiple outlined :rules="emptyRule" required></v-select>
            </v-col>
            <v-col col="5">
              <v-text-field class="url_poster" label="Url d'affiche" outlined v-model="data.poster" :rules="emptyRule" required></v-text-field>
            </v-col>
          </v-row>
        </v-form>

        <v-btn :loading="loading" :disabled="loading" color="blue-grey" class="ma-2 white--text" @click="loader = 'loading'; validate()">
          Enregistrer
          <v-icon right dark >
            mdi-cloud-upload
          </v-icon>
        </v-btn>
      </div>
    </div>

    <v-snackbar v-model="snackPost" :timeout="timeoutSnack">
      {{ textSnack }}
      <template v-slot:action="{ attrs }">
        <v-btn color="green" text v-bind="attrs" @click="snackPost = false">
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
      data: {
        name: "",
        description: "",
        date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        notation: 0,
        poster: "",
        categories: [],
      },
      protocol: "http://",
      domain: "127.0.0.1:8000/",
      apiRoute: "api/",
      format: ".json",

      menuDate: false,

      loader: null,
      loading: false,

      dialog: false,

      snackPost: false,
      textSnack: 'Film ajouté avec succés',
      timeoutSnack: 2000,

      allCategs: [
        "Action",
        "Aventure",
        "Comédie",
        "Drame",
        "Documentaire",
        "Famille",
        "Fantaisie",
        "Horreur",
        "Romance",
        "Science fiction",
        "Suspense",
        "Anime",
        "Guerre",
        "Sport",
        "Thriller - Policier",
      ],

      validForm: true,
      emptyRule: [
        v => !!v || 'Ce champs ne peut pas être vide',
        v => (v && v.length >= 1) || 'Ce champs ne peut pas être vide',
      ],
    }
  },
  watch: {
    loader () {
      const l = this.loader
      this[l] = !this[l]

      setTimeout(() => (this[l] = false), 1000)

      this.loader = null
    },
  },
  methods: {
    async post() {
      await axios.post(`${this.protocol}${this.domain}${this.apiRoute}films`, this.data).then(response => (this.snackPost = !this.snackPost));
      this.data = {
        name: "",
        description: "",
        date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        notation: 0,
        poster: "",
        categories: [],
      };
    },
    validate () {
      this.$refs.form.validate();
      this.validForm ? this.post() : "";
    },
  }
}
</script>