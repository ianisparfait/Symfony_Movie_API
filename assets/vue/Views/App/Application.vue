<template>
  <div class="container_app">
    <v-app id="inspire">

      <app-nav></app-nav>

      <!-- <div class="get_films">
        <h2>GET</h2>
        <div class="contain_films">
          <a class="item" v-for="(item, count) in allDatas" :key="`${count}`" href="#">
            <img :src="item.poster" :alt="`Poster of ${item.name}`">
            <v-icon color="red" class="delete_item_film" @click="deleteItem(item.id)">mdi-delete-forever</v-icon>
          </a>
        </div>
      </div>

      <div class="put_films">
        <h2>PUT</h2>
        <div class="contain_films">
          <v-row justify="center">
            <a class="item" v-for="(item, count) in allDatas" :key="`${count}`" href="#">
              <v-btn color="primary" dark @click.stop="dialog = true" @click="updateData(item)">
                {{item.name}}
                <v-icon>mdi-pencil</v-icon>
              </v-btn>

              <v-dialog v-model="dialog" max-width="700">
                <v-card>
                  <v-card-title class="text-h5">
                    {{item.name}}
                  </v-card-title>

                  <v-card-text>
                    <div class="contain_form">
                      <div class="name_desc">
                        <v-row>
                          <v-col col="5">
                            <v-text-field label="Nom du film" outlined v-model="data.name"></v-text-field>
                          </v-col>
                          <v-col col="5">
                            <v-textarea outlined name="film description" label="Descritpion du film" v-model="data.description"></v-textarea>
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
                        <v-col col="11">
                          <v-text-field class="url_poster" label="Url d'affiche" outlined v-model="data.poster"></v-text-field>
                        </v-col>
                      </v-row>
                    </div>
                  </v-card-text>

                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red darken-1" text @click="dialog = false">Annuler</v-btn>

                    <v-btn color="green darken-1" text  @click="dialog = false; put(item.id)">Modifier</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </a>
          </v-row>
        </div>
      </div>

      <div class="post_films">
        <h2>POST</h2>
        <div class="contain_form">
          <div class="name_desc">
            <v-row>
              <v-col col="5">
                <v-text-field label="Nom du film" outlined v-model="data.name"></v-text-field>
              </v-col>
              <v-col col="5">
                <v-textarea outlined name="film description" label="Descritpion du film" v-model="data.description"></v-textarea>
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
            <v-col col="11">
              <v-text-field class="url_poster" label="Url d'affiche" outlined v-model="data.poster"></v-text-field>
            </v-col>
          </v-row>

          <v-btn :loading="loading" :disabled="loading" color="blue-grey" class="ma-2 white--text" @click="loader = 'loading'; post()">
            Enregistrer
            <v-icon right dark >
              mdi-cloud-upload
            </v-icon>
          </v-btn>
        </div>
      </div> -->

      <div class="container content pt-5">
        <router-view v-slot="{ Component }">
          <transition name="fade" mode="out-in" @after-leave="$root.$emit('mx::scroll::page')">
            <component :is="Component" />
          </transition>
        </router-view>
      </div>
    </v-app>
  </div>
</template>

<script>
import axios from 'axios';

import Nav from './../../Components/Nav.vue';

export default {
  components: {
    'app-nav': Nav
  },
  data() {
    return {
      allDatas: [],
      data: {
        name: "",
        description: "",
        date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        notation: 0,
        poster: "",
      },

      menuDate: false,

      loader: null,
      loading: false,

      dialog: false,
    }
  },
  // mounted() {
  //   this.get();
  // },
  watch: {
    loader () {
      const l = this.loader
      this[l] = !this[l]

      setTimeout(() => (this[l] = false), 1000)

      this.loader = null
    },
  },
  methods: {
    async get() {
      this.allDatas = await axios.get(`${this.$api}films${this.$jsonFormat}`).then(response => (this.allDatas = response.data));
    },
    async post() {
      await axios.post(`${this.$api}films`, this.data).then(response => (this.get()));
    },
    async deleteItem(item) {
      await axios.delete(`${this.$api}films/${item}`).then(response => (this.get()));
    },
    async put(item) {
      await axios.put(`${this.$api}films/${item}`, this.data).then(response => (this.get()));
      this.data = {
        name: "",
        description: "",
        date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        notation: 0,
        poster: "",
      }
    },
    updateData(item) {
      this.data.name = item.name;
      this.data.description = item.description;
      this.data.date = item.date;
      this.data.notation = item.notation;
      this.data.poster = item.poster;
    },
  }
}
</script>

<style>
  .custom-loader {
    animation: loader 1s infinite;
    display: flex;
  }
  @-moz-keyframes loader {
    from {
      transform: rotate(0);
    }
    to {
      transform: rotate(360deg);
    }
  }
  @-webkit-keyframes loader {
    from {
      transform: rotate(0);
    }
    to {
      transform: rotate(360deg);
    }
  }
  @-o-keyframes loader {
    from {
      transform: rotate(0);
    }
    to {
      transform: rotate(360deg);
    }
  }
  @keyframes loader {
    from {
      transform: rotate(0);
    }
    to {
      transform: rotate(360deg);
    }
  }
</style>