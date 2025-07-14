<template>
  <div id="app">
    <CryptoList />
  </div>
</template>

<script>
import CryptoList from './components/CryptoList.vue';

export default {
  name: 'App',
  components: {
    CryptoList,
  },
};
</script>
