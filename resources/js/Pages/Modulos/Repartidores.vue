<template>
  <WebLayout>
    <Head title="PRISMA | App Móvil de Repartidores — POD con firma, foto y GPS" />

    <!-- HERO MOBILE-FIRST -->
    <section class="hero-courier">
      <a-row :gutter="[24,24]" align="middle">
        <a-col :xs="24" :lg="12">
          <h1 class="hero-title">App de Repartidores PRISMA</h1>
          <p class="hero-subtitle">
            Entrega con precisión: rutas optimizadas, <strong>POD</strong> (firma, foto, GPS),
            reintentos y contraentrega. Funciona incluso <strong>offline</strong>.
          </p>
          <div class="hero-controls">
            <span>Tipo de unidad:</span>
            <a-segmented v-model:value="unidad" :options="['Moto','Van','Camión']" size="large" />
            <a-space>
              <a-button type="primary" size="large" @click="contactar">Solicitar demo</a-button>
              <a-button size="large" ghost @click="descargarFicha">Ficha técnica</a-button>
            </a-space>
          </div>
          <div class="chips">
            <a-tag>Ruteo y secuencia</a-tag>
            <a-tag>POD firma/foto</a-tag>
            <a-tag>GPS & geocerca</a-tag>
            <a-tag>Reintentos</a-tag>
            <a-tag>Contraentrega</a-tag>
          </div>
        </a-col>

        <a-col :xs="24" :lg="12">
          <a-card :hoverable="true" class="phone-card" :bodyStyle="{padding:0}">
            <a-carousel autoplay>
              <div class="slide"><img src="/logo.png" alt="Ruta y mapa" /></div>
              <div class="slide"><img src="/logo.png" alt="Confirmación POD" /></div>
              <div class="slide"><img src="/logo.png" alt="Reintento y causal" /></div>
            </a-carousel>
            <div class="phone-bezel"></div>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- GRID DE VALOR (ICONS) -->
    <section class="value-grid">
      <a-row :gutter="[16,16]">
        <a-col :xs="24" :md="8">
          <a-card :hoverable="true">
            <div class="icon-row"><img src="/logo.png" alt="Rutas" /><h3>Rutas optimizadas</h3></div>
            <p>Secuencia sugerida por zona, tráfico, ventanas y capacidad de la unidad ({{ unidad }}).</p>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="8">
          <a-card :hoverable="true">
            <div class="icon-row"><img src="/logo.png" alt="POD" /><h3>POD completo</h3></div>
            <p>Firma en pantalla, foto, notas y coordenadas con fecha y hora para auditoría.</p>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="8">
          <a-card :hoverable="true">
            <div class="icon-row"><img src="/logo.png" alt="Docs" /><h3>Documentos & cobros</h3></div>
            <p>Guía de remisión, comprobantes y <strong>contraentrega</strong> (efectivo/QR) desde la app.</p>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- KPIs -->
    <section class="kpis">
      <a-row :gutter="[16,16]" justify="center">
        <a-col :xs="12" :md="6" class="kpi"><a-statistic title="On-time" :value="96" suffix="%" /></a-col>
        <a-col :xs="12" :md="6" class="kpi"><a-statistic title="Primer intento" :value="89" suffix="%" /></a-col>
        <a-col :xs="12" :md="6" class="kpi"><a-statistic title="Km/ruta" :value="42" /></a-col>
        <a-col :xs="12" :md="6" class="kpi"><a-statistic title="Costo por entrega" prefix="S/ " :value="7.9" /></a-col>
      </a-row>
    </section>

    <!-- TABS FUNCIONALES -->
    <section class="tabs">
      <a-tabs default-active-key="ejecucion" size="large" centered>
        <a-tab-pane key="ejecucion" tab="Ejecución & POD">
          <a-row :gutter="[16,16]">
            <a-col :xs="24" :md="12">
              <a-card title="Checklist de salida" :hoverable="true">
                <ul class="ul">
                  <li>Verificación de bultos por escaneo</li>
                  <li>Foto de carga y sello de seguridad</li>
                  <li>Combustible, SOAT y rutas asignadas</li>
                </ul>
                <a-button type="primary" @click="abrirPod">Registrar POD (demo)</a-button>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="12">
              <a-card title="Reintentos & causales" :hoverable="true">
                <ul class="ul">
                  <li>Cliente ausente, dirección no válida, horario cerrado</li>
                  <li>Reprogramación automática y evidencia fotográfica</li>
                  <li>Notificación al cliente con nueva ETA</li>
                </ul>
              </a-card>
            </a-col>
          </a-row>
        </a-tab-pane>

        <a-tab-pane key="documentos" tab="Guías & Contraentrega">
          <a-row :gutter="[16,16]">
            <a-col :xs="24" :md="12">
              <a-card title="Guía de remisión" :hoverable="true">
                <ul class="ul">
                  <li>Descarga digital y validación en ruta</li>
                  <li>Código QR y número de placa</li>
                  <li>Observaciones y evidencias</li>
                </ul>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="12">
              <a-card title="Cobro contraentrega" :hoverable="true">
                <ul class="ul">
                  <li>Medios: efectivo, tarjeta, Yape/Plin, QR</li>
                  <li>Conciliación automática y corte de caja</li>
                  <li>Recibos digitales y firma del cliente</li>
                </ul>
              </a-card>
            </a-col>
          </a-row>
        </a-tab-pane>

        <a-tab-pane key="offline" tab="Offline & Seguridad">
          <a-row :gutter="[16,16]">
            <a-col :xs="24" :md="12">
              <a-card title="Modo offline" :hoverable="true">
                <ul class="ul">
                  <li>Captura POD y cobros sin señal</li>
                  <li>Cola de sincronización al volver a línea</li>
                  <li>Resolución de conflictos por timestamp</li>
                </ul>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="12">
              <a-card title="Seguridad" :hoverable="true">
                <ul class="ul">
                  <li>Geocercas y alertas por desvío</li>
                  <li>Control de velocidades y frenadas</li>
                  <li>Checklist de incidentes</li>
                </ul>
              </a-card>
            </a-col>
          </a-row>
        </a-tab-pane>
      </a-tabs>
    </section>

    <!-- ENTREGAS DEL DÍA -->
    <section class="table">
      <h2 class="section-title">Entregas de hoy</h2>
      <a-table
        :data-source="entregas"
        :columns="colsEntregas"
        row-key="id"
        :pagination="{ pageSize: 6 }"
        size="middle"
      >
        <template #bodyCell="{ column, record }">
          <template v-if="column.dataIndex === 'estado'">
            <a-badge :status="statusMap[record.estado] || 'default'" />
            <span style="margin-left:6px">{{ record.estado }}</span>
          </template>
          <template v-else-if="column.dataIndex === 'pod'">
            <a-tag v-if="record.pod==='OK'" color="green">POD</a-tag>
            <a-tag v-else>—</a-tag>
          </template>
        </template>
      </a-table>
    </section>

    <!-- CTA final -->
    <section class="cta">
      <a-card class="cta-card" :hoverable="true">
        <a-row :gutter="[16,16]" align="middle">
          <a-col :xs="24" :md="18">
            <h3>Entrega impecable, clientes felices</h3>
            <p>Agenda una demo y prueba el flujo completo: ruta → POD → contraentrega → cierre.</p>
          </a-col>
          <a-col :xs="24" :md="6" class="cta-actions">
            <a-button type="primary" size="large" block @click="contactar">Agendar demo</a-button>
            <a-button size="large" block @click="descargarFicha">Ficha técnica</a-button>
          </a-col>
        </a-row>
      </a-card>
    </section>

    <!-- Drawer: POD DEMO -->
    <a-drawer v-model:open="drawerOpen" title="Registrar POD (demo)" placement="right" width="420">
      <a-form layout="vertical">
        <a-form-item label="Entrega">
          <a-select v-model:value="podForm.entrega" :options="optEntrega" placeholder="Selecciona entrega" />
        </a-form-item>
        <a-form-item label="Causal (si no entregado)">
          <a-select v-model:value="podForm.causal" :options="optCausales" allow-clear placeholder="Opcional" />
        </a-form-item>
        <a-form-item label="Notas">
          <a-textarea v-model:value="podForm.notas" rows="3" placeholder="Observaciones" />
        </a-form-item>
        <a-result status="success" title="Evidencias (demo)">
          <template #subTitle>
            Firma, foto y coordenadas se adjuntarán automáticamente en la app real.
          </template>
        </a-result>
        <a-space style="width:100%" direction="vertical">
          <a-button type="primary" block @click="contactar">Guardar POD</a-button>
          <a-button block @click="drawerOpen=false">Cerrar</a-button>
        </a-space>
      </a-form>
    </a-drawer>
  </WebLayout>
</template>

<script setup>
import WebLayout from '@/Layouts/WebLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'

/* Estado UI */
const unidad = ref('Moto')
const drawerOpen = ref(false)

/* Tabla de entregas (demo) */
const entregas = ref([
  { id: 1, ruta: 'LIM-NORTE-01', cliente: 'Bodega San Pedro', ventana: '09:00-11:00', estado: 'En ruta', pod: '—' },
  { id: 2, ruta: 'LIM-NORTE-01', cliente: 'Farmacia Esperanza', ventana: '10:00-12:00', estado: 'Entregado', pod: 'OK' },
  { id: 3, ruta: 'LIM-SUR-02', cliente: 'Rest. Don Pepe', ventana: '13:00-15:00', estado: 'Reintento', pod: '—' },
  { id: 4, ruta: 'CALLAO-01', cliente: 'HiperMar', ventana: '11:00-13:00', estado: 'En ruta', pod: '—' },
  { id: 5, ruta: 'LIM-ESTE-03', cliente: 'Minimarket Surco', ventana: '15:00-17:00', estado: 'Entregado', pod: 'OK' },
  { id: 6, ruta: 'LIM-CENTRO-01', cliente: 'Boutique Miraflores', ventana: '16:00-18:00', estado: 'Pendiente', pod: '—' },
])

const colsEntregas = [
  { title: 'Ruta', dataIndex: 'ruta', key: 'ruta' },
  { title: 'Cliente', dataIndex: 'cliente', key: 'cliente' },
  { title: 'Ventana', dataIndex: 'ventana', key: 'ventana' },
  { title: 'Estado', dataIndex: 'estado', key: 'estado' },
  { title: 'POD', dataIndex: 'pod', key: 'pod' },
]

const statusMap = {
  'Entregado': 'success',
  'En ruta': 'processing',
  'Pendiente': 'default',
  'Reintento': 'warning',
}

/* Drawer POD */
const podForm = ref({ entrega: null, causal: null, notas: '' })
const optEntrega = entregas.value.map(e => ({ label: `${e.ruta} — ${e.cliente}`, value: e.id }))
const optCausales = [
  { label: 'Cliente ausente', value: 'Cliente ausente' },
  { label: 'Dirección incorrecta', value: 'Dirección incorrecta' },
  { label: 'Horario cerrado', value: 'Horario cerrado' },
]

/* Acciones */
const abrirPod = () => { drawerOpen.value = true }
const contactar = () => { window.location.href = '/contacto?modulo=app-repartidores' }
const descargarFicha = () => { window.location.href = '/ficha-app-repartidores.pdf' }
</script>

<style scoped>
/* Paleta azul/plomo */
:root{
  --brand-blue:#0a6aff;
  --brand-gray:#5b6470;
  --bg-soft:#f4f6f9;
  --text:#1f2d3d;
}

/* Sección base */
section{ padding:64px 16px; }
.section-title{ text-align:center; font-size:26px; margin-bottom:16px; color:var(--text); }

/* HERO */
.hero-courier{ background: linear-gradient(180deg, #ffffff, var(--bg-soft)); }
.hero-title{ font-size:40px; font-weight:800; margin:0 0 8px; color:var(--brand-blue); }
.hero-subtitle{ font-size:18px; color:var(--brand-gray); margin-bottom:12px; }
.hero-controls{ display:flex; gap:12px; align-items:center; flex-wrap:wrap; margin:8px 0 6px; }
.chips :deep(.ant-tag){ border-color:var(--brand-blue); color:var(--brand-blue); margin-bottom:6px; }

/* Phone mockup */
.phone-card{ position:relative; border:none; background:#101418; border-radius:24px; overflow:hidden; }
.phone-bezel{ position:absolute; inset:8px; border:2px solid #222a33; border-radius:20px; pointer-events:none; }
.slide img{ width:100%; height:auto; display:block; }

/* Grid valor */
.value-grid{ background:#fff; }
.icon-row{ display:flex; align-items:center; gap:10px; margin-bottom:6px; }
.icon-row img{ width:22px; height:22px; object-fit:contain; filter: grayscale(100%); opacity:.7; }
.icon-row h3{ margin:0; color:var(--text); }

/* KPIs */
.kpis{ background:#fff; text-align:center; }
.kpi :deep(.ant-statistic-title){ color:var(--brand-gray); }
.kpi :deep(.ant-statistic-content){ color:var(--text); font-weight:700; font-size:24px; }

/* Tabs */
.tabs{ background:#fff; }
.ul{ padding-left:16px; margin:0; }
.ul li{ margin:6px 0; color:#2a3340; }

/* Tabla */
.table{ background:#fff; }
:deep(.ant-table){ border-radius:10px; }

/* CTA */
.cta{ background: linear-gradient(180deg, var(--bg-soft), #ffffff); }
.cta-card{ border:1px solid #e3e8ef; }
.cta-actions{ display:flex; flex-direction:column; gap:8px; }

/* Responsive */
@media (max-width: 768px){
  .hero-title{ font-size:32px; }
  .hero-subtitle{ font-size:16px; }
}
</style>
