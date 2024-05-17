<!-- App.vue -->
<template>
  <div id="app">
    <Header :key="headerKey" />
    <router-view :key="mainContentKey" />
    <Footer />
  </div>
</template>

<script>
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';

export default {
  components: {
    Header,
    Footer,
  },
  data() {
    return {
      headerKey: 0,
      mainContentKey: 0,
    };
  },
  watch: {
    $route() {
      this.headerKey += 1;
      this.mainContentKey += 1;
    },
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  text-align: center;
  color: #2c3e50;
}
</style>
