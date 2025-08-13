<template>
  <WebLayout>
    <Head title="PRISMA | App Móvil de Gerentes — KPIs, equipos y alertas" />

    <!-- TOP BAR FIJA (estilo app) -->
    <div class="topbar">
      <div class="brand">
        <img src="/logo.png" alt="PRISMA" />
        <strong>Panel Gerencial</strong>
      </div>
      <div class="filters">
        <a-select v-model:value="filtro.canal" :options="optCanal" style="width:130px" />
        <a-select v-model:value="filtro.periodo" :options="optPeriodo" style="width:140px" />
        <a-select v-model:value="filtro.region" :options="optRegion" style="width:150px" />
        <a-segmented v-model:value="modo" :options="['Comercial','Operaciones','Finanzas']" />
        <a-button type="primary" @click="abrirConfig">Configurar KPIs</a-button>
      </div>
    </div>

    <!-- CONTENIDO: tablero -->
    <div class="board">

      <!-- MOSAICO KPIs (mismo renglón responsive) -->
      <section class="kpi-wall">
        <a-row :gutter="[12,12]">
          <a-col v-for="k in kpis" :key="k.key" :xs="12" :md="6">
            <a-card :hoverable="true" class="kpi-card">
              <div class="kpi-head">
                <span class="kpi-title">{{ k.title }}</span>
                <a-tag :color="k.trendColor">{{ k.trend }}</a-tag>
              </div>
              <div class="kpi-value">
                <span v-if="k.prefix">{{ k.prefix }}</span>{{ k.value }}
                <small v-if="k.suffix">{{ k.suffix }}</small>
              </div>
              <a-progress :percent="k.progress" :show-info="false" />
              <small class="kpi-foot">{{ k.note }}</small>
            </a-card>
          </a-col>
        </a-row>
      </section>

      <!-- INSIGHTS ejecutivos (carousel) -->
      <section class="insights">
        <a-carousel autoplay>
          <div class="ins-item" v-for="(i,idx) in insights" :key="idx">
            <a-badge :status="i.status" />
            <span class="ins-text" v-html="i.text"></span>
          </div>
        </a-carousel>
      </section>

      <!-- GRID PRINCIPAL: 3 columnas -->
      <section class="grid-3">
        <!-- 1) RENDIMIENTO DE EQUIPOS -->
        <a-card :hoverable="true" title="Rendimiento de equipos">
          <a-list :data-source="ranking" :renderItem="renderRanking" bordered />
        </a-card>

        <!-- 2) HEAT TILES REGIONAL -->
        <a-card :hoverable="true" title="Regiones (Heat tiles)">
          <div class="tiles">
            <div class="tile" v-for="r in regiones" :key="r.cod">
              <div class="tile-top">
                <strong>{{ r.nombre }}</strong>
                <a-tag :color="r.color">{{ r.variacion }}</a-tag>
              </div>
              <div class="tile-mid">
                <span class="tile-metric">S/ {{ num(r.ventas) }}</span>
                <a-progress :percent="r.cumplimiento" status="active" :show-info="false" />
              </div>
              <div class="tile-foot">
                <small>Ticket: S/ {{ num(r.ticket) }}</small>
                <small>OTD: {{ r.otd }}%</small>
              </div>
            </div>
          </div>
        </a-card>

        <!-- 3) EMBUDO (Ventas / Cobranza) -->
        <a-card :hoverable="true" :title="'Embudo — ' + (modo==='Finanzas' ? 'Cobranza' : 'Ventas')">
          <div class="funnel">
            <div v-for="e in embudo" :key="e.etapa" class="funnel-row">
              <div class="funnel-label">{{ e.etapa }}</div>
              <div class="funnel-bar">
                <a-progress :percent="e.pct" :show-info="false" />
              </div>
              <div class="funnel-val">{{ e.prefix }} {{ num(e.valor) }}</div>
            </div>
          </div>
          <a-divider />
          <div class="funnel-foot">
            <a-statistic title="Forecast del mes" :value="forecast" prefix="S/ " />
            <a-button type="link" @click="guardarSnapshot">Guardar snapshot</a-button>
          </div>
        </a-card>
      </section>

      <!-- FEED DE ALERTAS -->
      <section class="alerts">
        <a-card :hoverable="true" title="Alertas & tareas">
          <a-list :data-source="alertas" bordered>
            <template #renderItem="{ item }">
              <a-list-item>
                <a-badge :status="item.status" />
                <span class="alert-text" v-html="item.text"></span>
                <a-space>
                  <a-button v-if="item.cta" size="small" @click="contactar">{{ item.cta }}</a-button>
                </a-space>
              </a-list-item>
            </template>
          </a-list>
        </a-card>
      </section>

      <!-- CTA inferior fija -->
      <section class="cta">
        <a-card class="cta-card" :hoverable="true">
          <a-row :gutter="[16,16]" align="middle">
            <a-col :xs="24" :md="18">
              <h3>Decide con datos en tiempo real</h3>
              <p>KPIs, equipos, regiones y alertas en una sola app para gerentes.</p>
            </a-col>
            <a-col :xs="24" :md="6" class="cta-actions">
              <a-button type="primary" size="large" block @click="contactar">Probar demo</a-button>
              <a-button size="large" block @click="descargarFicha">Ficha técnica</a-button>
            </a-col>
          </a-row>
        </a-card>
      </section>
    </div>

    <!-- Drawer: Configurar KPIs -->
    <a-drawer v-model:open="cfgOpen" title="Configurar KPIs visibles" placement="right" width="420">
      <a-form layout="vertical">
        <a-form-item label="Selecciona KPIs">
          <a-checkbox-group v-model:value="cfg.kpis" :options="optKpis" />
        </a-form-item>
        <a-form-item label="Comparar contra">
          <a-segmented v-model:value="cfg.base" :options="['Mes anterior','Mismo mes año pasado','Meta']" />
        </a-form-item>
        <a-space style="width:100%" direction="vertical">
          <a-button type="primary" block @click="aplicarConfig">Aplicar</a-button>
          <a-button block @click="cfgOpen=false">Cerrar</a-button>
        </a-space>
      </a-form>
    </a-drawer>
  </WebLayout>
</template>

<script setup>
import WebLayout from '@/Layouts/WebLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref, computed, h } from 'vue'

/* Top bar filters */
const modo = ref('Comercial')
const filtro = ref({ canal: 'B2B', periodo: 'Ago 2025', region: 'Lima' })
const optCanal = [
  { label: 'B2B', value: 'B2B' },
  { label: 'Retail', value: 'Retail' },
  { label: 'eCommerce', value: 'eCommerce' },
]
const optPeriodo = [
  { label: 'Ago 2025', value: 'Ago 2025' },
  { label: 'Jul 2025', value: 'Jul 2025' },
  { label: 'Jun 2025', value: 'Jun 2025' },
]
const optRegion = [
  { label: 'Lima', value: 'Lima' },
  { label: 'Norte', value: 'Norte' },
  { label: 'Centro', value: 'Centro' },
  { label: 'Sur', value: 'Sur' },
]

/* KPI mosaic (demo) */
const kpisBase = [
  { key:'ventas', title:'Ventas', prefix:'S/', value: 985000, suffix:'', progress:76, trend:'+12% ↑', trendColor:'green', note:'vs mes anterior' },
  { key:'margen', title:'Margen', prefix:'', value: 22.8, suffix:'%', progress:68, trend:'+0.8pp ↑', trendColor:'green', note:'margen bruto' },
  { key:'cobranza', title:'Cobranza', prefix:'', value: 91, suffix:'%', progress:91, trend:'+6% ↑', trendColor:'green', note:'DSO 42 días' },
  { key:'otd', title:'On-time delivery', prefix:'', value: 96, suffix:'%', progress:96, trend:'+3% ↑', trendColor:'green', note:'SLA rutas' },
  { key:'rotacion', title:'Rotación inventario', prefix:'', value: 7.4, suffix:'x', progress:74, trend:'-0.3x ↓', trendColor:'red', note:'últimos 90 días' },
  { key:'ticket', title:'Ticket promedio', prefix:'S/', value: 182, suffix:'', progress:63, trend:'+5% ↑', trendColor:'green', note:'por pedido' },
  { key:'devol', title:'Devoluciones', prefix:'', value: 1.6, suffix:'%', progress:84, trend:'-0.4pp ↓', trendColor:'green', note:'% sobre ventas' },
  { key:'oee', title:'OEE planta', prefix:'', value: 84, suffix:'%', progress:84, trend:'+2% ↑', trendColor:'green', note:'producción' },
]
/* configuración visible */
const visibles = ref(['ventas','margen','cobranza','otd','ticket','devol','rotacion','oee'])
const kpis = computed(() => kpisBase.filter(k => visibles.value.includes(k.key)))

/* Insights */
const insights = ref([
  { status:'processing', text:'Stock crítico en <b>Bebidas PET</b> — sugiere reposición.' },
  { status:'success', text:'Cobranza alcanzó <b>91%</b> del mes; riesgo bajo.' },
  { status:'warning', text:'Región <b>Sur</b> con OTD 89% — revisar ruteo.' },
])

/* Ranking equipos */
const ranking = ref([
  { team:'Lima Norte', vendedor:'Equipo A', ventas: 245000, cumplimiento: 108 },
  { team:'Retail Lima', vendedor:'Equipo B', ventas: 210500, cumplimiento: 102 },
  { team:'Arequipa', vendedor:'Equipo C', ventas: 164200, cumplimiento: 96 },
  { team:'Trujillo', vendedor:'Equipo D', ventas: 139000, cumplimiento: 91 },
])
const renderRanking = item => h(
  'div',
  { class:'rank-row' },
  [
    h('div', { class:'rank-left' }, [
      h('strong', item.team),
      h('small', ` · ${item.vendedor}`)
    ]),
    h('div', { class:'rank-right' }, [
      h('span', `S/ ${num(item.ventas)}`),
      h('a-progress', { percent: item.cumplimiento, showInfo: false })
    ])
  ]
)

/* Regiones heat tiles */
const regiones = ref([
  { cod:'LIM', nombre:'Lima', ventas: 520000, cumplimiento: 92, variacion:'+8%', color:'green', ticket: 195, otd: 97 },
  { cod:'NOR', nombre:'Norte', ventas: 210000, cumplimiento: 81, variacion:'+3%', color:'blue', ticket: 168, otd: 94 },
  { cod:'CEN', nombre:'Centro', ventas: 125000, cumplimiento: 74, variacion:'-2%', color:'orange', ticket: 152, otd: 91 },
  { cod:'SUR', nombre:'Sur', ventas: 130000, cumplimiento: 69, variacion:'-4%', color:'volcano', ticket: 147, otd: 89 },
])

/* Embudo (depende de modo) */
const embudo = computed(() => {
  if (modo.value === 'Finanzas') {
    return [
      { etapa:'Por vencer', valor: 380000, prefix:'S/', pct: 70 },
      { etapa:'Vencido 1-15', valor: 120000, prefix:'S/', pct: 40 },
      { etapa:'> 30 días', valor: 45000, prefix:'S/', pct: 18 },
    ]
  }
  return [
    { etapa:'Leads', valor: 3200, prefix:'', pct: 65 },
    { etapa:'Oportunidades', valor: 920, prefix:'', pct: 54 },
    { etapa:'Cotizaciones', valor: 410, prefix:'', pct: 42 },
    { etapa:'Pedidos', valor: 180, prefix:'', pct: 36 },
  ]
})
const forecast = computed(() => 950000)

/* Alertas */
const alertas = ref([
  { status:'warning', text:'<b>OTD</b> bajó en Sur. Revisar <i>CALLAO-02</i>.', cta:'Ver rutas' },
  { status:'error', text:'Cliente <b>Retail Norte</b> con <b>vencidos 45d</b>.', cta:'Llamar CxC' },
  { status:'processing', text:'Compras sugiere <b>reposición</b> en SKU-0891.' },
])

/* Drawer config */
const cfgOpen = ref(false)
const cfg = ref({ kpis: [...visibles.value], base: 'Mes anterior' })
const optKpis = kpisBase.map(k => ({ label: k.title, value: k.key }))
const abrirConfig = () => { cfgOpen.value = true }
const aplicarConfig = () => { visibles.value = [...cfg.value.kpis]; cfgOpen.value = false }

/* Acciones */
const guardarSnapshot = () => { window.location.href = '/snapshot-gerencia.pdf' }
const contactar = () => { window.location.href = '/contacto?modulo=app-gerentes' }
const descargarFicha = () => { window.location.href = '/ficha-app-gerentes.pdf' }

/* Utils */
const num = (n) => Number(n || 0).toLocaleString('es-PE', { maximumFractionDigits: 0 })
</script>

<style scoped>
/* Paleta azul/plomo, look app */
:root{
  --brand-blue:#0a6aff;
  --brand-gray:#5b6470;
  --bg:#f5f7fb;
  --text:#1f2d3d;
}

/* Topbar fija */
.topbar{
  position:sticky; top:0; z-index:20;
  display:flex; align-items:center; justify-content:space-between;
  padding:10px 16px; background:#0b1a2b; color:#fff; border-bottom:1px solid rgba(255,255,255,.08);
}
.topbar .brand{ display:flex; align-items:center; gap:8px; font-size:16px; }
.topbar .brand img{ width:22px; height:22px; object-fit:contain; filter:brightness(200%); }
.topbar .filters{ display:flex; gap:8px; align-items:center; flex-wrap:wrap; }
:deep(.ant-segmented){ background:#091521; color:#c9d3e1; }
:deep(.ant-segmented-item-selected){ background:#0a6aff; color:#fff; }

/* Board */
.board{ background:var(--bg); min-height:100vh; padding:16px; }

/* KPI wall */
.kpi-wall{ margin-bottom:12px; }
.kpi-card{ border:1px solid #e3e8ef; }
.kpi-head{ display:flex; align-items:center; justify-content:space-between; margin-bottom:6px; }
.kpi-title{ color:#5b6470; font-size:12px; text-transform:uppercase; letter-spacing:.3px; }
.kpi-value{ font-size:26px; font-weight:800; color:var(--text); line-height:1; margin-bottom:6px; }
.kpi-value small{ font-size:14px; margin-left:4px; color:#88919c; }
.kpi-foot{ color:#88919c; }

/* Insights */
.insights :deep(.slick-slide){ padding:4px 8px; }
.ins-item{ display:flex; align-items:center; gap:8px; background:#fff; border:1px solid #e3e8ef; border-radius:8px; padding:8px; }
.ins-text{ color:#2a3340; }

/* Grid 3 col */
.grid-3{
  display:grid; grid-template-columns: 1fr; gap:12px; margin-top:8px;
}
@media (min-width: 992px){
  .grid-3{ grid-template-columns: 1fr 1fr 1fr; }
}

/* Ranking */
.rank-row{ display:flex; align-items:center; justify-content:space-between; gap:12px; padding:6px 0; }
.rank-left small{ color:#8b95a1; margin-left:4px; }
.rank-right{ display:flex; flex-direction:column; align-items:flex-end; gap:4px; }

/* Heat tiles */
.tiles{ display:grid; grid-template-columns: repeat(2,1fr); gap:10px; }
@media (min-width: 1200px){ .tiles{ grid-template-columns: repeat(2,1fr); } }
.tile{
  background:#fff; border:1px solid #e3e8ef; border-radius:10px; padding:10px;
}
.tile-top{ display:flex; align-items:center; justify-content:space-between; margin-bottom:6px; }
.tile-mid .tile-metric{ font-weight:800; color:var(--text); display:block; margin-bottom:6px; }
.tile-foot{ display:flex; align-items:center; justify-content:space-between; color:#8b95a1; }

/* Embudo */
.funnel-row{ display:grid; grid-template-columns: 110px 1fr 110px; align-items:center; gap:10px; margin-bottom:6px; }
.funnel-label{ color:#5b6470; font-size:12px; }
.funnel-val{ text-align:right; font-weight:700; color:#2a3340; }
.funnel-foot{ display:flex; align-items:center; justify-content:space-between; }

/* Alertas */
.alerts{ margin-top:12px; }
.alert-text{ margin-left:8px; color:#2a3340; }

/* CTA */
.cta{ margin-top:12px; }
.cta-card{ border:1px solid #e3e8ef; }
.cta-actions{ display:flex; flex-direction:column; gap:8px; }
</style>
