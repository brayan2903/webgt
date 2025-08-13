<template>
  <WebLayout>
    <Head title="ERP PRISMA | Módulo de Almacén — Inventarios en tiempo real" />

    <!-- HERO / VALUE PROP -->
    <section class="hero">
      <a-row :gutter="[24,24]" align="middle">
        <a-col :xs="24" :md="14">
          <a-tag color="blue" class="hero-badge">Nuevo 2025</a-tag>
          <h1 class="hero-title">Módulo de Almacén PRISMA</h1>
          <p class="hero-subtitle">
            Controla tus inventarios en <strong>tiempo real</strong>, reduce quiebres y acelera tu
            operación con trazabilidad, multi-almacén e integración nativa con
            <strong>Facturación Electrónica SUNAT</strong>.
          </p>

          <ul class="hero-bullets">
            <li>🧭 Trazabilidad por series, lotes y fechas de vencimiento</li>
            <li>📦 Multi-almacén, ubicaciones y transferencias</li>
            <li>⚡️ Inventarios cíclicos y ajustes con auditoría</li>
            <li>📈 Valorización (PEPS, UEPS, Promedio) y reportes listos</li>
          </ul>

          <div class="hero-cta">
            <a-button type="primary" size="large" @click="contactar">
              Solicitar demostración
            </a-button>
            <a-button size="large" @click="descargarBrochure" class="cta-secondary">
              Descargar brochure (PDF)
            </a-button>
          </div>

          <div class="hero-trust">
            <span class="trust-text">Confiado por empresas en todo el Perú</span>
            <div class="trust-logos">
              <img src="/logo.png" alt="Cliente 1" />
              <img src="/logo.png" alt="Cliente 2" />
              <img src="/logo.png" alt="Cliente 3" />
              <img src="/logo.png" alt="Cliente 4" />
            </div>
          </div>
        </a-col>

        <a-col :xs="24" :md="10">
          <a-card :hoverable="true" class="hero-card" :bodyStyle="{ padding: '0' }">
            <img class="hero-image" src="/logo.png" alt="Dashboard de almacén PRISMA" />
            <div class="ribbon">Inventario en vivo</div>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- BENEFICIOS CLAVE (VENTAS) -->
    <section class="benefits">
      <h2 class="section-title">¿Por qué elegir PRISMA para tu almacén?</h2>
      <a-row :gutter="[24,24]">
        <a-col :xs="24" :md="8">
          <a-card class="feature-card" :hoverable="true">
            <template #title>Menos quiebres, más ventas</template>
            <p>Alertas inteligentes de stock mínimo y reposición automática según demanda.</p>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="8">
          <a-card class="feature-card" :hoverable="true">
            <template #title>Costos bajo control</template>
            <p>Valorización precisa y rotación por SKU para comprar mejor y reducir mermas.</p>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="8">
          <a-card class="feature-card" :hoverable="true">
            <template #title>Integración con ventas y compras</template>
            <p>Sincroniza entradas/salidas con facturación y órdenes para cero doble digitación.</p>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- KPIs / PRUEBA SOCIAL -->
    <section class="kpis">
      <a-row :gutter="[24,24]" justify="center">
        <a-col :xs="12" :md="6" class="kpi">
          <a-statistic title="Reducción de quiebres" :value="35" suffix="%" />
        </a-col>
        <a-col :xs="12" :md="6" class="kpi">
          <a-statistic title="Precisión de inventario" :value="99.5" suffix="%" />
        </a-col>
        <a-col :xs="12" :md="6" class="kpi">
          <a-statistic title="Tiempo de toma física" :value="50" suffix="% menos" />
        </a-col>
        <a-col :xs="12" :md="6" class="kpi">
          <a-statistic title="Almacenes soportados" :value="999" suffix="+" />
        </a-col>
      </a-row>
      <div class="badges">
        <a-tag color="success">Cumplimiento SUNAT</a-tag>
        <a-tag color="processing">Integración eCommerce</a-tag>
        <a-tag color="blue">API REST</a-tag>
      </div>
    </section>

    <!-- FUNCIONALIDADES DETALLADAS -->
    <section class="features">
      <h2 class="section-title">Funcionalidades del Módulo de Almacén</h2>
      <a-row :gutter="[24,24]">
        <a-col :xs="24" :md="12">
          <a-card class="list-card" :hoverable="true">
            <template #title>Control de inventario</template>
            <ul class="feature-list">
              <li>Gestión de stock en tiempo real por SKU y ubicación</li>
              <li>Series, lotes y vencimientos con trazabilidad completa</li>
              <li>Inventarios cíclicos, conteos rápidos y auditoría</li>
              <li>Alertas de stock mínimo y abastecimiento sugerido</li>
            </ul>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="12">
          <a-card class="list-card" :hoverable="true">
            <template #title>Movimientos y operaciones</template>
            <ul class="feature-list">
              <li>Ingresos, salidas, transferencias y ajustes controlados</li>
              <li>Recepción contra OC y despachos contra ventas</li>
              <li>Soporte de códigos de barras y QR</li>
              <li>Bloqueo de stock por reservas / pedidos</li>
            </ul>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="12">
          <a-card class="list-card" :hoverable="true">
            <template #title>Reportes y valorización</template>
            <ul class="feature-list">
              <li>Valorización PEPS, UEPS, Promedio Ponderado</li>
              <li>Rotación, cobertura y ABC por categoría</li>
              <li>Stock por ubicación y por estado (disponible, reservado, dañado)</li>
              <li>Histórico de movimientos y Kardex</li>
            </ul>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="12">
          <a-card class="list-card" :hoverable="true">
            <template #title>Integraciones PRISMA</template>
            <ul class="feature-list">
              <li>Ventas y Facturación Electrónica (boletas/facturas SUNAT)</li>
              <li>Compras, OC y recepción con control de calidad</li>
              <li>eCommerce, POS y marketplaces</li>
              <li>API para WMS/transportes externos</li>
            </ul>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- CÓMO FUNCIONA (FLUJO) -->
    <section class="how-it-works">
      <h2 class="section-title">Cómo funciona</h2>
      <a-steps size="small" :current="4" :responsive="true">
        <a-step title="Configura" description="Almacenes, ubicaciones y políticas de stock." />
        <a-step title="Recibe" description="Ingreso contra compras / guías." />
        <a-step title="Controla" description="Series, lotes, conteos y reservas." />
        <a-step title="Despacha" description="Picking, packing y salida a venta." />
        <a-step title="Analiza" description="Reportes y KPIs para decidir." />
      </a-steps>
    </section>

    <!-- TESTIMONIO / LOGOS (PLACEHOLDER) -->
    <section class="social-proof">
      <a-card class="testimonial" :hoverable="true">
        <template #title>Lo que dicen nuestros clientes</template>
        <div class="testimonial-content">
          <img src="/logo.png" alt="Logo cliente" />
          <blockquote>
            “Con PRISMA reducimos quiebres y mejoramos la precisión de inventario.
            La integración con facturación nos ahorra horas cada semana.”
          </blockquote>
          <span class="author">— Operaciones, Retail Perú</span>
        </div>
      </a-card>
    </section>

    <!-- FAQ -->
    <section class="faq">
      <h2 class="section-title">Preguntas frecuentes</h2>
      <a-collapse accordion>
        <a-collapse-panel key="1" header="¿Puedo manejar varios almacenes y ubicaciones?">
          Sí, PRISMA soporta multi-almacén, zonas, pasillos y ubicaciones específicas.
        </a-collapse-panel>
        <a-collapse-panel key="2" header="¿Calcula valorización PEPS/UEPS/Promedio?">
          Sí, puedes elegir el método por ítem o por catálogo y obtener Kardex automático.
        </a-collapse-panel>
        <a-collapse-panel key="3" header="¿Se integra con Facturación Electrónica?">
          Totalmente. Los despachos y notas de salida impactan stock y documentos SUNAT.
        </a-collapse-panel>
        <a-collapse-panel key="4" header="¿Hay API para conectarme con WMS/transportes?">
          Sí, contamos con API REST y webhooks para integraciones externas.
        </a-collapse-panel>
      </a-collapse>
    </section>

    <!-- CTA FINAL -->
    <section class="cta-final">
      <a-card class="cta-card" :hoverable="true">
        <h3>¿Listo para optimizar tu almacén?</h3>
        <p>Solicita una demo personalizada y descubre cómo PRISMA se adapta a tu operación.</p>
        <div class="cta-actions">
          <a-button type="primary" size="large" @click="contactar">Agendar demo</a-button>
          <a-button size="large" ghost @click="hablarVentas">Hablar con ventas</a-button>
        </div>
      </a-card>
    </section>
  </WebLayout>
</template>

<script setup>
import WebLayout from '@/Layouts/WebLayout.vue'
import { Head } from '@inertiajs/vue3'

const contactar = () => {
  window.location.href = '/contacto?modulo=almacen'
}

const hablarVentas = () => {
  window.location.href = 'tel:+51010000000' // placeholder; cámbialo por tu número
}

const descargarBrochure = () => {
  window.location.href = '/brochure-almacen.pdf' // placeholder; súbelo a tu storage público
}
</script>

<style scoped>
/* Paleta */
:root {
  --primary: #00a0c8;
  --text: #1f2d3d;
  --muted: #5c6773;
  --bg-soft: #f7fbfd;
}

/* Layouts de sección */
section { padding: 64px 16px; }
.section-title {
  text-align: center;
  font-size: 28px;
  margin-bottom: 24px;
  color: var(--text);
}

/* HERO */
.hero { background: linear-gradient(180deg, #ffffff, var(--bg-soft)); }
.hero-badge { margin-bottom: 8px; }
.hero-title {
  font-size: 40px;
  line-height: 1.1;
  margin: 8px 0 12px;
  color: var(--primary);
  font-weight: 800;
}
.hero-subtitle {
  font-size: 18px;
  color: var(--muted);
  margin-bottom: 16px;
}
.hero-bullets { list-style: none; padding: 0; margin: 0 0 16px; }
.hero-bullets li { margin: 6px 0; color: var(--text); }
.hero-cta { display: flex; gap: 12px; flex-wrap: wrap; margin: 12px 0 8px; }
.cta-secondary { border-color: var(--primary); color: var(--primary); }

.hero-card { position: relative; border: none; }
.hero-image { width: 100%; height: auto; display: block; }
.ribbon {
  position: absolute;
  top: 12px; left: -8px;
  background: var(--primary); color: #fff; padding: 6px 12px;
  font-size: 12px; font-weight: 700; border-radius: 4px;
}

.hero-trust { margin-top: 12px; }
.trust-text { display: block; color: var(--muted); margin-bottom: 10px; }
.trust-logos { display: flex; gap: 16px; align-items: center; flex-wrap: wrap; }
.trust-logos img {
  width: 72px; height: 32px; object-fit: contain; filter: grayscale(1); opacity: .8;
}

/* Benefits */
.benefits { background: #fff; }

/* KPIs */
.kpis { background: var(--bg-soft); text-align: center; }
.kpi :deep(.ant-statistic-title) { color: var(--muted); }
.kpi :deep(.ant-statistic-content) { color: var(--text); font-weight: 700; font-size: 26px; }
.badges { margin-top: 12px; display: flex; justify-content: center; gap: 8px; flex-wrap: wrap; }

/* Feature lists */
.features .list-card .feature-list { padding-left: 18px; margin: 0; }
.features .list-card .feature-list li { margin: 6px 0; }

/* How it works */
.how-it-works { background: #fff; }

/* Social proof */
.social-proof { background: var(--bg-soft); }
.testimonial blockquote {
  margin: 0; font-style: italic; color: var(--text);
}
.testimonial-content {
  display: grid; grid-template-columns: 72px 1fr; gap: 16px; align-items: center;
}
.testimonial-content img { width: 72px; height: 72px; object-fit: contain; border-radius: 8px; }
.author { display: block; margin-top: 6px; color: var(--muted); }

/* FAQ */
.faq { background: #fff; }

/* CTA final */
.cta-final { background: linear-gradient(180deg, var(--bg-soft), #ffffff); }
.cta-card { text-align: center; border: 1px solid #eaf4f8; }
.cta-card h3 { font-size: 24px; margin-bottom: 8px; color: var(--text); }
.cta-card p { color: var(--muted); margin-bottom: 16px; }
.cta-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

/* Responsivo */
@media (max-width: 768px) {
  .hero-title { font-size: 32px; }
  .hero-subtitle { font-size: 16px; }
}
</style>
