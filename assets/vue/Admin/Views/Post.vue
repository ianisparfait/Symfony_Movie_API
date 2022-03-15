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
              <!-- <v-text-field class="url_poster" label="Url d'affiche" outlined v-model="data.poster" :rules="emptyRule" required></v-text-field> -->

              <v-file-input accept=".png, .jpg, .jpeg" v-model="files" color="deep-purple accent-4" counter label="Ajouter une affiche" multiple placeholder="Selectionnez un fichier" prepend-icon="mdi-paperclip" outlined :show-size="1000">
                <template v-slot:selection="{ index, text }">
                  <v-chip v-if="index < 2" color="deep-purple accent-4" dark label small>
                    {{ text }}
                  </v-chip>
                  <span v-else-if="index === 2" class="text-overline grey--text text--darken-3 mx-2">
                    +{{ files.length - 2 }} Fichier(s)
                  </span>
                </template>
              </v-file-input>

            </v-col>
          </v-row>
          <v-row>
            <v-col col="5"> <!-- Duration -->
              <v-menu ref="menu" v-model="openDurationMenu" :close-on-content-click="false" :nudge-right="40" :return-value.sync="data.duration" transition="scale-transition" offset-y max-width="290px" min-width="290px">
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field v-model="data.duration" label="Durée du film" prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on"></v-text-field>
                </template>
                <v-time-picker v-if="openDurationMenu" v-model="data.duration" full-width @click:minute="$refs.menu.save(data.duration)"></v-time-picker>
              </v-menu>
            </v-col>
            <v-col col="5"> <!-- Director -->
              <v-text-field label="Nom du réalisateur" outlined v-model="data.director" :rules="emptyRule" required></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col col="10"> <!-- Actors -->
              <v-combobox v-model="data.actors" chips clearable label="Acteurs principaux" multiple prepend-icon="mdi-filter-variant" solo>
                <template v-slot:selection="{ attrs, item, select, selected }">
                  <v-chip v-bind="attrs" :input-value="selected" close @click="select" @click:close="remove(item)">
                    <strong>{{ item }}</strong>&nbsp;
                  </v-chip>
                </template>
              </v-combobox>
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
        <v-btn :color="`${fileUploaded ? 'green' : 'red'}`" text v-bind="attrs" @click="snackPost = false">
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
        actors: [],
        duration: 0,
        director: "",
      },

      menuDate: false,

      loader: null,
      loading: false,

      dialog: false,

      snackPost: false,
      textSnack: "",
      timeoutSnack: 1500,
      fileUploaded: false,

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

      files: [],
      openDurationMenu: false,
    }
  },
  watch: {
    loader () {
      const l = this.loader
      this[l] = !this[l]

      setTimeout(() => (this[l] = false), this.timeoutSnack)

      this.loader = null
    },
  },
  methods: {
    async post() {
      await axios.post(`${this.$api}films`, this.data)
        .then(response => {
          if (response.status === 201) {
            let data = new FormData(),
              xhr = new XMLHttpRequest(),
              vm = this;
            data.append('image', this.files[0]);
            xhr.open('POST', `${this.$domain}post-film-id`, true)
            xhr.send(data)
            xhr.onreadystatechange = function() {
              if (xhr.readyState == 4 && xhr.status == 200) {
                vm.fileUploaded = true;
                vm.textSnack = 'Film ajouté avec succés';
                vm.snackPost = !vm.snackPost;
              } else if (xhr.status == 400) {
                vm.fileUploaded = false;
                vm.textSnack = 'Ajout refusé';
                vm.snackPost = !vm.snackPost
              }
            }

          }
        })
      this.data = {
        name: "",
        description: "",
        date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        notation: 0,
        poster: "",
        categories: [],
        actors: [],
        duration: 0,
        director: "",
      };
    },
    validate () {
      this.$refs.form.validate();
      this.validForm ? this.post() : "";
    },
    remove (item) {
      this.data.actors.splice(this.data.actors.indexOf(item), 1)
      this.data.actors = [...this.data.actors]
    },
  }
}
</script>