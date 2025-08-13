<template>
  <section id="tecnologias" class="section white-bg">
    <h2 class="section-title">Tecnologías que usamos</h2>
    <div class="tech-grid">
      <div class="tech-card">
        <img src="https://www.php.net/images/logos/new-php-logo.svg" alt="PHP" />
        <p>PHP (Laravel)</p>
      </div>
      <div class="tech-card">
        <img src="https://cdn.worldvectorlogo.com/logos/vue-9.svg" alt="Vue.js" />
        <p>Vue.js 3</p>
      </div>
      <div class="tech-card">
        <img src="https://www.mysql.com/common/logos/logo-mysql-170x115.png" alt="MySQL" />
        <p>MySQL / MariaDB</p>
      </div>
      <div class="tech-card">
        <img src="/logo.png" alt="Facturación Electrónica" />
        <p>Facturación Electrónica (SUNAT)</p>
      </div>
      <div class="tech-card">
        <img src="https://cdn.worldvectorlogo.com/logos/aws-2.svg" alt="AWS" />
        <p>AWS / Cloud Services</p>
      </div>
      <div class="tech-card">
        <img src="/logo.png" alt="ERP" />
        <p>Soluciones ERP</p>
      </div>
    </div>
  </section>
</template>

<script setup>
</script>

<style scoped>
.white-bg {
  background-color: #ffffff;
}

.tech-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 1.5rem;
  max-width: 1000px;
  margin: 0 auto;
  padding: 1rem;
  align-items: center;
  justify-items: center;
}

.tech-card {
  background-color: #f9f9f9;
  border-radius: 8px;
  padding: 1.5rem;
  text-align: center;
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
  transition: transform 0.2s;
  width: 100%;
  max-width: 200px;
}

.tech-card:hover {
  transform: translateY(-5px);
}

.tech-card img {
  height: 60px;
  margin-bottom: 1rem;
  object-fit: contain;
}

.tech-card p {
  font-weight: 600;
  color: #333;
}
</style>
