<template>
  <WebLayout>
    <section class="modulos-section">
      <h1 class="modulos-title">Módulos ERP de Globaltech</h1>
      <p class="modulos-text">
        Nuestra plataforma ERP está compuesta por módulos especializados que se adaptan a tu negocio. Automatiza procesos, centraliza información y toma decisiones inteligentes.
      </p>

      <div class="modulos-grid">
        <div class="modulo-card" v-for="modulo in modulos" :key="modulo.nombre">
          <img :src="modulo.img" :alt="modulo.nombre" />
          <h3>{{ modulo.nombre }}</h3>
          <p>{{ modulo.descripcion }}</p>
        </div>
      </div>
    </section>
  </WebLayout>
</template>

<script setup>
import WebLayout from '@/Layouts/WebLayout.vue'

const modulos = [
  {
    nombre: 'Ventas',
    descripcion: 'Gestión de cotizaciones, órdenes y facturas.',
    img: '/logo.png',
  },
  {
    nombre: 'Compras',
    descripcion: 'Registra y controla tus órdenes de compra y proveedores.',
    img: '/logo.png',
  },
  {
    nombre: 'Almacén',
    descripcion: 'Control de inventario en tiempo real.',
    img: '/logo.png',
  },
  {
    nombre: 'Contabilidad',
    descripcion: 'Automatización contable y reportes financieros.',
    img: '/logo.png',
  },
]
</script>

<style scoped>
.modulos-section {
  padding: 4rem 2rem;
  max-width: 1200px;
  margin: auto;
  text-align: center;
}

.modulos-title {
  font-size: 2.5rem;
  font-weight: bold;
  margin-bottom: 1.5rem;
  color: #00a0c8;
}

.modulos-text {
  font-size: 1.2rem;
  margin-bottom: 2.5rem;
  line-height: 1.8;
  color: #444;
}

.modulos-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 2rem;
  justify-content: center;
  align-items: start;
}

.modulo-card {
  background: #f9f9f9;
  padding: 2rem;
  border-radius: 8px;
  text-align: center;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.modulo-card img {
  height: 80px;
  margin-bottom: 1rem;
  object-fit: contain;
}

.modulo-card h3 {
  font-size: 1.4rem;
  color: #222;
  margin-bottom: 0.5rem;
}

.modulo-card p {
  font-size: 1rem;
  color: #555;
}
</style>
