<template>
  <WebLayout>
    <Head title="ERP PRISMA | Módulo de Compras — Abastecimiento inteligente" />

    <!-- HERO -->
    <section class="hero">
      <a-row :gutter="[24,24]" align="middle">
        <a-col :xs="24" :md="14">
          <a-tag color="blue" class="hero-badge">Módulo de Compras</a-tag>
          <h1 class="hero-title">Abastecimiento inteligente y controlado</h1>
          <p class="hero-subtitle">
            Centraliza solicitudes, cotiza a varios proveedores, autoriza con flujos
            y emite <strong>Órdenes de Compra</strong> integradas a recepción, costos y
            <strong>Facturación Electrónica SUNAT</strong>.
          </p>

          <ul class="hero-bullets">
            <li>🧾 Requerimientos y aprobaciones multinivel</li>
            <li>💬 Comparador de cotizaciones y contratos</li>
            <li>🏷️ Catálogo, listas de precios y acuerdos marco</li>
            <li>🔗 Recepción contra OC y <strong>3-way match</strong> (OC–Guía–Factura)</li>
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
            <span class="trust-text">Integrado con Almacén, Finanzas y Contabilidad</span>
            <div class="trust-logos">
              <img src="/logo.png" alt="Integración 1" />
              <img src="/logo.png" alt="Integración 2" />
              <img src="/logo.png" alt="Integración 3" />
            </div>
          </div>
        </a-col>

        <a-col :xs="24" :md="10">
          <a-card :hoverable="true" class="hero-card" :bodyStyle="{ padding: '0' }">
            <img class="hero-image" src="/logo.png" alt="Panel de Compras PRISMA" />
            <div class="ribbon">OC + Recepción + Cuentas por pagar</div>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- BENEFICIOS -->
    <section class="benefits">
      <h2 class="section-title">Beneficios clave</h2>
      <a-row :gutter="[24,24]">
        <a-col :xs="24" :md="8">
          <a-card class="feature-card" :hoverable="true">
            <template #title>Ahorra y compra mejor</template>
            <p>Subasta inversa, comparador de cotizaciones y histórico por proveedor.</p>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="8">
          <a-card class="feature-card" :hoverable="true">
            <template #title>Control y trazabilidad</template>
            <p>Flujos de aprobación por montos/centros de costo y auditoría completa.</p>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="8">
          <a-card class="feature-card" :hoverable="true">
            <template #title>Integración financiera</template>
            <p>Contabiliza provisiones, maneja detracciones, percepciones e IGV.</p>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- KPIs -->
    <section class="kpis">
      <a-row :gutter="[24,24]" justify="center">
        <a-col :xs="12" :md="6" class="kpi">
          <a-statistic title="Ahorro promedio" :value="12" suffix="%" />
        </a-col>
        <a-col :xs="12" :md="6" class="kpi">
          <a-statistic title="Tiempo ciclo OC" :value="40" suffix="% menos" />
        </a-col>
        <a-col :xs="12" :md="6" class="kpi">
          <a-statistic title="Cumplimiento presupuestal" :value="98" suffix="%" />
        </a-col>
        <a-col :xs="12" :md="6" class="kpi">
          <a-statistic title="Proveedores activos" :value="500" suffix="+" />
        </a-col>
      </a-row>
      <div class="badges">
        <a-tag color="success">SUNAT e-Factura</a-tag>
        <a-tag color="processing">API Proveedores</a-tag>
        <a-tag color="blue">Multi-moneda / TC</a-tag>
      </div>
    </section>

    <!-- FUNCIONALIDADES -->
    <section class="features">
      <h2 class="section-title">Funcionalidades del Módulo de Compras</h2>
      <a-row :gutter="[24,24]">
        <a-col :xs="24" :md="12">
          <a-card class="list-card" :hoverable="true">
            <template #title>Planificación & Presupuestos</template>
            <ul class="feature-list">
              <li>Planeación de abastecimiento por demanda y mínimos de stock.</li>
              <li>Presupuestos por centro de costo y alertas por sobregiro.</li>
              <li>MRP liviano: sugerencias de compra por producción/ventas.</li>
              <li>Catálogo homologado, familias y unidades de medida.</li>
            </ul>
          </a-card>
        </a-col>

        <a-col :xs="24" :md="12">
          <a-card class="list-card" :hoverable="true">
            <template #title>Requerimientos & Aprobaciones</template>
            <ul class="feature-list">
              <li>Solicitudes de compra (RQ) con adjuntos y justificación.</li>
              <li>Workflows por monto, categoría y CC (multinivel).</li>
              <li>Notificaciones por email/APP y reemplazos por ausencia.</li>
              <li>Catálogo interno y carrito de compras corporativo.</li>
            </ul>
          </a-card>
        </a-col>

        <a-col :xs="24" :md="12">
          <a-card class="list-card" :hoverable="true">
            <template #title>Cotizaciones & Contratos</template>
            <ul class="feature-list">
              <li>Solicitud de cotización a múltiples proveedores.</li>
              <li>Comparador por precio, plazo, calidad y servicio.</li>
              <li>Listas de precios, acuerdos marco y vigencias.</li>
              <li>Evaluación y ranking de proveedores (KPI/Score).</li>
            </ul>
          </a-card>
        </a-col>

        <a-col :xs="24" :md="12">
          <a-card class="list-card" :hoverable="true">
            <template #title>Órdenes, Recepción y Facturas</template>
            <ul class="feature-list">
              <li>Generación de OC desde RQ/cotización y plantillas.</li>
              <li>Recepción contra OC/guía con control de calidad.</li>
              <li>3-way match: OC — Guía — Factura; manejo de diferencias.</li>
              <li>Detracciones, percepciones, IGV y retenciones aplicadas.</li>
            </ul>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- FLUJO -->
    <section class="how-it-works">
      <h2 class="section-title">Cómo funciona</h2>
      <a-steps size="small" :current="5" :responsive="true">
        <a-step title="Planifica" description="Demanda, mínimos y presupuesto." />
        <a-step title="Solicita" description="RQ con catálogo y adjuntos." />
        <a-step title="Aprueba" description="Workflow por montos/CC." />
        <a-step title="Cotiza" description="Comparas y eliges proveedor." />
        <a-step title="Ordena" description="OC automática y contratos." />
        <a-step title="Recibe & Contabiliza" description="3-way match y CxP." />
      </a-steps>
    </section>

    <!-- TESTIMONIO -->
    <section class="social-proof">
      <a-card class="testimonial" :hoverable="true">
        <template #title>Compras con impacto</template>
        <div class="testimonial-content">
          <img src="/logo.png" alt="Logo cliente" />
          <blockquote>
            “Reducimos el tiempo del ciclo de OC en un 40% y logramos mejores precios gracias
            al comparador de cotizaciones de PRISMA.”
          </blockquote>
          <span class="author">— Jefe de Compras, Industria Perú</span>
        </div>
      </a-card>
    </section>

    <!-- FAQ -->
    <section class="faq">
      <h2 class="section-title">Preguntas frecuentes</h2>
      <a-collapse accordion>
        <a-collapse-panel key="1" header="¿Puedo definir flujos de aprobación por montos?">
          Sí, puedes crear reglas por importe, categoría, centro de costo, usuario y jerarquías.
        </a-collapse-panel>
        <a-collapse-panel key="2" header="¿Soporta multi-moneda y tipo de cambio?">
          Sí, maneja T/C diario, redondeos y provisiones en ME/ML con ajustes automáticos.
        </a-collapse-panel>
        <a-collapse-panel key="3" header="¿Gestiona detracciones, percepciones e IGV?">
          Totalmente. Calcula, registra y envía la parametrización correspondiente a Finanzas.
        </a-collapse-panel>
        <a-collapse-panel key="4" header="¿Se integra con Almacén y Cuentas por Pagar?">
          Sí, la recepción impacta stock y genera la provisión para CxP y Contabilidad.
        </a-collapse-panel>
      </a-collapse>
    </section>

    <!-- CTA FINAL -->
    <section class="cta-final">
      <a-card class="cta-card" :hoverable="true">
        <h3>Optimiza tus compras hoy</h3>
        <p>Agenda una demo y descubre cómo PRISMA reduce costos y acelera tu ciclo de abastecimiento.</p>
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
  window.location.href = '/contacto?modulo=compras'
}

const hablarVentas = () => {
  window.location.href = 'tel:+51010000000' // reemplazar por número real
}

const descargarBrochure = () => {
  window.location.href = '/brochure-compras.pdf' // subir a storage público
}
</script>

<style scoped>
:root {
  --primary: #00a0c8;
  --text: #1f2d3d;
  --muted: #5c6773;
  --bg-soft: #f7fbfd;
}

section { padding: 64px 16px; }
.section-title {
  text-align: center; font-size: 28px; margin-bottom: 24px; color: var(--text);
}

/* HERO */
.hero { background: linear-gradient(180deg, #ffffff, var(--bg-soft)); }
.hero-badge { margin-bottom: 8px; }
.hero-title {
  font-size: 40px; line-height: 1.1; margin: 8px 0 12px; color: var(--primary); font-weight: 800;
}
.hero-subtitle { font-size: 18px; color: var(--muted); margin-bottom: 16px; }
.hero-bullets { list-style: none; padding: 0; margin: 0 0 16px; }
.hero-bullets li { margin: 6px 0; color: var(--text); }
.hero-cta { display: flex; gap: 12px; flex-wrap: wrap; margin: 12px 0 8px; }
.cta-secondary { border-color: var(--primary); color: var(--primary); }

.hero-card { position: relative; border: none; }
.hero-image { width: 100%; height: auto; display: block; }
.ribbon {
  position: absolute; top: 12px; left: -8px;
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
.feature-card p { margin: 0; }

/* KPIs */
.kpis { background: var(--bg-soft); text-align: center; }
.kpi :deep(.ant-statistic-title) { color: var(--muted); }
.kpi :deep(.ant-statistic-content) { color: var(--text); font-weight: 700; font-size: 26px; }
.badges { margin-top: 12px; display: flex; justify-content: center; gap: 8px; flex-wrap: wrap; }

/* Features */
.features .list-card .feature-list { padding-left: 18px; margin: 0; }
.features .list-card .feature-list li { margin: 6px 0; }

/* How it works */
.how-it-works { background: #fff; }

/* Social proof */
.social-proof { background: var(--bg-soft); }
.testimonial blockquote { margin: 0; font-style: italic; color: var(--text); }
.testimonial-content {
  display: grid; grid-template-columns: 72px 1fr; gap: 16px; align-items: center;
}
.testimonial-content img { width: 72px; height: 72px; object-fit: contain; border-radius: 8px; }
.author { display: block; margin-top: 6px; color: var(--muted); }

/* CTA final */
.cta-final { background: linear-gradient(180deg, var(--bg-soft), #ffffff); }
.cta-card { text-align: center; border: 1px solid #eaf4f8; }
.cta-card h3 { font-size: 24px; margin-bottom: 8px; color: var(--text); }
.cta-card p { color: var(--muted); margin-bottom: 16px; }
.cta-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

/* Responsive */
@media (max-width: 768px) {
  .hero-title { font-size: 32px; }
  .hero-subtitle { font-size: 16px; }
}
</style>
