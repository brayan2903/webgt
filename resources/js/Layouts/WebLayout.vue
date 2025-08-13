<template>
  <div class="web-layout">
    <Header />
    <main>
      <slot />
    </main>
    <Footer />
  </div>
</template>

<script setup>
import Header from '@/Components/Publico/Header.vue';
import Footer from '@/Components/Publico/Footer.vue';
</script>

<style scoped>
main {
  flex: 1;
}
</style>
