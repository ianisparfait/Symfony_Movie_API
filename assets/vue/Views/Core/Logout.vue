<template>
  <v-app id="inspire"></v-app>
</template>

<script>
export default {
  mounted() {
    this.logout();
  },
  methods: {
    logout() {
      let xhr = new XMLHttpRequest(),
          data = new FormData(),
          vm = this;

      data.append('', '');
      xhr.open('POST', `${this.$domain}logout`, true)
      xhr.send(data);
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          window.location.href = `${vm.$domain}`;
        }
      }
    }
  }
}
</script>