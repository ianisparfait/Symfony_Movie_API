<template>
  <v-app id="inspire">
    {{movieDatas.name}}
  </v-app>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      protocol: "http://",
      domain: "127.0.0.1:8000/",
      apiRoute: "api/",
      format: ".json",

      movieID: 0,

      movieDatas: {},
    }
  },
  mounted() {
    this.geturl()
  },
  methods: {
    geturl() {
      let getMovieID = document.URL.match(/movie\/(\d+)/)[0];
      this.movieID = parseInt(getMovieID.match(/(\d+)/)[0]);

      this.retrieveMovie();
    },
    async retrieveMovie() {
      await axios.get(`${this.protocol}${this.domain}${this.apiRoute}films/${this.movieID}`)
        .then(res => {
          this.movieDatas = res.data
        })
    }
  },
}
</script>