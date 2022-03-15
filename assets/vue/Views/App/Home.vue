<template>
  <div class="container_app">
    <v-app id="inspire">
      <div class="get_films">
        <h2>GET</h2>
        <v-row>
          <v-col>
            <v-subheader></v-subheader>
            <v-text-field prepend-inner-icon="mdi-database-search" v-model="searchFilters.name" label="Nom" outlined></v-text-field>
          </v-col>
          <v-col>
            <v-subheader></v-subheader>
            <v-text-field prepend-inner-icon="mdi-database-search" v-model="searchFilters.description" label="Description" outlined></v-text-field>
          </v-col>
          <v-col>
            <v-subheader>recherche par année</v-subheader>
            <v-otp-input length="4" v-model="searchFilters.date"></v-otp-input>
          </v-col>
          <v-col>
            <v-subheader>recherche par note</v-subheader>
            <v-slider v-model="searchFilters.notation" :max="5" :min="0" thumb-label step="1"></v-slider>
          </v-col>
          <v-col>
            <v-subheader></v-subheader>
            <v-select v-model="searchFilters.categories" :items="allCategs" label="Catégories" outlined required></v-select>
          </v-col>
          <v-col>
            <v-subheader></v-subheader>
            <v-text-field prepend-inner-icon="mdi-database-search" v-model="searchFilters.actors" label="Acteur" outlined></v-text-field>
          </v-col>
          <v-col>
            <v-subheader></v-subheader>
            <v-text-field prepend-inner-icon="mdi-database-search" v-model="searchFilters.director" label="Réalisateur" outlined></v-text-field>
          </v-col>
          <v-col>
            <v-subheader>Supprimer les filtres</v-subheader>
            <v-btn class="mx-2" fab dark small color="primary" @click="resetFilters">
              <v-icon dark>
                mdi-delete
              </v-icon>
            </v-btn>
          </v-col>
        </v-row>

        <div class="contain_films">
          <router-link class="item" v-for="(item, count) in allDatas" :key="`${count}`" :to="`/movie/${item.id}`">
            <img :src="`./../../../../uploads/posters/${item.poster}`" :alt="`Poster of ${item.name}`">
            <v-icon color="red" class="delete_item_film" @click="deleteItem(item.id)">mdi-delete-forever</v-icon>
          </router-link>
        </div>
        <v-pagination v-model="currentPage" :length="totalPages" :total-visible="7"></v-pagination>
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

      itemsPerPage: 3,
      totalItems: 0,
      totalPages: 1,
      currentPage: 1,

      searchFilters: {
        name: "",
        description: "",
        date: "",
        notation: "",
        categories: "",
        actors: "",
        duration: "",
        director: "",
      },

      menuDate: false,

      loader: null,
      loading: false,

      dialog: false,
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
      openDurationMenu: false
    }
  },
  created() {
    this.setupCurrentPage();
  },
  mounted() {
    this.all();
  },
  watch: {
    currentPage(val) {
      if (this.searchFilters.name == ""
          && this.searchFilters.description == ""
          && this.searchFilters.date == ""
          && this.searchFilters.notation == ""
          && this.searchFilters.categories == ""
          && this.searchFilters.actors == ""
          && this.searchFilters.duration == ""
          && this.searchFilters.director == "") {
        this.all();
      } else {
        this.searchFiltersAPI();
      }

      if (localStorage.getItem('getCurrentPage')) {
        localStorage.removeItem('getCurrentPage')
        localStorage.setItem('getCurrentPage', val)
      } else {
        localStorage.setItem('getCurrentPage', val)
      }
    },
    'searchFilters.name': function() {
      this.searchFiltersAPI();
    },
    'searchFilters.description': function() {
      this.searchFiltersAPI();
    },
    'searchFilters.date': function() {
      this.searchFiltersAPI();
    },
    'searchFilters.notation': function(val) {
      this.searchFiltersAPI();
    },
    'searchFilters.categories': function() {
      this.searchFiltersAPI();
    },
    'searchFilters.actors': function() {
      this.searchFiltersAPI();
    },
    'searchFilters.duration': function() {
      this.searchFiltersAPI();
    },
    'searchFilters.director': function() {
      this.searchFiltersAPI();
    },
    totalPages(val) {
      this.currentPage = this.currentPage > val ? 1 : this.currentPage
    },
  },
  methods: {
    async all() {
      await axios.get(`${this.$api}films?itemsPerPage=${this.itemsPerPage}&page=${this.currentPage}`)
        .then(res => {
          this.totalItems = res.data['hydra:totalItems']
          if (res.data['hydra:view'] && res.data['hydra:totalItems'] > this.itemsPerPage) {
            let getPageEqual = res.data['hydra:view']['hydra:last'].match(/page=(\d+)/)[0];
            this.totalPages = parseInt(getPageEqual.match(/(\d+)/)[0])
          }
          this.allDatas = res.data['hydra:member'];
        })
    },
    setupCurrentPage() {
      this.currentPage = localStorage.getItem('getCurrentPage') ? parseInt(localStorage.getItem('getCurrentPage')) : 1;
    },
    async searchFiltersAPI() {
      await axios.get(`${this.$api}films` +
        `?itemsPerPage=${this.itemsPerPage}` +
        `&page=${this.currentPage}` +
        `&name=${this.searchFilters.name}` +
        `&description=${this.searchFilters.description}` +
        `&date=${this.searchFilters.date}` +
        `&notation=${this.searchFilters.notation != 0 ? this.searchFilters.notation : ""}` +
        `&categories=${this.searchFilters.categories}` +
        `&actors=${this.searchFilters.actors}` +
        `&duration=${this.searchFilters.duration}` +
        `&director=${this.searchFilters.director}`
        )
        .then(res => {
          this.totalItems = res.data['hydra:totalItems']
          if (res.data['hydra:view'] && res.data['hydra:view']['hydra:last']) {
            let getPageEqual = res.data['hydra:view']['hydra:last'].match(/page=(\d+)/)[0];
            this.totalPages = parseInt(getPageEqual.match(/(\d+)/)[0])
          } else {
            this.totalPages = 1;
          }
          this.allDatas = res.data['hydra:member'];
        })
    },
    removeAccents(str) {
      return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    },
    resetFilters() {
      this.searchFilters = {
        name: "",
        description: "",
        date: "",
        notation: "",
        categories: "",
        actors: "",
        duration: "",
        director: "",
      };
    }
  }
}
</script>