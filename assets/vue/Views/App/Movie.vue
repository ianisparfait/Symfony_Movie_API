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
      await axios.get(`${this.$api}films/${this.movieID}`)
        .then(res => {
          this.movieDatas = res.data
        })
    }
  },
}
</script>