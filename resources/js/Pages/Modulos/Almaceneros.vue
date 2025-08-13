<template>
  <WebLayout>
    <Head title="PRISMA | App Móvil de Almaceneros — Recepción, ubicaciones y conteos" />

    <!-- HERO: operativo con chips -->
    <section class="hero-ops">
      <a-row :gutter="[24,24]" align="middle">
        <a-col :xs="24" :lg="14">
          <h1 class="hero-title">App de Almaceneros PRISMA</h1>
          <p class="hero-subtitle">
            Recibe con <strong>escaneo</strong>, ubica por pasillo/estantería, realiza
            <strong>picking</strong> por olas y ejecuta <strong>inventarios cíclicos</strong>,
            incluso sin conexión.
          </p>

          <div class="chips">
            <a-tag>QR / Cód. Barras</a-tag>
            <a-tag>Multi-ubicación</a-tag>
            <a-tag>Wave Picking</a-tag>
            <a-tag>Series / Lotes / Venc.</a-tag>
            <a-tag>Offline</a-tag>
          </div>

          <a-space>
            <a-button type="primary" size="large" @click="contactar">Solicitar demo</a-button>
            <a-button size="large" ghost @click="abrirScanner">Escáner (demo)</a-button>
          </a-space>
        </a-col>

        <a-col :xs="24" :lg="10">
          <a-card :hoverable="true" class="phone-card" :bodyStyle="{padding:0}">
            <img src="/logo.png" class="mock" alt="App Almaceneros PRISMA" />
            <div class="phone-bezel"></div>
            <div class="ribbon">Operación en piso</div>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- TABLERO: Acciones rápidas + Progreso de olas -->
    <section class="dashboard">
      <a-row :gutter="[16,16]">
        <a-col :xs="24" :md="10">
          <a-card title="Acciones rápidas" :hoverable="true">
            <a-space wrap>
              <a-button @click="abrirScanner" type="default">Escanear ingreso</a-button>
              <a-button @click="abrirUbicacion" type="default">Ubicar producto</a-button>
              <a-button @click="abrirConteo" type="default">Conteo cíclico</a-button>
              <a-button @click="abrirDevolucion" type="default">Devolución proveedor</a-button>
            </a-space>
            <div class="tips">
              <a-tag color="blue">Sugerencia</a-tag> Usa el modo offline si no hay Wi-Fi en el muelle.
            </div>
          </a-card>
        </a-col>

        <a-col :xs="24" :md="14">
          <a-card title="Wave Picking (olitas activas)" :hoverable="true">
            <a-steps :current="2" size="small" responsive>
              <a-step title="Planificación" description="40 pedidos agrupados" />
              <a-step title="Picking" description="En curso (12/40)" />
              <a-step title="Packing" description="Preparando bultos" />
              <a-step title="Despacho" description="Rutas listas" />
            </a-steps>
            <div class="waves">
              <div class="wave">
                <span>WAVE-0825-01</span>
                <a-progress :percent="65" status="active" />
              </div>
              <div class="wave">
                <span>WAVE-0825-02</span>
                <a-progress :percent="30" />
              </div>
            </div>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- KANBAN TAREAS (recepción / picking / conteo) -->
    <section class="kanban">
      <h2 class="section-title">Tareas de hoy</h2>
      <a-row :gutter="[16,16]">
        <a-col :xs="24" :lg="8">
          <a-card :hoverable="true" title="Recepción">
            <div class="card-task" v-for="t in tareas.recepcion" :key="t.id">
              <div class="task-head">
                <a-tag color="blue">{{ t.doc }}</a-tag>
                <small>{{ t.hora }}</small>
              </div>
              <p class="task-desc">{{ t.proveedor }} · {{ t.bultos }} bultos</p>
              <a-space>
                <a-tag>{{ t.tipo }}</a-tag>
                <a-tag v-if="t.detraccion" color="purple">Detracción</a-tag>
              </a-space>
              <a-button size="small" type="primary" @click="abrirScanner">Escanear</a-button>
            </div>
          </a-card>
        </a-col>

        <a-col :xs="24" :lg="8">
          <a-card :hoverable="true" title="Picking">
            <div class="card-task" v-for="t in tareas.picking" :key="t.id">
              <div class="task-head">
                <a-tag color="green">{{ t.pedido }}</a-tag>
                <small>{{ t.hora }}</small>
              </div>
              <p class="task-desc">{{ t.ruta }} · {{ t.items }} ítems</p>
              <a-space>
                <a-tag>{{ t.prioridad }}</a-tag>
                <a-tag v-if="t.frio" color="cyan">Cadena de frío</a-tag>
              </a-space>
              <a-button size="small" @click="abrirUbicacion">Ver ubicaciones</a-button>
            </div>
          </a-card>
        </a-col>

        <a-col :xs="24" :lg="8">
          <a-card :hoverable="true" title="Conteos">
            <div class="card-task" v-for="t in tareas.conteo" :key="t.id">
              <div class="task-head">
                <a-tag color="gold">{{ t.ciclo }}</a-tag>
                <small>{{ t.hora }}</small>
              </div>
              <p class="task-desc">{{ t.zona }} · {{ t.ubicaciones }} ubicaciones</p>
              <a-space>
                <a-tag>{{ t.metodo }}</a-tag>
                <a-tag v-if="t.cegado" color="volcano">Ciego</a-tag>
              </a-space>
              <a-button size="small" @click="abrirConteo">Contar ahora</a-button>
            </div>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- TARJETAS DE UBICACIÓN (mapa simple) -->
    <section class="map-ubis">
      <h2 class="section-title">Ubicaciones destacadas</h2>
      <a-row :gutter="[16,16]">
        <a-col v-for="u in ubicaciones" :key="u.codigo" :xs="24" :md="8">
          <a-card :hoverable="true">
            <template #title>
              <div class="ubi-title">
                <img src="/logo.png" alt="ubi" />
                <span>{{ u.codigo }} — {{ u.alias }}</span>
              </div>
            </template>
            <div class="ubi-grid">
              <div class="ubi-item"><strong>PAS:</strong> {{ u.pasillo }}</div>
              <div class="ubi-item"><strong>EST:</strong> {{ u.estante }}</div>
              <div class="ubi-item"><strong>NIV:</strong> {{ u.nivel }}</div>
              <div class="ubi-item"><strong>Capacidad:</strong> {{ u.capacidad }} u.</div>
            </div>
            <a-progress :percent="u.ocupacion" status="active" />
            <small>Ocupación: {{ u.ocupacion }}%</small>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- TABLA de movimientos recientes -->
    <section class="movs">
      <h2 class="section-title">Movimientos recientes</h2>
      <a-table
        :data-source="movimientos"
        :columns="colsMovs"
        row-key="id"
        :pagination="{ pageSize: 6 }"
        size="middle"
      >
        <template #bodyCell="{ column, record }">
          <template v-if="column.dataIndex === 'tipo'">
            <a-tag :color="tipoColor(record.tipo)">{{ record.tipo }}</a-tag>
          </template>
          <template v-else-if="column.dataIndex === 'detalles'">
            <span>{{ record.sku }} — {{ record.producto }}</span>
          </template>
        </template>
      </a-table>
    </section>

    <!-- CTA final -->
    <section class="cta">
      <a-card class="cta-card" :hoverable="true">
        <a-row :gutter="[16,16]" align="middle">
          <a-col :xs="24" :md="18">
            <h3>Piso ordenado, inventario preciso</h3>
            <p>Agenda una demo y prueba el circuito: recepción → ubicación → picking → conteo.</p>
          </a-col>
          <a-col :xs="24" :md="6" class="cta-actions">
            <a-button type="primary" size="large" block @click="contactar">Agendar demo</a-button>
            <a-button size="large" block @click="descargarFicha">Ficha técnica</a-button>
          </a-col>
        </a-row>
      </a-card>
    </section>

    <!-- DOCK: Escáner & acciones (Drawer lateral) -->
    <a-drawer v-model:open="dockOpen" title="Escáner & Acciones (demo)" placement="right" width="420">
      <a-tabs default-active-key="scan">
        <a-tab-pane key="scan" tab="Escanear">
          <a-form layout="vertical">
            <a-form-item label="Código (QR/Barras)">
              <a-input v-model:value="scan.code" placeholder="Escanea o digita un código" />
            </a-form-item>
            <a-form-item label="Cantidad">
              <a-input-number v-model:value="scan.qty" :min="1" style="width:100%" />
            </a-form-item>
            <a-form-item label="Ubicación destino">
              <a-select v-model:value="scan.ubi" :options="opcionesUbi" placeholder="Selecciona ubicación" />
            </a-form-item>
            <a-alert show-icon type="success" message="Demo: validación OK. Series/Lotes en la app real." />
            <a-space direction="vertical" style="width:100%">
              <a-button type="primary" block @click="contactar">Confirmar ingreso</a-button>
              <a-button block @click="dockOpen=false">Cerrar</a-button>
            </a-space>
          </a-form>
        </a-tab-pane>

        <a-tab-pane key="conteo" tab="Conteo cíclico">
          <a-form layout="vertical">
            <a-form-item label="Zona">
              <a-select v-model:value="conteo.zona" :options="opcionesZona" />
            </a-form-item>
            <a-form-item label="Método">
              <a-segmented v-model:value="conteo.metodo" :options="['Ciego','Abierto']" />
            </a-form-item>
            <a-form-item label="SKU">
              <a-input v-model:value="conteo.sku" placeholder="Escanea SKU" />
            </a-form-item>
            <a-space direction="vertical" style="width:100%">
              <a-button type="primary" block @click="contactar">Guardar conteo</a-button>
            </a-space>
          </a-form>
        </a-tab-pane>
      </a-tabs>
    </a-drawer>
  </WebLayout>
</template>

<script setup>
import WebLayout from '@/Layouts/WebLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'

/* Dock/Scanner */
const dockOpen = ref(false)
const scan = ref({ code: '', qty: 1, ubi: null })
const opcionesUbi = ref([
  { label: 'A-01-01', value: 'A-01-01' },
  { label: 'A-01-02', value: 'A-01-02' },
  { label: 'B-02-03', value: 'B-02-03' },
])

/* Conteo */
const conteo = ref({ zona: 'ZONA A', metodo: 'Ciego', sku: '' })
const opcionesZona = ref([{ label: 'ZONA A', value: 'ZONA A' }, { label: 'ZONA B', value: 'ZONA B' }])

/* Kanban demo */
const tareas = {
  recepcion: [
    { id: 1, doc: 'OC-00981', proveedor: 'Proveedor Lima', bultos: 12, tipo: 'Compra', detraccion: true, hora: '09:15' },
    { id: 2, doc: 'GR-77521', proveedor: 'Filial Arequipa', bultos: 8, tipo: 'Traslado', detraccion: false, hora: '10:05' },
  ],
  picking: [
    { id: 3, pedido: 'PED-10342', ruta: 'LIM-NORTE-01', items: 18, prioridad: 'Alta', frio: false, hora: '10:45' },
    { id: 4, pedido: 'PED-10358', ruta: 'LIM-SUR-03', items: 22, prioridad: 'Media', frio: true, hora: '11:10' },
  ],
  conteo: [
    { id: 5, ciclo: 'CIC-A0825', zona: 'ZONA A', ubicaciones: 15, metodo: 'Cíclico', cegado: true, hora: '12:30' },
  ],
}

/* Ubicaciones tarjetas */
const ubicaciones = ref([
  { codigo: 'A-01-01', alias: 'Bebidas PET', pasillo: 'A', estante: '01', nivel: '01', capacidad: 120, ocupacion: 78 },
  { codigo: 'A-02-02', alias: 'Limpieza', pasillo: 'A', estante: '02', nivel: '02', capacidad: 90, ocupacion: 52 },
  { codigo: 'B-01-03', alias: 'Lácteos frío', pasillo: 'B', estante: '01', nivel: '03', capacidad: 60, ocupacion: 88 },
])

/* Movimientos */
const movimientos = ref([
  { id: 1, fecha: '12:02', tipo: 'Ingreso', sku: 'SKU-0001', producto: 'Agua 625ml', qty: 24, ubi: 'A-01-01' },
  { id: 2, fecha: '12:08', tipo: 'Ubicación', sku: 'SKU-0001', producto: 'Agua 625ml', qty: 24, ubi: 'A-01-02' },
  { id: 3, fecha: '12:15', tipo: 'Picking', sku: 'SKU-0342', producto: 'Leche 1L', qty: 12, ubi: 'B-01-03' },
  { id: 4, fecha: '12:20', tipo: 'Conteo', sku: 'SKU-0891', producto: 'Detergente 500g', qty: 6, ubi: 'A-02-02' },
])
const colsMovs = [
  { title: 'Hora', dataIndex: 'fecha', key: 'fecha' },
  { title: 'Tipo', dataIndex: 'tipo', key: 'tipo' },
  { title: 'Detalles', dataIndex: 'detalles', key: 'detalles' },
  { title: 'Cant.', dataIndex: 'qty', key: 'qty' },
  { title: 'Ubicación', dataIndex: 'ubi', key: 'ubi' },
]
const tipoColor = (t) => ({ Ingreso: 'green', Ubicación: 'blue', Picking: 'purple', Conteo: 'gold' }[t] || 'default')

/* Acciones */
const abrirScanner = () => { dockOpen.value = true }
const abrirUbicacion = () => { dockOpen.value = true }
const abrirConteo = () => { dockOpen.value = true }
const abrirDevolucion = () => { dockOpen.value = true }
const contactar = () => { window.location.href = '/contacto?modulo=app-almaceneros' }
const descargarFicha = () => { window.location.href = '/ficha-app-almaceneros.pdf' }
</script>

<style scoped>
/* Paleta azul/plomo + look operativo */
:root{
  --brand-blue:#0a6aff;
  --brand-gray:#5b6470;
  --bg-soft:#f4f6f9;
  --text:#1f2d3d;
}

section{ padding:64px 16px; }
.section-title{ text-align:center; font-size:26px; margin-bottom:16px; color:var(--text); }

/* HERO */
.hero-ops{ background: linear-gradient(180deg, #ffffff, var(--bg-soft)); }
.hero-title{ font-size:40px; font-weight:800; margin:0 0 8px; color:var(--brand-blue); }
.hero-subtitle{ font-size:18px; color:var(--brand-gray); margin-bottom:12px; }
.chips :deep(.ant-tag){ border-color:var(--brand-blue); color:var(--brand-blue); margin-bottom:6px; }
.phone-card{ position:relative; border:none; background:#101418; border-radius:24px; overflow:hidden; }
.mock{ width:100%; height:auto; display:block; }
.phone-bezel{ position:absolute; inset:8px; border:2px solid #222a33; border-radius:20px; pointer-events:none; }
.ribbon{ position:absolute; top:12px; left:-8px; background:var(--brand-blue); color:#fff; padding:6px 12px; font-size:12px; font-weight:700; border-radius:4px; }

/* Dashboard */
.dashboard{ background:#fff; }
.tips{ margin-top:10px; color:var(--brand-gray); }

/* Kanban */
.kanban{ background:#fff; }
.card-task{
  border:1px dashed #e6eaf0; border-radius:10px; padding:12px; margin-bottom:10px;
  background:#fafbfd;
}
.task-head{ display:flex; justify-content:space-between; align-items:center; margin-bottom:6px; }
.task-desc{ margin:0 0 8px; color:#2a3340; }

/* Ubicaciones */
.map-ubis{ background:#fff; }
.ubi-title{ display:flex; align-items:center; gap:8px; }
.ubi-title img{ width:20px; height:20px; object-fit:contain; filter: grayscale(100%); opacity:.7; }
.ubi-grid{ display:grid; grid-template-columns:repeat(2,1fr); gap:6px; margin:8px 0; }
.ubi-item{ background:#f7f9fc; padding:6px 8px; border-radius:6px; }

/* Movs */
.movs{ background:#fff; }
:deep(.ant-table){ border-radius:10px; }
.waves{ display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:10px; }
.wave span{ display:block; font-weight:600; margin-bottom:4px; }

/* CTA */
.cta{ background: linear-gradient(180deg, var(--bg-soft), #ffffff); }
.cta-card{ border:1px solid #e3e8ef; }
.cta-actions{ display:flex; flex-direction:column; gap:8px; }

/* Responsive */
@media (max-width: 768px){
  .hero-title{ font-size:32px; }
  .hero-subtitle{ font-size:16px; }
  .waves{ grid-template-columns:1fr; }
}
</style>
