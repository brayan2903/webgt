<template>
  <WebLayout>
    <Head title="PRISMA | App Móvil de Supervisor — Turnos, piso y seguridad" />

    <!-- TOP STRIP: filtros compactos -->
    <header class="sup-top">
      <div class="brand"><img src="/logo.png" alt="PRISMA" /><strong>Supervisor</strong></div>
      <div class="filters">
        <a-select v-model:value="filtro.turno" :options="optTurno" style="width:120px" />
        <a-select v-model:value="filtro.area" :options="optArea" style="width:140px" />
        <a-segmented v-model:value="vista" :options="['Piso','Seguridad','Calidad']" />
        <a-button type="primary" @click="abrirIncidencia">Nueva incidencia</a-button>
      </div>
    </header>

    <!-- KPIs EN TIRA -->
    <section class="kpi-strip">
      <a-row :gutter="[10,10]">
        <a-col v-for="k in kpis" :key="k.title" :xs="12" :sm="8" :lg="6">
          <a-card class="kpi-card" :hoverable="true">
            <div class="k-title">{{ k.title }}</div>
            <div class="k-value">
              <span v-if="k.prefix">{{ k.prefix }}</span>{{ k.value }}<small v-if="k.suffix">{{ k.suffix }}</small>
            </div>
            <a-progress :percent="k.progress" :show-info="false" />
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- MOSAICO PRINCIPAL (responsive) -->
    <main class="grid">
      <!-- Turnos & asistencia -->
      <a-card :hoverable="true" title="Turnos & Asistencia" class="tile">
        <a-table
          :data-source="turnos"
          :columns="colsTurnos"
          row-key="id"
          :pagination="{ pageSize: 5 }"
          size="middle"
        >
          <template #bodyCell="{ column, record }">
            <template v-if="column.dataIndex==='estado'">
              <a-badge :status="estadoAsistencia[record.estado] || 'default'" />
              <span style="margin-left:6px">{{ record.estado }}</span>
            </template>
          </template>
        </a-table>
        <div class="tile-actions">
          <a-button @click="abrirCheck">Checklist apertura</a-button>
          <a-button type="primary" @click="abrirIncidencia">Reportar falta</a-button>
        </div>
      </a-card>

      <!-- Incidencias (prioridad) -->
      <a-card :hoverable="true" title="Incidencias" class="tile">
        <a-list :data-source="incidencias" bordered>
          <template #renderItem="{ item }">
            <a-list-item>
              <a-tag :color="prioColor(item.prioridad)">{{ item.prioridad }}</a-tag>
              <span class="inc-text"><strong>{{ item.area }}</strong> — {{ item.desc }}</span>
              <span class="inc-meta">{{ item.hora }}</span>
            </a-list-item>
          </template>
        </a-list>
        <div class="tile-actions">
          <a-button type="primary" @click="abrirIncidencia">Nueva incidencia</a-button>
        </div>
      </a-card>

      <!-- Checklists por área -->
      <a-card :hoverable="true" title="Checklists de piso" class="tile">
        <div class="clist" v-for="c in checklists" :key="c.id">
          <div class="cl-head">
            <strong>{{ c.area }}</strong>
            <small>{{ c.itemsDone }}/{{ c.items }} ítems</small>
          </div>
          <a-progress :percent="Math.round((c.itemsDone/c.items)*100)" status="active" />
          <div class="cl-actions">
            <a-button size="small" @click="abrirCheck">Abrir</a-button>
          </div>
        </div>
      </a-card>

      <!-- Heat tiles: mapa de piso -->
      <a-card :hoverable="true" :title="`Piso — ${filtro.area}`" class="tile">
        <div class="tiles">
          <div class="tile-cell" v-for="z in zonas" :key="z.cod">
            <div class="cell-top">
              <strong>{{ z.nombre }}</strong>
              <a-tag :color="z.color">{{ z.kpi }}</a-tag>
            </div>
            <a-progress :percent="z.uso" :show-info="false" />
            <div class="cell-foot">
              <small>SKU críticos: {{ z.criticos }}</small>
              <small>OTD: {{ z.otd }}%</small>
            </div>
          </div>
        </div>
      </a-card>

      <!-- Feed en vivo -->
      <a-card :hoverable="true" title="Feed en vivo" class="tile">
        <a-timeline>
          <a-timeline-item v-for="(e,idx) in feed" :key="idx" :color="e.color">
            <strong>{{ e.hora }}</strong> — <span v-html="e.text"></span>
          </a-timeline-item>
        </a-timeline>
      </a-card>
    </main>

    <!-- CTA FINAL -->
    <section class="cta">
      <a-card class="cta-card" :hoverable="true">
        <a-row :gutter="[16,16]" align="middle">
          <a-col :xs="24" :md="18">
            <h3>Control total del piso</h3>
            <p>Turnos, checklists, incidencias y KPIs en una sola app para Supervisores.</p>
          </a-col>
          <a-col :xs="24" :md="6" class="cta-actions">
            <a-button type="primary" size="large" block @click="contactar">Probar demo</a-button>
            <a-button size="large" block @click="descargarFicha">Ficha técnica</a-button>
          </a-col>
        </a-row>
      </a-card>
    </section>

    <!-- ACTION BAR (mobile) -->
    <nav class="action-bar">
      <a-button type="primary" block @click="abrirIncidencia">Incidencia</a-button>
      <a-button block @click="abrirCheck">Checklist</a-button>
      <a-button block @click="contactar">Llamar equipo</a-button>
    </nav>

    <!-- Drawer: Nueva incidencia -->
    <a-drawer v-model:open="incOpen" title="Registrar incidencia" placement="right" width="420">
      <a-form layout="vertical">
        <a-form-item label="Área">
          <a-select v-model:value="inc.area" :options="optArea" />
        </a-form-item>
        <a-form-item label="Prioridad">
          <a-segmented v-model:value="inc.prioridad" :options="['Alta','Media','Baja']" />
        </a-form-item>
        <a-form-item label="Descripción">
          <a-textarea v-model:value="inc.desc" rows="3" placeholder="Describe la novedad" />
        </a-form-item>
        <a-result status="success" title="Evidencias (demo)">
          <template #subTitle>Adjunta foto/audio en la app real.</template>
        </a-result>
        <a-space direction="vertical" style="width:100%">
          <a-button type="primary" block @click="contactar">Guardar</a-button>
          <a-button block @click="incOpen=false">Cerrar</a-button>
        </a-space>
      </a-form>
    </a-drawer>

    <!-- Drawer: Checklist -->
    <a-drawer v-model:open="chkOpen" title="Checklist rápido" placement="right" width="420">
      <a-form layout="vertical">
        <a-form-item label="Checklist">
          <a-select v-model:value="chk.selected" :options="optChecklist" />
        </a-form-item>
        <a-form-item label="Responsable">
          <a-input v-model:value="chk.responsable" placeholder="Nombre" />
        </a-form-item>
        <a-form-item label="Turno">
          <a-select v-model:value="chk.turno" :options="optTurno" />
        </a-form-item>

        <a-list :data-source="chk.items" bordered>
          <template #renderItem="{ item }">
            <a-list-item>
              <a-checkbox v-model:checked="item.ok">{{ item.label }}</a-checkbox>
            </a-list-item>
          </template>
        </a-list>

        <a-space direction="vertical" style="width:100%; margin-top:10px">
          <a-button type="primary" block @click="contactar">Guardar checklist</a-button>
          <a-button block @click="chkOpen=false">Cerrar</a-button>
        </a-space>
      </a-form>
    </a-drawer>
  </WebLayout>
</template>

<script setup>
import WebLayout from '@/Layouts/WebLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

/* Filtros top */
const vista = ref('Piso')
const filtro = ref({ turno: 'Mañana', area: 'Producción' })
const optTurno = [
  { label: 'Mañana', value: 'Mañana' },
  { label: 'Tarde', value: 'Tarde' },
  { label: 'Noche', value: 'Noche' },
]
const optArea = [
  { label: 'Producción', value: 'Producción' },
  { label: 'Almacén', value: 'Almacén' },
  { label: 'Despacho', value: 'Despacho' },
  { label: 'Calidad', value: 'Calidad' },
]

/* KPIs tira */
const kpis = [
  { title:'Asistencia', value: 94, suffix:'%', progress:94 },
  { title:'OEE', value: 82, suffix:'%', progress:82 },
  { title:'Incidencias', value: 3, suffix:'', progress:60 },
  { title:'Seguridad', value: 100, suffix:'%', progress:100 },
]

/* Turnos */
const turnos = ref([
  { id:1, colab:'Ana Torres', rol:'Operaria', hora:'08:00', area:'Producción', estado:'Presente' },
  { id:2, colab:'Luis Gómez', rol:'Operario', hora:'08:00', area:'Producción', estado:'Tarde' },
  { id:3, colab:'María Ríos', rol:'Calidad', hora:'08:00', area:'Calidad', estado:'Presente' },
  { id:4, colab:'J. Vásquez', rol:'Almacen', hora:'08:00', area:'Almacén', estado:'Ausente' },
  { id:5, colab:'P. Salazar', rol:'Despacho', hora:'08:00', area:'Despacho', estado:'Presente' },
])
const colsTurnos = [
  { title:'Colab.', dataIndex:'colab', key:'colab' },
  { title:'Rol', dataIndex:'rol', key:'rol' },
  { title:'Entrada', dataIndex:'hora', key:'hora' },
  { title:'Área', dataIndex:'area', key:'area' },
  { title:'Estado', dataIndex:'estado', key:'estado' },
]
const estadoAsistencia = { 'Presente':'success', 'Tarde':'warning', 'Ausente':'error' }

/* Incidencias */
const incidencias = ref([
  { prioridad:'Alta', area:'Producción', desc:'Parada de línea L2 (sensor)', hora:'09:12' },
  { prioridad:'Media', area:'Almacén', desc:'Diferencia conteo ZONA B', hora:'10:05' },
  { prioridad:'Baja', area:'Calidad', desc:'Muestra pendiente lote 332', hora:'10:40' },
])
const prioColor = p => ({ Alta:'red', Media:'orange', Baja:'blue' }[p] || 'default')

/* Checklists */
const checklists = ref([
  { id:1, area:'Seguridad — Apertura', items:10, itemsDone:6 },
  { id:2, area:'Calidad — Limpieza', items:8, itemsDone:8 },
  { id:3, area:'Piso — 5S', items:12, itemsDone:9 },
])

/* Heat tiles piso */
const zonas = ref([
  { cod:'Z-A1', nombre:'ZONA A1', uso:78, kpi:'OK', color:'green', criticos:2, otd:97 },
  { cod:'Z-A2', nombre:'ZONA A2', uso:91, kpi:'ALTO', color:'volcano', criticos:4, otd:92 },
  { cod:'Z-B1', nombre:'ZONA B1', uso:60, kpi:'OK', color:'blue', criticos:1, otd:95 },
  { cod:'Z-B2', nombre:'ZONA B2', uso:72, kpi:'OK', color:'green', criticos:0, otd:96 },
])

/* Feed en vivo */
const feed = ref([
  { hora:'09:05', color:'blue', text:'Checklist <b>Apertura</b> 60% completado.' },
  { hora:'09:12', color:'red', text:'Incidencia <b>Alta</b> en línea L2 — técnico asignado.' },
  { hora:'10:20', color:'green', text:'Pedido WAVE-0825-01 listo para despacho.' },
])

/* Drawers */
const incOpen = ref(false)
const chkOpen = ref(false)
const inc = ref({ area:'Producción', prioridad:'Alta', desc:'' })

const optChecklist = [
  { label:'Seguridad — Apertura', value:'Seguridad — Apertura' },
  { label:'Calidad — Limpieza', value:'Calidad — Limpieza' },
  { label:'Piso — 5S', value:'Piso — 5S' },
]
const chk = ref({
  selected:'Seguridad — Apertura',
  responsable:'',
  turno:'Mañana',
  items:[
    { label:'EPP completo', ok:false },
    { label:'Extintores OK', ok:true },
    { label:'Señalización visible', ok:false },
  ]
})

/* Acciones */
const abrirIncidencia = () => { incOpen.value = true }
const abrirCheck = () => { chkOpen.value = true }
const contactar = () => { window.location.href = '/contacto?modulo=app-supervisor' }
const descargarFicha = () => { window.location.href = '/ficha-app-supervisor.pdf' }
</script>

<style scoped>
/* Paleta azul/plomo y layout “app” */
:root{
  --brand-blue:#0a6aff;
  --brand-gray:#5b6470;
  --bg:#f5f7fb;
  --text:#1f2d3d;
}

.sup-top{
  position:sticky; top:0; z-index:20; background:#0b1a2b; color:#fff;
  padding:10px 16px; border-bottom:1px solid rgba(255,255,255,.08);
  display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;
}
.sup-top .brand{ display:flex; align-items:center; gap:8px; }
.sup-top .brand img{ width:22px; height:22px; object-fit:contain; filter:brightness(200%); }
.sup-top .filters{ display:flex; gap:8px; align-items:center; flex-wrap:wrap; }
:deep(.ant-segmented){ background:#091521; color:#c9d3e1; }
:deep(.ant-segmented-item-selected){ background:var(--brand-blue); color:#fff; }

.kpi-strip{ padding:12px 16px; background:#fff; border-bottom:1px solid #e9eef5; }
.kpi-card{ border:1px solid #e3e8ef; }
.k-title{ color:#8b95a1; font-size:12px; text-transform:uppercase; letter-spacing:.3px; }
.k-value{ font-size:22px; font-weight:800; color:var(--text); line-height:1; margin:4px 0 6px; }
.k-value small{ font-size:12px; margin-left:4px; color:#8b95a1; }

.grid{
  background:var(--bg);
  display:grid; grid-template-columns: 1fr; gap:12px; padding:12px 16px;
}
@media (min-width: 992px){
  .grid{ grid-template-columns: 1fr 1fr; }
}
@media (min-width: 1400px){
  .grid{ grid-template-columns: 2fr 1fr 1fr; }
}
.tile{ border:1px solid #e3e8ef; }

.tile-actions{
  display:flex; gap:8px; justify-content:flex-end; margin-top:10px; flex-wrap:wrap;
}

.inc-text{ margin:0 8px; color:#2a3340; }
.inc-meta{ margin-left:auto; color:#8b95a1; }

.clist{ border:1px dashed #e6eaf0; border-radius:8px; padding:8px; margin-bottom:8px; background:#fafbfd; }
.cl-head{ display:flex; justify-content:space-between; align-items:center; margin-bottom:6px; }
.cl-actions{ display:flex; justify-content:flex-end; }

.tiles{
  display:grid; grid-template-columns: repeat(2,1fr); gap:10px;
}
@media (min-width: 1200px){
  .tiles{ grid-template-columns: repeat(2,1fr); }
}
.tile-cell{ background:#fff; border:1px solid #e3e8ef; border-radius:10px; padding:10px; }
.cell-top{ display:flex; align-items:center; justify-content:space-between; margin-bottom:6px; }
.cell-foot{ display:flex; align-items:center; justify-content:space-between; color:#8b95a1; }

.cta{ padding:12px 16px; }
.cta-card{ border:1px solid #e3e8ef; }
.cta-actions{ display:flex; flex-direction:column; gap:8px; }

/* Action bar móvil */
.action-bar{
  position:sticky; bottom:0; z-index:25; background:#ffffffeb; backdrop-filter: blur(6px);
  padding:8px; display:none; grid-template-columns: 1fr 1fr 1fr; gap:8px; border-top:1px solid #e9eef5;
}
@media (max-width: 768px){
  .action-bar{ display:grid; }
}
</style>
