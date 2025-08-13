<template>
  <WebLayout>
    <!-- HERO -->
    <section id="inicio" class="fondo-principal">
      <div>
        <h1 class="fondo-principal-h1">Globaltech Innovaciones</h1>
        <h2 class="fondo-principal-h2">Transformando ideas en tecnología</h2>
        <div class="mt-6">
          <Link :href="route('login')">
            <a-button type="primary" size="large">Iniciar sesión</a-button>
          </Link>
        </div>
      </div>
    </section>

    <!-- SERVICIOS -->
    <section id="servicios" class="section">
      <h2 class="section-title">Nuestros Servicios</h2>
      <div class="services-grid">
        <div class="service-card">🔧 Desarrollo de software</div>
        <div class="service-card">📱 Aplicaciones móviles</div>
        <div class="service-card">🌐 Diseño web profesional</div>
        <div class="service-card">☁️ Infraestructura cloud</div>
      </div>
    </section>

    <!-- NOSOTROS -->
    <section id="nosotros" class="section gray-bg">
      <h2 class="section-title">¿Quiénes Somos?</h2>
      <p class="section-text">
        Globaltech Innovaciones es una empresa dedicada a brindar soluciones tecnológicas
        innovadoras para empresas y organizaciones. Contamos con un equipo multidisciplinario
        especializado en desarrollo, diseño, infraestructura y consultoría.
      </p>
    </section>

    <div class="flex bg-white-100 justify-center items-center w-full">
         <Tecnologias />
    </div>

    <div class="flex bg-gray-100 justify-center items-center w-full">
        <ERPFeatures />
    </div>

    <div class="flex bg-gray-100 justify-center items-center w-full">
        <GestionComercial />
    </div>

    <div class="flex bg-white justify-center items-center w-full">
        <Finanzas />
    </div>

    <div class="flex bg-white justify-center items-center w-full">
        <AplicativosMoviles />
    </div>



  </WebLayout>
</template>

<script setup>
import WebLayout from '@/Layouts/WebLayout.vue';
import Tecnologias from './components/Tecnologias.vue';
import ERPFeatures from './components/ERPFeatures.vue';
import GestionComercial from './components/GestionComercial.vue';
import Finanzas from './components/Finanzas.vue';
import AplicativosMoviles from './components/AplicativosMoviles.vue'



import { Link } from '@inertiajs/vue3';
</script>

<style scoped>
.fondo-principal {
  height: 100vh;
  background: url('/ERPDigital.png') no-repeat center center;
  background-size: cover;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  text-align: center;
  position: relative;
  padding: 2rem;
}

.fondo-principal::before {
  content: '';
  background: rgba(0, 0, 0, 0.4);
  position: absolute;
  inset: 0;
  z-index: 0;
}

.fondo-principal * {
  z-index: 1;
  position: relative;
}

.fondo-principal-h1 {
  font-size: 3.5rem;
  font-weight: 700;
}

.fondo-principal-h2 {
  font-size: 1.8rem;
  font-weight: 400;
}

.section {
  padding: 4rem 2rem;
  text-align: center;
}

.section-title {
  font-size: 2rem;
  margin-bottom: 2rem;
  color: #333;
}

.section-text {
  max-width: 800px;
  margin: 0 auto;
  color: #555;
  line-height: 1.7;
}

.gray-bg {
  background-color: #f9f9f9;
}

.services-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1.5rem;
  max-width: 1000px;
  margin: 0 auto;
}

.service-card {
  background: #ffffff;
  border-radius: 8px;
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
  padding: 2rem;
  font-size: 1.1rem;
  font-weight: 500;
}





.fondo-principal-h1 {
  font-size: 3.5rem;
  margin-bottom: 10px;
}

.fondo-principal-h2 {
  font-size: 1.8rem;
  font-weight: 400;
}

@media (max-width: 768px) {
  .fondo-principal-h1 {
    font-size: 2rem;
  }

  .fondo-principal-h2 {
    font-size: 1.2rem;
  }
}

.services-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 1.5rem;
  padding: 1rem;
}

.section {
  padding: 3rem 1rem;
}

</style>
