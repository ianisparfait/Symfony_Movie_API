<template>
  <div class="container_app">
    <v-app id="inspire">
      <div class="get_films">
        <h2>GET</h2>
        <v-row>
          <v-col cols="12" sm="6">
            <v-text-field v-model="searchName" label="Recherche par nom" outlined clearable></v-text-field>
          </v-col>
        </v-row>

        <div class="contain_films">
          <a class="item" v-for="(item, count) in allDatas" :key="`${count}`" href="#">
            <img :src="item.poster" :alt="`Poster of ${item.name}`">
            <v-icon color="red" class="delete_item_film" @click="deleteItem(item.id)">mdi-delete-forever</v-icon>
          </a>
          <!-- <span v-if="allDatas.length === 0">Aucun films trouvé !</span> -->
        </div>
        <v-pagination v-model="currentPage" :length="totalPages" :total-visible="7"></v-pagination>
      </div>
    </v-app>
  </div>
</template>

<script>
import axios from 'axios';
import { jsonld2obj } from 'jsonld-object-graph'

export default {
  data() {
    return {
      allDatas: [],

      protocol: "http://",
      domain: "127.0.0.1:8000/",
      apiRoute: "api/",
      format: ".json",

      itemsPerPage: 3,
      totalItems: 0,
      totalPages: 1,
      currentPage: 1,

      searchName: "",
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
      if (this.searchName == "") {
        this.all();
      } else {
        this.searchInName();
      }

      if (localStorage.getItem('getCurrentPage')) {
        localStorage.removeItem('getCurrentPage')
        localStorage.setItem('getCurrentPage', val)
      } else {
        localStorage.setItem('getCurrentPage', val)
      }
    },
    searchName(val) {
      this.searchInName();
    },
    totalPages(val) {
      this.currentPage = this.currentPage > val ? 1 : this.currentPage
    }
  },
  methods: {
    async all() {
      await axios.get(`${this.protocol}${this.domain}${this.apiRoute}films?itemsPerPage=${this.itemsPerPage}&page=${this.currentPage}`)
        .then(res => {
          this.totalItems = res.data['hydra:totalItems']
          if (res.data['hydra:view']) {
            let getPageEqual = res.data['hydra:view']['hydra:last'].match(/page=(\d+)/)[0];
            this.totalPages = parseInt(getPageEqual.match(/(\d+)/)[0])
          }
          this.allDatas = res.data['hydra:member'];
        })
    },
    setupCurrentPage() {
      this.currentPage = localStorage.getItem('getCurrentPage') ? parseInt(localStorage.getItem('getCurrentPage')) : 1;
    },
    async searchInName() {
      await axios.get(`${this.protocol}${this.domain}${this.apiRoute}films?itemsPerPage=${this.itemsPerPage}&page=${this.currentPage}&name=${this.searchName}`)
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
  }
}
</script>