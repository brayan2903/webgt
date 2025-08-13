<template>
  <WebLayout>
    <Head title="ERP PRISMA | Módulo de Producción — Planifica, fabrica y controla" />

    <!-- HERO: estilo oscuro y directo -->
    <section class="hero-dark">
      <a-row :gutter="[24,24]" align="middle">
        <a-col :xs="24" :lg="14">
          <h1 class="hero-title">Producción PRISMA</h1>
          <p class="hero-subtitle">
            Planificación MRP, control de piso, calidad y costos en una sola vista.
            Del plano al despacho con trazabilidad por <strong>lote/serie</strong>.
          </p>
          <div class="hero-badges">
            <a-tag color="blue">MRP</a-tag>
            <a-tag color="green">Capacidad finita</a-tag>
            <a-tag color="gold">OEE & Scrap</a-tag>
            <a-tag color="purple">Rutas & Centros</a-tag>
          </div>
          <div class="hero-cta">
            <a-button type="primary" size="large" @click="contactar">Solicitar demo</a-button>
            <a-button size="large" ghost @click="descargarBrochure">Brochure (PDF)</a-button>
          </div>
        </a-col>
        <a-col :xs="24" :lg="10">
          <a-card class="hero-card" :hoverable="true" :bodyStyle="{padding:0}">
            <img src="/logo.png" class="hero-image" alt="Panel de Producción PRISMA" />
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- RESUMEN EN TABS: enfoque por rol -->
    <section class="tabs-overview">
      <a-tabs default-active-key="planner" size="large" centered>
        <a-tab-pane key="planner" tab="Planner (MRP)">
          <a-row :gutter="[16,16]">
            <a-col :xs="24" :md="8">
              <a-card :hoverable="true" title="MRP & S&OP">
                <p>Explota listas de materiales (BOM) y demanda para generar OF y requerimientos.</p>
                <ul class="ul-simple">
                  <li>Sugerencias por stock/lead time</li>
                  <li>Sincronizado con Ventas y Compras</li>
                  <li>Multi-nivel y alternativos</li>
                </ul>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="8">
              <a-card :hoverable="true" title="Capacidad">
                <p>Plan maestro con <strong>capacidad finita</strong> por centro de trabajo.</p>
                <ul class="ul-simple">
                  <li>Carga/ocupación en tiempo real</li>
                  <li>Secuenciación por reglas (FIFO, prioridad, setup)</li>
                  <li>Calendarios y turnos</li>
                </ul>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="8">
              <a-card :hoverable="true" title="Costos">
                <p>Costeo estándar y por orden, con absorción de MO, CIF y mermas.</p>
                <ul class="ul-simple">
                  <li>Variaciones estándar vs real</li>
                  <li>Valorización por lote/serie</li>
                  <li>WIP & cierre de OF</li>
                </ul>
              </a-card>
            </a-col>
          </a-row>
        </a-tab-pane>

        <a-tab-pane key="shopfloor" tab="Piso (Shopfloor)">
          <a-row :gutter="[16,16]">
            <a-col :xs="24" :md="12">
              <a-card :hoverable="true" title="Ejecución de OF">
                <ul class="ul-simple">
                  <li>Rutas y operaciones con tiempos estándar</li>
                  <li>Registro de paradas y causas</li>
                  <li>Consumo de materiales por escaneo (QR/Código de barras)</li>
                  <li>Declaración de producción y retrabajos</li>
                </ul>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="12">
              <a-card :hoverable="true" title="Calidad">
                <ul class="ul-simple">
                  <li>Planes de inspección por operación</li>
                  <li>Reglas de aceptación, AQL y rechazo</li>
                  <li>NC, CAPA y trazabilidad hasta proveedor</li>
                </ul>
              </a-card>
            </a-col>
          </a-row>
        </a-tab-pane>

        <a-tab-pane key="maintenance" tab="Mantenimiento (TPM)">
          <a-row :gutter="[16,16]">
            <a-col :xs="24" :md="8">
              <a-card :hoverable="true" title="Preventivo">
                <p>Planes por horas, ciclos o calendario.</p>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="8">
              <a-card :hoverable="true" title="Correctivo">
                <p>Órdenes con repuestos, mano de obra y tiempos fuera de línea.</p>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="8">
              <a-card :hoverable="true" title="Indicadores">
                <p>MTBF/MTTR y disponibilidad por equipo y centro.</p>
              </a-card>
            </a-col>
          </a-row>
        </a-tab-pane>
      </a-tabs>
    </section>

    <!-- WORKCENTERS GRID -->
    <section class="workcenters">
      <h2 class="section-title">Centros de trabajo & Rutas</h2>
      <a-row :gutter="[16,16]">
        <a-col v-for="c in workcenters" :key="c.name" :xs="24" :md="8">
          <a-card :hoverable="true">
            <template #title>
              <div class="wc-title">
                <img :src="c.icon" alt="ico" />
                <span>{{ c.name }}</span>
              </div>
            </template>
            <p class="wc-desc">{{ c.desc }}</p>
            <a-progress :percent="c.load" status="active" />
            <div class="wc-meta">
              <span>Utilización</span>
              <strong>{{ c.load }}%</strong>
            </div>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- TIMELINE: del pedido a la OF y despacho -->
    <section class="timeline">
      <h2 class="section-title">Del pedido al despacho</h2>
      <a-timeline mode="left">
        <a-timeline-item color="blue">
          Venta confirmada → <strong>Demanda</strong>
          <div class="tl-sub">Integra con Ventas/Distribución</div>
        </a-timeline-item>
        <a-timeline-item color="green">
          MRP genera <strong>Órdenes de Fabricación</strong>
          <div class="tl-sub">Explosión BOM + capacidad</div>
        </a-timeline-item>
        <a-timeline-item color="purple">
          Ejecución en piso y <strong>Calidad</strong>
          <div class="tl-sub">Consumos, paradas, scrap, inspecciones</div>
        </a-timeline-item>
        <a-timeline-item color="gold">
          Cierre de OF y <strong>Costeo</strong>
          <div class="tl-sub">WIP → Producto terminado</div>
        </a-timeline-item>
        <a-timeline-item color="red">
          <strong>Despacho</strong> a cliente o a almacén PT
          <div class="tl-sub">Trazabilidad lote/serie</div>
        </a-timeline-item>
      </a-timeline>
    </section>

    <!-- KPIs: distintos a otros módulos -->
    <section class="kpis">
      <a-row :gutter="[24,24]" justify="center">
        <a-col :xs="12" :md="6" class="kpi">
          <a-statistic title="OEE promedio" :value="85" suffix="%" />
        </a-col>
        <a-col :xs="12" :md="6" class="kpi">
          <a-statistic title="Cumplimiento plan" :value="96" suffix="%" />
        </a-col>
        <a-col :xs="12" :md="6" class="kpi">
          <a-statistic title="Lead time" :value="30" suffix="% menos" />
        </a-col>
        <a-col :xs="12" :md="6" class="kpi">
          <a-statistic title="Scrap" :value="1.5" suffix="%" />
        </a-col>
      </a-row>
      <div class="badges">
        <a-tag color="success">BOM multinivel</a-tag>
        <a-tag color="processing">Shopfloor móvil</a-tag>
        <a-tag color="blue">Series/Lotes</a-tag>
        <a-tag color="purple">API IoT</a-tag>
      </div>
    </section>

    <!-- FAQ compacta -->
    <section class="faq">
      <h2 class="section-title">Preguntas frecuentes</h2>
      <a-collapse accordion>
        <a-collapse-panel key="1" header="¿Soporta producción por procesos y por órdenes?">
          Sí, puedes trabajar make-to-stock, make-to-order y procesos continuos con consumos teóricos/real.
        </a-collapse-panel>
        <a-collapse-panel key="2" header="¿Cómo gestionan lotes, series y vencimientos?">
          Trazabilidad completa desde proveedor → producción → cliente, con bloqueos por control de calidad.
        </a-collapse-panel>
        <a-collapse-panel key="3" header="¿Se integra con Compras y Almacén?">
          MRP genera requerimientos; consumos impactan inventario y el cierre alimenta costos/contabilidad.
        </a-collapse-panel>
        <a-collapse-panel key="4" header="¿Puedo registrar piso desde móvil?">
          Sí, app de operario: escaneo, tiempos, paradas y calidad offline/online.
        </a-collapse-panel>
      </a-collapse>
    </section>

    <!-- CTA FINAL diferente -->
    <section class="cta-slim">
      <a-card :hoverable="true" class="cta-card">
        <a-row :gutter="[16,16]" align="middle">
          <a-col :xs="24" :md="18">
            <h3>Planifica con precisión. Produce sin sorpresas.</h3>
            <p>Te mostramos cómo PRISMA conecta MRP, piso, calidad y costos en minutos.</p>
          </a-col>
          <a-col :xs="24" :md="6" class="cta-actions">
            <a-button type="primary" size="large" block @click="contactar">Agendar demo</a-button>
            <a-button size="large" block @click="hablarVentas">Hablar con ventas</a-button>
          </a-col>
        </a-row>
      </a-card>
    </section>
  </WebLayout>
</template>

<script setup>
import WebLayout from '@/Layouts/WebLayout.vue'
import { Head } from '@inertiajs/vue3'
import { reactive } from 'vue'

const workcenters = reactive([
  { name: 'Corte & Preparación', desc: 'Setup alto, secuenciar por material.', load: 72, icon: '/logo.png' },
  { name: 'Ensamble', desc: 'Operaciones en paralelo, balanceo de línea.', load: 64, icon: '/logo.png' },
  { name: 'Acabados', desc: 'Cuellos de botella por curado/horno.', load: 88, icon: '/logo.png' },
])

const contactar = () => {
  window.location.href = '/contacto?modulo=produccion'
}
const hablarVentas = () => {
  window.location.href = 'tel:+51010000000' // reemplazar
}
const descargarBrochure = () => {
  window.location.href = '/brochure-produccion.pdf' // reemplazar
}
</script>

<style scoped>
:root{
  --primary:#00a0c8;
  --dark:#0f1720;
  --dark-soft:#14202b;
  --light:#e6f7fb;
  --text:#1f2d3d;
  --muted:#5c6773;
}

/* HERO oscuro */
.hero-dark{
  background: linear-gradient(180deg, var(--dark), var(--dark-soft));
  color:#fff;
  padding:64px 16px;
}
.hero-title{
  font-size:40px; font-weight:800; margin:0 0 8px; color:#fff;
}
.hero-subtitle{
  font-size:18px; opacity:.9; margin-bottom:12px;
}
.hero-badges{ display:flex; gap:8px; flex-wrap:wrap; margin-bottom:12px; }
.hero-cta{ display:flex; gap:12px; flex-wrap:wrap; }

/* Tabs */
.tabs-overview{ padding:48px 16px; background:#fff; }
.ul-simple{ padding-left:16px; margin:0; }
.ul-simple li{ margin:6px 0; }

/* Workcenters */
.workcenters{ padding:48px 16px; background: #f7fbfd; }
.section-title{ text-align:center; font-size:28px; margin-bottom:16px; color:var(--text); }
.wc-title{ display:flex; align-items:center; gap:8px; }
.wc-title img{ width:24px; height:24px; object-fit:contain; }
.wc-desc{ color:var(--muted); margin-bottom:8px; }
.wc-meta{ display:flex; justify-content:space-between; color:var(--muted); margin-top:8px; }

/* Timeline */
.timeline{ padding:32px 16px; background:#fff; }
.tl-sub{ color:var(--muted); font-size:13px; }

/* KPIs */
.kpis{ background:#fff; text-align:center; padding:24px 16px; }
.kpi :deep(.ant-statistic-title){ color:var(--muted); }
.kpi :deep(.ant-statistic-content){ color:var(--text); font-weight:700; font-size:26px; }
.badges{ margin-top:8px; display:flex; justify-content:center; gap:8px; flex-wrap:wrap; }

/* FAQ */
.faq{ background:#f7fbfd; padding:40px 16px; }

/* CTA slim */
.cta-slim{ background: linear-gradient(180deg, #ffffff, #f7fbfd); padding:40px 16px; }
.cta-card h3{ margin:0 0 6px; font-size:22px; color:var(--text); }
.cta-card p{ margin:0; color:var(--muted); }
.cta-actions{ display:flex; flex-direction:column; gap:8px; }

/* Hero image */
.hero-card{ border:none; }
.hero-image{ width:100%; height:auto; display:block; }

/* Responsive */
@media (max-width: 768px){
  .hero-title{ font-size:32px; }
  .hero-subtitle{ font-size:16px; }
}
</style>
