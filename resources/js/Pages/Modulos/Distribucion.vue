<template>
  <WebLayout>
    <Head title="ERP PRISMA | Módulo de Distribución — Ruteo, entregas y POD" />

    <!-- HERO compacto con selector de operación -->
    <section class="hero-dist">
      <a-row :gutter="[24,24]" align="middle">
        <a-col :xs="24" :lg="14">
          <h1 class="hero-title">Distribución PRISMA</h1>
          <p class="hero-subtitle">
            Planifica rutas, controla entregas y confirma POD (firma/foto/GPS)
            integrado con Ventas, Almacén y Facturación Electrónica SUNAT.
          </p>
          <div class="hero-controls">
            <a-segmented
              :options="['Last-mile','Mayorista B2B','Transferencias']"
              v-model:value="mode"
              size="large"
            />
            <a-space>
              <a-button type="primary" size="large" @click="contactar">Solicitar demo</a-button>
              <a-button size="large" ghost @click="abrirSimulador">Simular ruta</a-button>
            </a-space>
          </div>
          <ul class="mode-bullets">
            <li v-if="mode==='Last-mile'">Ventanas horarias, proof of delivery y reintentos.</li>
            <li v-if="mode==='Last-mile'">Tracking para cliente y notificaciones.</li>

            <li v-if="mode==='Mayorista B2B'">Cross-docking, multistop y secuenciación por prioridad.</li>
            <li v-if="mode==='Mayorista B2B'">Control de pallets, guías y documentos.</li>

            <li v-if="mode==='Transferencias'">Rutas inter-almacén y control de mermas.</li>
            <li v-if="mode==='Transferencias'">Trazabilidad por lote/serie entre sedes.</li>
          </ul>
        </a-col>

        <a-col :xs="24" :lg="10">
          <a-card :hoverable="true" class="hero-card" :bodyStyle="{padding:0}">
            <img src="/logo.png" class="hero-image" alt="Mapa y rutas PRISMA" />
            <div class="ribbon">Rutas optimizadas</div>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- KPIs / SLA -->
    <section class="kpis">
      <a-row :gutter="[16,16]" justify="center">
        <a-col :xs="12" :md="6" class="kpi"><a-statistic title="On-time delivery" :value="97" suffix="%" /></a-col>
        <a-col :xs="12" :md="6" class="kpi"><a-statistic title="Costo por entrega" prefix="S/ " :value="8.5" /></a-col>
        <a-col :xs="12" :md="6" class="kpi"><a-statistic title="Drop size prom." :value="14" suffix="ítems" /></a-col>
        <a-col :xs="12" :md="6" class="kpi"><a-statistic title="Devoluciones" :value="1.2" suffix="%" /></a-col>
      </a-row>
      <div class="badges">
        <a-tag color="blue">POD firma/foto</a-tag>
        <a-tag color="green">Ventanas horarias</a-tag>
        <a-tag color="purple">Optimización VRP</a-tag>
        <a-tag color="gold">Portal de tracking</a-tag>
      </div>
    </section>

    <!-- Tabs -->
    <section class="ops-tabs">
      <a-tabs default-active-key="plan" size="large">
        <a-tab-pane key="plan" tab="Planificación & Ruteo">
          <a-row :gutter="[16,16]">
            <a-col :xs="24" :md="12">
              <a-card :hoverable="true" title="Optimización de rutas (VRP)">
                <ul class="ul">
                  <li>Capacidades por vehículo (volumen/peso/ítems).</li>
                  <li>Ventanas horarias y prioridades por cliente.</li>
                  <li>Secuenciación por zona, tráfico y SLAs.</li>
                  <li>Costos por km/hora/peajes y restricciones.</li>
                </ul>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="12">
              <a-card :hoverable="true" title="Despacho & Cross-dock">
                <ul class="ul">
                  <li>Wave picking y staging por ruta.</li>
                  <li>Consolidación por guía/cliente y multistop.</li>
                  <li>Control de bultos, pallets y verificación por escaneo.</li>
                  <li>Documentos: guía de remisión, CDP y etiquetas.</li>
                </ul>
              </a-card>
            </a-col>
          </a-row>
        </a-tab-pane>

        <a-tab-pane key="execute" tab="Ejecución & Entregas">
          <a-row :gutter="[16,16]">
            <a-col :xs="24" :md="12">
              <a-card :hoverable="true" title="App de Reparto (POD)">
                <ul class="ul">
                  <li>Firma, foto, geolocalización y notas.</li>
                  <li>Reintentos, causales de no entrega y devoluciones.</li>
                  <li>Navegación y secuencia sugerida.</li>
                  <li>Modo offline / sincronización posterior.</li>
                </ul>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="12">
              <a-card :hoverable="true" title="Tracking & Atención">
                <ul class="ul">
                  <li>Portal de seguimiento con ETA y estados.</li>
                  <li>Notificaciones (email/SMS/WhatsApp).</li>
                  <li>Dashboard NPS y tiempos de respuesta.</li>
                  <li>Alertas por desvío de ruta o retraso.</li>
                </ul>
              </a-card>
            </a-col>
          </a-row>
        </a-tab-pane>

        <a-tab-pane key="finance" tab="Costos & KPIs">
          <a-row :gutter="[16,16]">
            <a-col :xs="24" :md="8">
              <a-card title="Costeo logístico" :hoverable="true">
                <p>Absorción por ruta/vehículo/cliente: km, horas y drops.</p>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="8">
              <a-card title="Liquidación transportistas" :hoverable="true">
                <p>Tarifarios, penalidades, tiempos de espera y peajes.</p>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="8">
              <a-card title="KPIs operativos" :hoverable="true">
                <p>OTD, First Attempt Rate, costo por km, fill rate.</p>
              </a-card>
            </a-col>
          </a-row>
        </a-tab-pane>
      </a-tabs>
    </section>

    <!-- Timeline -->
    <section class="timeline">
      <h2 class="section-title">Flujo operativo</h2>
      <a-timeline>
        <a-timeline-item color="blue">Plan de despachos por zona y ventana horaria</a-timeline-item>
        <a-timeline-item color="green">Wave picking y consolidación por ruta</a-timeline-item>
        <a-timeline-item color="purple">Carga de vehículos y salida a reparto</a-timeline-item>
        <a-timeline-item color="gold">Entrega / POD con firma, foto y GPS</a-timeline-item>
        <a-timeline-item color="red">Devoluciones y cierre de ruta (costeo)</a-timeline-item>
      </a-timeline>
    </section>

    <!-- Tabla de entregas del día -->
    <section class="table">
      <h2 class="section-title">Entregas de hoy</h2>
      <a-alert
        type="info"
        show-icon
        message="Vista demo con datos de muestra. Sincroniza con Ventas/Almacén para ver tus pedidos reales."
        style="margin-bottom:12px"
      />

      <!-- Tabla con slot bodyCell (sin h) -->
      <a-table
        :data-source="deliveries"
        :columns="columns"
        row-key="id"
        :pagination="{ pageSize: 5 }"
        size="middle"
      >
        <template #bodyCell="{ column, record }">
          <template v-if="column.dataIndex === 'estado'">
            <a-badge :status="statusMap[record.estado] || 'default'" />
            <span style="margin-left:6px">{{ record.estado }}</span>
          </template>
        </template>
      </a-table>
    </section>

    <!-- CTA final -->
    <section class="cta">
      <a-card class="cta-card" :hoverable="true">
        <a-row :gutter="[16,16]" align="middle">
          <a-col :xs="24" :md="18">
            <h3>Entregas a tiempo, clientes felices</h3>
            <p>Agenda una demo y recibe el eBook “7 tácticas para bajar el costo por entrega”.</p>
          </a-col>
          <a-col :xs="24" :md="6" class="cta-actions">
            <a-button type="primary" size="large" block @click="contactar">Agendar demo</a-button>
            <a-button size="large" block @click="descargarEbook">Descargar eBook</a-button>
          </a-col>
        </a-row>
      </a-card>
    </section>

    <!-- Drawer: Simulador rápido de ruta -->
    <a-drawer v-model:open="simOpen" title="Simulador de ruta (demo)" placement="right" width="420">
      <a-form layout="vertical">
        <a-form-item label="Capacidad vehículo (kg)">
          <a-input-number style="width:100%" :min="100" :max="10000" v-model:value="sim.capacidad" />
        </a-form-item>
        <a-form-item label="Paradas (drops)">
          <a-input-number style="width:100%" :min="1" :max="60" v-model:value="sim.drops" />
        </a-form-item>
        <a-form-item label="Ventana horaria (hrs)">
          <a-input-number style="width:100%" :min="1" :max="12" v-model:value="sim.ventana" />
        </a-form-item>
        <a-form-item label="Costo estimado por km (S/)">
          <a-input-number style="width:100%" :min="0.5" :max="10" :step="0.1" v-model:value="sim.costoKm" />
        </a-form-item>

        <a-result status="success" title="Resultado estimado">
          <template #subTitle>
            <div class="sim-out">
              <div><strong>Tiempo ruta:</strong> {{ estimados.tiempo }} h</div>
              <div><strong>Km aprox.:</strong> {{ estimados.km }} km</div>
              <div><strong>Costo:</strong> S/ {{ estimados.costo }}</div>
              <div><strong>Utilización:</strong> {{ estimados.utilizacion }}%</div>
            </div>
          </template>
        </a-result>

        <a-space style="width:100%" direction="vertical">
          <a-button type="primary" block @click="contactar">Quiero optimizar mis rutas</a-button>
          <a-button block @click="simOpen=false">Cerrar</a-button>
        </a-space>
      </a-form>
    </a-drawer>
  </WebLayout>
</template>

<script setup>
import WebLayout from '@/Layouts/WebLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const mode = ref('Last-mile')
const simOpen = ref(false)

const sim = ref({ capacidad: 3500, drops: 20, ventana: 6, costoKm: 3.2 })
const estimados = computed(() => {
  // Cálculos mock para demo comercial
  const km = Math.max(8, Math.round(sim.value.drops * 3.5))
  const velocidad = 25 // km/h promedio urbano
  const tiempoBase = km / velocidad
  const ventanas = Math.max(1, sim.value.ventana - 0.5)
  const tiempo = Math.min(ventanas, +(tiempoBase + sim.value.drops * 0.08).toFixed(1))
  const costo = (km * sim.value.costoKm).toFixed(2)
  const utilizacion = Math.min(100, Math.round((sim.value.drops * 12) / sim.value.capacidad * 1000))
  return { km, tiempo, costo, utilizacion }
})

const deliveries = ref([
  { id: 1, ruta: 'LIM-NORTE-01', cliente: 'Tienda San Martín', ventana: '09:00-11:00', estado: 'En ruta', pod: 'Pendiente' },
  { id: 2, ruta: 'LIM-NORTE-01', cliente: 'Farmacia Los Olivos', ventana: '10:00-12:00', estado: 'Entregado', pod: 'Firma' },
  { id: 3, ruta: 'LIM-NORTE-02', cliente: 'Bazar Pro', ventana: '13:00-15:00', estado: 'Retraso', pod: '—' },
  { id: 4, ruta: 'LIM-SUR-01', cliente: 'Supermaxi Barranco', ventana: '11:00-13:00', estado: 'En ruta', pod: '—' },
  { id: 5, ruta: 'CALLAO-01', cliente: 'HiperMar', ventana: '08:00-10:00', estado: 'Entregado', pod: 'Foto+GPS' },
])

/** columnas sin render function; usamos #bodyCell para 'estado' */
const columns = [
  { title: 'Ruta', dataIndex: 'ruta', key: 'ruta' },
  { title: 'Cliente', dataIndex: 'cliente', key: 'cliente' },
  { title: 'Ventana', dataIndex: 'ventana', key: 'ventana' },
  { title: 'Estado', dataIndex: 'estado', key: 'estado' },
  { title: 'POD', dataIndex: 'pod', key: 'pod' },
]

/** mapa de estado -> badge status */
const statusMap = {
  'Entregado': 'success',
  'En ruta': 'processing',
  'Retraso': 'error',
}

const contactar = () => {
  window.location.href = '/contacto?modulo=distribucion'
}
const abrirSimulador = () => { simOpen.value = true }
const descargarEbook = () => {
  window.location.href = '/ebook-distribucion.pdf' // placeholder
}
</script>

<style scoped>
:root{
  --primary:#00a0c8;
  --text:#1f2d3d;
  --muted:#5c6773;
  --bg-soft:#f7fbfd;
}

section{ padding:64px 16px; }
.section-title{ text-align:center; font-size:28px; margin-bottom:16px; color:var(--text); }

/* HERO */
.hero-dist{ background: linear-gradient(180deg, #ffffff, var(--bg-soft)); }
.hero-title{ font-size:40px; font-weight:800; margin:0 0 8px; color:var(--primary); }
.hero-subtitle{ font-size:18px; color:var(--muted); margin-bottom:12px; }
.hero-controls{ display:flex; gap:12px; align-items:center; flex-wrap:wrap; margin-top:8px; }
.mode-bullets{ padding-left:16px; margin:8px 0 0; }
.mode-bullets li{ margin:4px 0; color:var(--text); }
.hero-card{ position:relative; border:none; }
.hero-image{ width:100%; height:auto; display:block; }
.ribbon{
  position:absolute; top:12px; left:-8px; background:var(--primary); color:#fff;
  padding:6px 12px; font-size:12px; font-weight:700; border-radius:4px;
}

/* KPIs */
.kpis{ background:#fff; text-align:center; }
.kpi :deep(.ant-statistic-title){ color:var(--muted); }
.kpi :deep(.ant-statistic-content){ color:var(--text); font-weight:700; font-size:26px; }
.badges{ margin-top:8px; display:flex; justify-content:center; gap:8px; flex-wrap:wrap; }

/* Tabs */
.ops-tabs{ background: var(--bg-soft); }
.ul{ padding-left:16px; margin:0; }
.ul li{ margin:6px 0; }

/* Timeline */
.timeline{ background:#fff; }

/* Tabla */
.table{ background:#fff; }
:deep(.ant-table){ border-radius:8px; }

/* CTA */
.cta{ background: linear-gradient(180deg, var(--bg-soft), #ffffff); }
.cta-card{ border:1px solid #eaf4f8; }
.cta-actions{ display:flex; flex-direction:column; gap:8px; }

/* Responsive */
@media (max-width: 768px){
  .hero-title{ font-size:32px; }
  .hero-subtitle{ font-size:16px; }
}
</style>
