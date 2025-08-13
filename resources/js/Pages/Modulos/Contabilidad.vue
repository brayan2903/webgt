<template>
  <WebLayout>
    <Head title="ERP PRISMA | Finanzas — Contabilidad, PLE e IGV" />

    <!-- HERO contable -->
    <section class="hero-acc">
      <a-row :gutter="[24,24]" align="middle">
        <a-col :xs="24" :lg="14">
          <h1 class="hero-title">Contabilidad PRISMA</h1>
          <p class="hero-subtitle">
            Libro Diario y Mayor, PCE, centros de costo, asientos automáticos,
            cierre mensual, <strong>IGV</strong> y <strong>PLE</strong> en un solo flujo.
            Integrado con Compras, Ventas, Tesorería y Activos Fijos.
          </p>
          <div class="hero-cta">
            <a-button type="primary" size="large" @click="contactar">Solicitar demo</a-button>
            <a-button size="large" ghost @click="abrirValidador">Validar PLE (demo)</a-button>
          </div>
          <div class="hero-badges">
            <a-tag color="blue">Plan Contable Empresarial</a-tag>
            <a-tag color="green">Multimoneda</a-tag>
            <a-tag color="purple">Centros de costo</a-tag>
          </div>
        </a-col>
        <a-col :xs="24" :lg="10">
          <a-card :hoverable="true" class="hero-card" :bodyStyle="{padding:0}">
            <img src="/logo.png" class="hero-image" alt="Dashboard contable PRISMA" />
            <div class="ribbon">Cierre rápido</div>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- KPIs -->
    <section class="kpis">
      <a-row :gutter="[16,16]" justify="center">
        <a-col :xs="12" :md="6" class="kpi"><a-statistic title="Tiempo de cierre" :value="5" suffix="días" /></a-col>
        <a-col :xs="12" :md="6" class="kpi"><a-statistic title="Conciliaciones OK" :value="98" suffix="%" /></a-col>
        <a-col :xs="12" :md="6" class="kpi"><a-statistic title="Asientos auto" :value="85" suffix="%" /></a-col>
        <a-col :xs="12" :md="6" class="kpi"><a-statistic title="Diferencias T/C" :value="0.2" suffix="%" /></a-col>
      </a-row>
    </section>

    <!-- Layout 2 columnas: Plan contable (árbol) + Resumen -->
    <section class="chart-summary">
      <a-row :gutter="[16,16]">
        <a-col :xs="24" :md="10">
          <a-card title="Plan Contable (PCE)" :hoverable="true">
            <a-tree :tree-data="treePlan" default-expand-all />
            <small>Definiciones de naturaleza, moneda, CC y políticas por cuenta.</small>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="14">
          <a-card title="Resumen del período" :hoverable="true">
            <a-descriptions bordered size="small" :column="2">
              <a-descriptions-item label="Período">Ago 2025</a-descriptions-item>
              <a-descriptions-item label="Estado">En proceso</a-descriptions-item>
              <a-descriptions-item label="Asientos">1,248</a-descriptions-item>
              <a-descriptions-item label="Descuadres">0</a-descriptions-item>
              <a-descriptions-item label="Monedas">S/ y US$</a-descriptions-item>
              <a-descriptions-item label="Centros de costo">12</a-descriptions-item>
            </a-descriptions>
            <div class="badges">
              <a-tag color="gold">Provisión automática</a-tag>
              <a-tag color="cyan">Diferencia de cambio</a-tag>
              <a-tag color="volcano">Ajuste por redondeo</a-tag>
            </div>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- TABS: Libros & PLE | Asientos | Activos fijos -->
    <section class="tabs">
      <a-tabs default-active-key="libros" size="large">
        <a-tab-pane key="libros" tab="Libros & PLE">
          <a-row :gutter="[16,16]">
            <a-col :xs="24" :md="12">
              <a-card :hoverable="true" title="Registros de Ventas & Compras">
                <ul class="ul">
                  <li>IGV: base imponible, exoneradas, inafectas, exportación.</li>
                  <li>Notas de crédito/débito y detracciones.</li>
                  <li>Validaciones de correlativo y RUC.</li>
                </ul>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="12">
              <a-card :hoverable="true" title="PLE (demo)">
                <ul class="ul">
                  <li>Generación de archivos para PLE (ventas/compras/diario/mayor).</li>
                  <li>Prevalidador con errores comunes y sugerencias.</li>
                  <li>Historial de envíos y bitácora de cierre.</li>
                </ul>
                <a-space>
                  <a-button type="primary" @click="abrirValidador">Abrir validador</a-button>
                  <a-button @click="descargarGuia">Guía rápida</a-button>
                </a-space>
              </a-card>
            </a-col>
          </a-row>
        </a-tab-pane>

        <a-tab-pane key="asientos" tab="Asientos">
          <a-alert
            type="info"
            show-icon
            message="Vista demo: asientos integrados desde ventas, compras, tesorería y nóminas."
            style="margin-bottom:12px"
          />
          <a-table
            :data-source="asientos"
            :columns="colsAsientos"
            row-key="id"
            :pagination="{ pageSize: 6 }"
            size="middle"
          >
            <template #bodyCell="{ column, record }">
              <template v-if="column.dataIndex === 'estado'">
                <a-badge :status="estadoAsientoMap[record.estado] || 'default'" />
                <span style="margin-left:6px">{{ record.estado }}</span>
              </template>
              <template v-else-if="column.dataIndex === 'debe' || column.dataIndex === 'haber'">
                {{ formatMoney(record[column.dataIndex]) }}
              </template>
            </template>
          </a-table>

          <div class="totals">
            <a-descriptions bordered size="small" :column="3">
              <a-descriptions-item label="Debe total">S/ {{ totalDebe }}</a-descriptions-item>
              <a-descriptions-item label="Haber total">S/ {{ totalHaber }}</a-descriptions-item>
              <a-descriptions-item label="Cuadre">{{ cuadreOK ? 'OK' : 'Revisar' }}</a-descriptions-item>
            </a-descriptions>
            <a-space>
              <a-button type="primary" @click="asentarCierre">Asentar cierre</a-button>
              <a-button @click="exportarMayor">Exportar Mayor</a-button>
            </a-space>
          </div>
        </a-tab-pane>

        <a-tab-pane key="activos" tab="Activos fijos">
          <a-row :gutter="[16,16]">
            <a-col :xs="24" :md="12">
              <a-card title="Registro y depreciación" :hoverable="true">
                <ul class="ul">
                  <li>Altas, bajas, revalorizaciones y componentes.</li>
                  <li>Métodos: lineal, acelerada, por unidad de producción.</li>
                  <li>Depreciación contable vs tributaria.</li>
                </ul>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="12">
              <a-card title="Conciliación & reportes" :hoverable="true">
                <ul class="ul">
                  <li>Conciliación con cuentas 33x y centros de costo.</li>
                  <li>Reporte de depreciación y Kardex de AF.</li>
                  <li>Etiquetas y auditoría de movimientos.</li>
                </ul>
              </a-card>
            </a-col>
          </a-row>
        </a-tab-pane>
      </a-tabs>
    </section>

    <!-- FAQ -->
    <section class="faq">
      <h2 class="section-title">Preguntas frecuentes</h2>
      <a-collapse accordion>
        <a-collapse-panel key="1" header="¿Soporta multimoneda y diferencias de cambio?">
          Sí, asientos de reevaluación y ajuste automático por T/C del día.
        </a-collapse-panel>
        <a-collapse-panel key="2" header="¿Cómo se integra con Compras y Ventas?">
          Asientos automáticos: provisiones, IGV, detracciones, costo de ventas y notas.
        </a-collapse-panel>
        <a-collapse-panel key="3" header="¿Puedo trabajar por centros de costo y proyectos?">
          Totalmente, dimensiona por CC/Proyecto y obtén estados por segmento.
        </a-collapse-panel>
        <a-collapse-panel key="4" header="¿Genera archivos para PLE?">
          Sí, genera y prevalida archivos de libros exigidos, listos para envío.
        </a-collapse-panel>
      </a-collapse>
    </section>

    <!-- CTA final -->
    <section class="cta">
      <a-card class="cta-card" :hoverable="true">
        <a-row :gutter="[16,16]" align="middle">
          <a-col :xs="24" :md="18">
            <h3>Contabilidad al día y sin estrés</h3>
            <p>Agenda una demo; te mostramos cierre, IGV y PLE con tus propios datos.</p>
          </a-col>
          <a-col :xs="24" :md="6" class="cta-actions">
            <a-button type="primary" size="large" block @click="contactar">Agendar demo</a-button>
            <a-button size="large" block @click="descargarBrochure">Brochure (PDF)</a-button>
          </a-col>
        </a-row>
      </a-card>
    </section>

    <!-- Drawer: Validador PLE (demo comercial) -->
    <a-drawer v-model:open="drawerOpen" title="Validador PLE (demo)" placement="right" width="460">
      <a-form layout="vertical">
        <a-form-item label="Libro">
          <a-select v-model:value="ple.libro" :options="pleLibros" />
        </a-form-item>
        <a-form-item label="Periodo">
          <a-input v-model:value="ple.periodo" placeholder="YYYYMM (ej. 202508)" />
        </a-form-item>

        <a-result :status="pleOk ? 'success' : 'warning'" :title="pleOk ? 'Listo para generar' : 'Observaciones detectadas'">
          <template #subTitle>
            <ul class="ul">
              <li v-for="(m,i) in pleMensajes" :key="i">{{ m }}</li>
            </ul>
          </template>
        </a-result>

        <a-space style="width:100%" direction="vertical">
          <a-button type="primary" block @click="generarPLE">Generar archivos</a-button>
          <a-button block @click="drawerOpen=false">Cerrar</a-button>
        </a-space>
      </a-form>
    </a-drawer>
  </WebLayout>
</template>

<script setup>
import WebLayout from '@/Layouts/WebLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

/* Drawer PLE */
const drawerOpen = ref(false)
const ple = ref({ libro: 'REG_VENTAS', periodo: '202508' })
const pleLibros = [
  { label: 'Registro de Ventas', value: 'REG_VENTAS' },
  { label: 'Registro de Compras', value: 'REG_COMPRAS' },
  { label: 'Libro Diario', value: 'DIARIO' },
  { label: 'Libro Mayor', value: 'MAYOR' },
]
const pleMensajes = computed(() => {
  const msgs = []
  if (!/^\d{6}$/.test(ple.value.periodo)) msgs.push('Formato de periodo inválido. Use YYYYMM.')
  msgs.push('RUC cliente/proveedor validado (muestra).')
  msgs.push('Correlativos y fechas consistentes (muestra).')
  return msgs
})
const pleOk = computed(() => /^\d{6}$/.test(ple.value.periodo))
const abrirValidador = () => { drawerOpen.value = true }
const generarPLE = () => { window.location.href = '/export/ple.zip' }

/* Plan contable (árbol demo) */
const treePlan = [
  { title: '10 Efectivo y equivalentes', key: '10',
    children: [
      { title: '101 Caja', key: '101' },
      { title: '104 Cuentas corrientes', key: '104' },
    ]
  },
  { title: '12 Cuentas por cobrar', key: '12',
    children: [{ title: '121 Comerciales - Terceros', key: '121' }]
  },
  { title: '20 Mercaderías', key: '20' },
  { title: '33 Inmuebles, maquinaria y equipo', key: '33' },
  { title: '40 Tributos por pagar', key: '40' },
  { title: '60 Compras', key: '60' },
  { title: '70 Ventas', key: '70' },
]

/* Asientos (tabla demo) */
const asientos = ref([
  { id: 1, fecha: '2025-08-05', glosa: 'Venta contado', cuenta: '701.01', debe: 0, haber: 4500, estado: 'Ok' },
  { id: 2, fecha: '2025-08-05', glosa: 'IGV por pagar', cuenta: '4011.01', debe: 0, haber: 810, estado: 'Ok' },
  { id: 3, fecha: '2025-08-05', glosa: 'Caja', cuenta: '101.01', debe: 5310, haber: 0, estado: 'Ok' },
  { id: 4, fecha: '2025-08-06', glosa: 'Compra mercadería', cuenta: '601.01', debe: 3000, haber: 0, estado: 'Ok' },
  { id: 5, fecha: '2025-08-06', glosa: 'IGV crédito fiscal', cuenta: '4011.02', debe: 540, haber: 0, estado: 'Ok' },
  { id: 6, fecha: '2025-08-06', glosa: 'Proveedor', cuenta: '4212.01', debe: 0, haber: 3540, estado: 'Ok' },
])

const colsAsientos = [
  { title: 'Fecha', dataIndex: 'fecha', key: 'fecha' },
  { title: 'Glosa', dataIndex: 'glosa', key: 'glosa' },
  { title: 'Cuenta', dataIndex: 'cuenta', key: 'cuenta' },
  { title: 'Debe', dataIndex: 'debe', key: 'debe' },
  { title: 'Haber', dataIndex: 'haber', key: 'haber' },
  { title: 'Estado', dataIndex: 'estado', key: 'estado' },
]

const estadoAsientoMap = { 'Ok': 'success', 'Observado': 'warning', 'Error': 'error' }

const totalDebe = computed(() =>
  asientos.value.reduce((a, r) => a + Number(r.debe || 0), 0).toLocaleString('es-PE', { minimumFractionDigits: 2 })
)
const totalHaber = computed(() =>
  asientos.value.reduce((a, r) => a + Number(r.haber || 0), 0).toLocaleString('es-PE', { minimumFractionDigits: 2 })
)
const cuadreOK = computed(() => {
  const d = asientos.value.reduce((a, r) => a + Number(r.debe || 0), 0)
  const h = asientos.value.reduce((a, r) => a + Number(r.haber || 0), 0)
  return Math.abs(d - h) < 0.01
})

/* Helpers */
const formatMoney = (n) => Number(n || 0).toLocaleString('es-PE', { minimumFractionDigits: 2 })

/* Acciones CTA */
const contactar = () => { window.location.href = '/contacto?modulo=contabilidad' }
const descargarBrochure = () => { window.location.href = '/brochure-contabilidad.pdf' }
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
.hero-acc{ background: linear-gradient(180deg, #ffffff, var(--bg-soft)); }
.hero-title{ font-size:40px; font-weight:800; margin:0 0 8px; color:var(--primary); }
.hero-subtitle{ font-size:18px; color:var(--muted); margin-bottom:12px; }
.hero-cta{ display:flex; gap:12px; flex-wrap:wrap; margin-top:8px; }
.hero-badges{ display:flex; gap:8px; flex-wrap:wrap; margin-top:8px; }
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

/* Árbol + resumen */
.chart-summary{ background:#fff; }

/* Tabs */
.tabs{ background:#fff; margin-top:0; }
.ul{ padding-left:16px; margin:0; }
.ul li{ margin:6px 0; }
.badges{ margin-top:8px; display:flex; gap:8px; flex-wrap:wrap; }

/* Asientos */
.totals{
  margin-top:12px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;
}

/* FAQ */
.faq{ background: var(--bg-soft); }

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
