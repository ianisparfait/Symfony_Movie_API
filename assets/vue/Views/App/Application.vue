<template>
  <div class="container_app">
    <v-app id="inspire">
      <div class="get_films">
        <h2>GET</h2>
        <div class="contain_films">
          <a class="item" v-for="(item, count) in allDatas" :key="`${count}`" href="#">
            <img :src="item.poster" :alt="`Poster of ${item.name}`">
            <v-icon color="red" class="delete_item_film" @click="deleteItem(item.id)">mdi-delete-forever</v-icon>
          </a>
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
                      label="Picker without buttons"
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
      </div>
    </v-app>
  </div>
</template>

<script>
import axios from 'axios';

export default {
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
      protocol: "http://",
      domain: "127.0.0.1:8000/",
      apiRoute: "api/",
      format: ".json",

      menuDate: false,

      loader: null,
      loading: false,
    }
  },
  mounted() {
    this.get();
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
    async get() {
      this.allDatas = await axios.get(`${this.protocol}${this.domain}${this.apiRoute}films${this.format}`).then(response => (this.allDatas = response.data));
    },
    async post() {
      await axios.post(`${this.protocol}${this.domain}${this.apiRoute}films`, this.data).then(response => (this.get()));
    },
    async deleteItem(item) {
      await axios.delete(`${this.protocol}${this.domain}${this.apiRoute}films/${item}`).then(response => (this.get()));
    }
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