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

      itemsPerPage: 0,
      totalItems: 0,
      totalPages: 0,
      currentPage: 1,
    }
  },
  created() {
    this.setupCurrentPage();
  },
  mounted() {
    this.all();
  },
  watch: {
    allDatas(val) {
      this.itemsPerPage = val.length;
    },
    currentPage(val) {
      this.all();

      if (localStorage.getItem('getCurrentPage')) {
        localStorage.removeItem('getCurrentPage')
        localStorage.setItem('getCurrentPage', val)
      } else {
        localStorage.setItem('getCurrentPage', val)
      }
    }
  },
  methods: {
    async all() {
      await axios.get(`${this.protocol}${this.domain}${this.apiRoute}films?page=${this.currentPage}`)
        .then(res => {
          this.totalItems = res.data['hydra:totalItems']
          this.totalPages = parseInt(res.data['hydra:view']['hydra:last'].match(/(\d+)/)[0])
          this.allDatas = res.data['hydra:member'];
        })
    },
    setupCurrentPage() {
      this.currentPage = localStorage.getItem('getCurrentPage') ? parseInt(localStorage.getItem('getCurrentPage')) : 1;
    }
  }
}
</script>