<template>
  <WebLayout>
    <section class="facturacion-section">
      <h1 class="facturacion-title">Facturación Electrónica</h1>
      <p class="facturacion-text">
        Globaltech ofrece soluciones de facturación electrónica integradas con SUNAT, cumpliendo todos los requisitos legales en Perú. Nuestro sistema permite emitir boletas, facturas, notas de crédito y más, con validación automática y almacenamiento seguro.
      </p>

      <ul class="facturacion-list">
        <li>✔️ Integración con SUNAT</li>
        <li>✔️ Emisión desde cualquier dispositivo</li>
        <li>✔️ Firma digital automática</li>
        <li>✔️ Reportes de ventas y auditoría</li>
        <li>✔️ Compatible con ERP Globaltech</li>
      </ul>
    </section>
  </WebLayout>
</template>

<script setup>
import WebLayout from '@/Layouts/WebLayout.vue'
</script>

<style scoped>
.facturacion-section {
  padding: 4rem 2rem;
  max-width: 800px;
  margin: auto;
  text-align: center;
}

.facturacion-title {
  font-size: 2.5rem;
  font-weight: bold;
  margin-bottom: 1.5rem;
  color: #00a0c8;
}

.facturacion-text {
  font-size: 1.2rem;
  margin-bottom: 2rem;
  line-height: 1.8;
  color: #333;
}

.facturacion-list {
  text-align: left;
  margin: 0 auto;
  max-width: 600px;
  font-size: 1.1rem;
  color: #222;
}

.facturacion-list li {
  margin-bottom: 1rem;
}
</style>
