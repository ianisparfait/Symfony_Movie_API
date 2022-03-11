<template>
  <div class="container_app">
    <div id="inspire">
      <div class="get_films">
        <h2>GET</h2>
        <div class="contain_films">
          <a class="item" v-for="(item, count) in allDatas" :key="`${count}`" href="#">
            <img :src="item.poster" :alt="`Poster of ${item.name}`">
            <v-icon color="red" class="delete_item_film" @click="deleteItem(item.id)">mdi-delete-forever</v-icon>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      allDatas: [],

      protocol: "http://",
      domain: "127.0.0.1:8000/",
      apiRoute: "api/",
      format: ".json",
    }
  },
  mounted() {
    this.get();
  },
  methods: {
    async get() {
      this.allDatas = await axios.get(`${this.protocol}${this.domain}${this.apiRoute}films${this.format}`).then(response => (this.allDatas = response.data));
    },
  }
}
</script>