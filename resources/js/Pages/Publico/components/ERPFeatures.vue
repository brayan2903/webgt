<template>
  <section class="erp-section">
    <h2 class="erp-title">
      Toda la <span class="highlight">tecnología</span> en una sola plataforma
    </h2>

    <div class="erp-grid">
      <div class="erp-item" v-for="item in items" :key="item.nombre">
        <img :src="item.img" :alt="item.nombre" />
        <p class="label">{{ item.nombre }}</p>
      </div>
    </div>
  </section>
</template>

<script setup>
const items = [
  {
    nombre: 'Taller',
    img: '/logo.png', // Coloca aquí tus imágenes en public/img/erp/
  },
  {
    nombre: 'Gastos',
    img: '/logo.png',
  },
  {
    nombre: 'Punto de venta',
    img: '/logo.png',
  },
  {
    nombre: 'IoT',
    img: '/logo.png',
  },
];
</script>

<style scoped>
.erp-section {
  padding: 4rem 1rem;
  background-color: #ffffff;
  text-align: center;
}

.erp-title {
  font-size: 2.2rem;
  font-weight: 700;
  margin-bottom: 3rem;
  color: #1a1a1a;
  font-family: 'Nunito', sans-serif;
}

.highlight {
  background: #00aef0;
  color: #000;
  padding: 0 8px;
  border-radius: 5px;
  font-style: italic;
}

.erp-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
  gap: 2rem;
  max-width: 1100px;
  margin: 0 auto;
  align-items: center;
  justify-items: center;
}

.erp-item {
  text-align: center;
  max-width: 200px;
}

.erp-item img {
  width: 100%;
  max-width: 160px;
  height: auto;
  border-radius: 10px;
  object-fit: contain;
}

.label {
  font-weight: 600;
  margin-top: 0.8rem;
  font-size: 1rem;
  color: #222;
}
</style>
