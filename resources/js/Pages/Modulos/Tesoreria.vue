<template>
  <WebLayout>
    <Head title="ERP PRISMA | Tesorería — Liquidez, pagos y conciliación bancaria" />

    <!-- HERO financiero con selector de enfoque -->
    <section class="hero-cash">
      <a-row :gutter="[24,24]" align="middle">
        <a-col :xs="24" :lg="14">
          <h1 class="hero-title">Tesorería PRISMA</h1>
          <p class="hero-subtitle">
            Proyecta tu <strong>flujo de caja</strong>, programa pagos con aprobaciones,
            optimiza cobranzas y concilia bancos con precisión. Integrado con Ventas,
            Compras, Contabilidad y Facturación Electrónica SUNAT.
          </p>

          <div class="hero-controls">
            <a-segmented v-model:value="enfoque" :options="['CxC','CxP','Bancos']" size="large" />
            <a-space>
              <a-button type="primary" size="large" @click="contactar">Solicitar demo</a-button>
              <a-button size="large" ghost @click="abrirSimulador">Simular flujo</a-button>
            </a-space>
          </div>

          <ul class="bullets">
            <li v-if="enfoque==='CxC'">Cartera por tramo (0-30/31-60/61-90/+90) y promesas de pago.</li>
            <li v-if="enfoque==='CxC'">Recordatorios automáticos y WhatsApp/email con estado.</li>

            <li v-if="enfoque==='CxP'">Corrida de pagos por prioridad, descuentos y detracciones.</li>
            <li v-if="enfoque==='CxP'">Flujos de aprobación multinivel y archivos bancarios (TXT).</li>

            <li v-if="enfoque==='Bancos'">Conciliación automática por referencia y reglas.</li>
            <li v-if="enfoque==='Bancos'">Saldos consolidados multi-moneda y posiciones diarias.</li>
          </ul>
        </a-col>

        <a-col :xs="24" :lg="10">
          <a-card :hoverable="true" class="hero-card" :bodyStyle="{padding:0}">
            <img src="/logo.png" class="hero-image" alt="Tablero de Tesorería PRISMA" />
            <div class="ribbon">Liquidez en tiempo real</div>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- LIQUIDEZ / POSICIÓN -->
    <section class="liquidity">
      <a-row :gutter="[16,16]">
        <a-col :xs="24" :md="8">
          <a-card :hoverable="true" title="Posición de caja (hoy)">
            <div class="kpi-block">
              <a-statistic title="Soles (S/)" :value="425000" />
              <a-statistic title="Dólares (US$)" :value="132000" />
            </div>
            <a-progress :percent="82" status="active" />
            <small>Objetivo de liquidez mensual alcanzado</small>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="8">
          <a-card :hoverable="true" title="Ingresos vs Egresos (semana)">
            <div class="bars">
              <div class="bar">
                <span>Ingresos</span>
                <a-progress :percent="70" />
              </div>
              <div class="bar">
                <span>Egresos</span>
                <a-progress :percent="55" />
              </div>
            </div>
            <small>Basado en vencimientos y previsiones</small>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="8">
          <a-card :hoverable="true" title="Alertas">
            <ul class="ul">
              <li>Clientes > 60 días: 12</li>
              <li>Facturas con detracción hoy: 4</li>
              <li>Pagos con pronto pago vigente: 3</li>
            </ul>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- CALENDARIO DE VENCIMIENTOS (vista semana) -->
    <section class="calendar">
      <h2 class="section-title">Vencimientos de la semana</h2>
      <a-row :gutter="[16,16]">
        <a-col v-for="d in vencimientosSemana" :key="d.fecha" :xs="24" :md="8">
          <a-card :title="d.fechaLabel" :hoverable="true">
            <ul class="calendar-list">
              <li v-for="(v,i) in d.items" :key="i">
                <a-badge :status="v.tipo==='CxC' ? 'success' : 'processing'" />
                <span class="cal-text">{{ v.tipo }} — {{ v.doc }} — {{ v.clienteProveedor }}</span>
                <strong class="cal-monto">{{ v.moneda }} {{ v.monto }}</strong>
              </li>
            </ul>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- TABS: Corrida de pagos / Cobranzas / Conciliación -->
    <section class="tabs">
      <a-tabs default-active-key="pagos" size="large">
        <a-tab-pane key="pagos" tab="Corrida de pagos (CxP)">
          <a-alert
            type="info"
            show-icon
            message="Selecciona facturas a pagar; respeta topes de caja, descuentos, detracciones y flujos de aprobación."
            style="margin-bottom:12px"
          />
          <a-table
            :data-source="corridaPagos"
            :columns="colsPagos"
            row-key="id"
            :pagination="{ pageSize: 5 }"
            size="middle"
            :row-selection="{ selectedRowKeys, onChange: onSelectPagos }"
          >
            <template #bodyCell="{ column, record }">
              <template v-if="column.dataIndex === 'estado'">
                <a-badge :status="estadoPagoBadge[record.estado] || 'default'" />
                <span style="margin-left:6px">{{ record.estado }}</span>
              </template>
            </template>
          </a-table>

          <div class="run-footer">
            <a-descriptions size="small" bordered :column="3">
              <a-descriptions-item label="Seleccionadas">{{ selectedRowKeys.length }}</a-descriptions-item>
              <a-descriptions-item label="Total a pagar (S/)">S/ {{ totalPagar }}</a-descriptions-item>
              <a-descriptions-item label="Impacto en caja">OK</a-descriptions-item>
            </a-descriptions>
            <a-space>
              <a-button type="primary" @click="aprobarPagos">Enviar a aprobación</a-button>
              <a-button @click="generarArchivo">Generar archivo bancario</a-button>
            </a-space>
          </div>
        </a-tab-pane>

        <a-tab-pane key="cobranzas" tab="Cobranzas (CxC)">
          <a-row :gutter="[16,16]">
            <a-col :xs="24" :md="12">
              <a-card title="Acciones rápidas" :hoverable="true">
                <ul class="ul">
                  <li>Enviar recordatorio a clientes con 31-60 días</li>
                  <li>Programar promesa de pago</li>
                  <li>Registrar cobranza / conciliación</li>
                </ul>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="12">
              <a-card title="KPIs de cobranza" :hoverable="true">
                <div class="kpi-inline">
                  <a-statistic title="DSO" :value="42" suffix="días" />
                  <a-statistic title="Efectividad" :value="93" suffix="%" />
                  <a-statistic title="Promesas activas" :value="18" />
                </div>
              </a-card>
            </a-col>
          </a-row>
        </a-tab-pane>

        <a-tab-pane key="bancos" tab="Conciliación bancaria">
          <a-row :gutter="[16,16]">
            <a-col :xs="24" :md="12">
              <a-card title="Conciliación automática" :hoverable="true">
                <ul class="ul">
                  <li>Importa movimientos (CSV/TXT) de tus bancos.</li>
                  <li>Match por monto, fecha y referencia con reglas.</li>
                  <li>Partidas abiertas, diferencias y asientos sugeridos.</li>
                </ul>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="12">
              <a-card title="Posición multicuenta" :hoverable="true">
                <ul class="ul">
                  <li>Cuentas en S/ y US$ con TC del día.</li>
                  <li>Fondos restringidos y líneas de crédito.</li>
                  <li>Inversiones y préstamos (intereses/costeo).</li>
                </ul>
              </a-card>
            </a-col>
          </a-row>
        </a-tab-pane>
      </a-tabs>
    </section>

    <!-- FAQ breve -->
    <section class="faq">
      <h2 class="section-title">Preguntas frecuentes</h2>
      <a-collapse accordion>
        <a-collapse-panel key="1" header="¿Generan archivos bancarios para pago masivo?">
          Sí, exporta TXT/CSV según formato del banco y registra el pago automáticamente.
        </a-collapse-panel>
        <a-collapse-panel key="2" header="¿Maneja detracciones, percepciones y retenciones?">
          Totalmente. Parametriza reglas SUNAT y liquida desde la corrida de pagos.
        </a-collapse-panel>
        <a-collapse-panel key="3" header="¿Flujo de aprobaciones?">
          Aprobaciones multinivel por monto, centro de costo y proveedor, con auditoría.
        </a-collapse-panel>
        <a-collapse-panel key="4" header="¿Multi-moneda y tipo de cambio?">
          Sí, posición consolidada, reevaluación y diferencias de cambio automáticas.
        </a-collapse-panel>
      </a-collapse>
    </section>

    <!-- CTA final -->
    <section class="cta">
      <a-card class="cta-card" :hoverable="true">
        <a-row :gutter="[16,16]" align="middle">
          <a-col :xs="24" :md="18">
            <h3>Liquidez bajo control</h3>
            <p>Agenda una demo y recibe una plantilla de flujo de caja en Excel.</p>
          </a-col>
          <a-col :xs="24" :md="6" class="cta-actions">
            <a-button type="primary" size="large" block @click="contactar">Agendar demo</a-button>
            <a-button size="large" block @click="descargarPlantilla">Descargar plantilla</a-button>
          </a-col>
        </a-row>
      </a-card>
    </section>

    <!-- Drawer: Simulador de flujo -->
    <a-drawer v-model:open="simOpen" title="Simulador de flujo de caja (demo)" placement="right" width="420">
      <a-form layout="vertical">
        <a-form-item label="Saldo inicial (S/)">
          <a-input-number style="width:100%" :min="0" v-model:value="sim.saldo" />
        </a-form-item>
        <a-form-item label="Ingresos estimados (semana)">
          <a-input-number style="width:100%" :min="0" v-model:value="sim.ingresos" />
        </a-form-item>
        <a-form-item label="Egresos estimados (semana)">
          <a-input-number style="width:100%" :min="0" v-model:value="sim.egresos" />
        </a-form-item>
        <a-form-item label="Alm. de seguridad (%)">
          <a-input-number style="width:100%" :min="0" :max="100" v-model:value="sim.buffer" />
        </a-form-item>

        <a-result status="success" title="Resultado">
          <template #subTitle>
            <div class="sim-out">
              <div><strong>Flujo neto:</strong> S/ {{ flujoNeto }}</div>
              <div><strong>Saldo proyectado:</strong> S/ {{ saldoProyectado }}</div>
              <div><strong>Mínimo con buffer:</strong> S/ {{ minimoBuffer }}</div>
              <div><strong>Estado:</strong> <a-tag :color="saldoProyectado >= minimoBuffer ? 'green' : 'red'">
                {{ saldoProyectado >= minimoBuffer ? 'OK' : 'Riesgo' }}
              </a-tag></div>
            </div>
          </template>
        </a-result>

        <a-space style="width:100%" direction="vertical">
          <a-button type="primary" block @click="contactar">Quiero implementar Tesorería</a-button>
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

/* Estado UI */
const enfoque = ref('CxC')
const simOpen = ref(false)

/* Calendario de vencimientos (demo) */
const vencimientosSemana = ref([
  {
    fecha: '2025-08-12', fechaLabel: 'Mar 12',
    items: [
      { tipo: 'CxC', doc: 'FAC-001245', clienteProveedor: 'Cliente Andina', moneda: 'S/', monto: '8,450' },
      { tipo: 'CxP', doc: 'OC-00981', clienteProveedor: 'Proveedor Lima', moneda: 'S/', monto: '5,200' },
    ]
  },
  {
    fecha: '2025-08-13', fechaLabel: 'Mié 13',
    items: [
      { tipo: 'CxC', doc: 'FAC-001251', clienteProveedor: 'Retail Norte', moneda: 'S/', monto: '12,300' },
      { tipo: 'CxP', doc: 'FAC-P 773', clienteProveedor: 'Servicios SAC', moneda: 'US$', monto: '1,100' },
    ]
  },
  {
    fecha: '2025-08-14', fechaLabel: 'Jue 14',
    items: [
      { tipo: 'CxC', doc: 'FAC-001260', clienteProveedor: 'Farmacias Sur', moneda: 'S/', monto: '3,950' },
    ]
  },
])

/* Corrida de pagos (tabla) */
const corridaPagos = ref([
  { id: 1, proveedor: 'Proveedor Lima', doc: 'FAC-P 773', vence: '12/08', moneda: 'S/', importe: 5200, detraccion: true, estado: 'Pendiente' },
  { id: 2, proveedor: 'Servicios SAC', doc: 'FAC-P 774', vence: '13/08', moneda: 'US$', importe: 1100, detraccion: false, estado: 'Pendiente' },
  { id: 3, proveedor: 'Logística Andina', doc: 'FAC-P 775', vence: '14/08', moneda: 'S/', importe: 2800, detraccion: false, estado: 'Aprobado' },
  { id: 4, proveedor: 'Seguridad SRL', doc: 'FAC-P 776', vence: '15/08', moneda: 'S/', importe: 1500, detraccion: true, estado: 'Pendiente' },
])

const colsPagos = [
  { title: 'Proveedor', dataIndex: 'proveedor', key: 'proveedor' },
  { title: 'Documento', dataIndex: 'doc', key: 'doc' },
  { title: 'Vence', dataIndex: 'vence', key: 'vence' },
  { title: 'Moneda', dataIndex: 'moneda', key: 'moneda' },
  { title: 'Importe', dataIndex: 'importe', key: 'importe' },
  { title: 'Detracción', dataIndex: 'detraccion', key: 'detraccion',
    customRender: ({ text }) => text ? 'Sí' : 'No'
  },
  { title: 'Estado', dataIndex: 'estado', key: 'estado' },
]

/* Selección y totales */
const selectedRowKeys = ref([])
const onSelectPagos = (keys) => { selectedRowKeys.value = keys }
const totalPagar = computed(() => {
  const ids = new Set(selectedRowKeys.value)
  return corridaPagos.value
    .filter(r => ids.has(r.id))
    .reduce((acc, r) => acc + Number(r.importe || 0), 0)
    .toLocaleString('es-PE', { minimumFractionDigits: 2 })
})

/* Badges para estado de pago */
const estadoPagoBadge = {
  'Pendiente': 'processing',
  'Aprobado': 'success',
  'Observado': 'warning',
}

/* Simulador */
const sim = ref({ saldo: 150000, ingresos: 85000, egresos: 72000, buffer: 10 })
const flujoNeto = computed(() => (sim.value.ingresos - sim.value.egresos).toLocaleString('es-PE', { minimumFractionDigits: 2 }))
const saldoProyectado = computed(() => (sim.value.saldo + (sim.value.ingresos - sim.value.egresos)).toLocaleString('es-PE', { minimumFractionDigits: 2 }))
const minimoBuffer = computed(() => (sim.value.saldo * (sim.value.buffer / 100)).toLocaleString('es-PE', { minimumFractionDigits: 2 }))

/* Acciones */
const abrirSimulador = () => { simOpen.value = true }
const contactar = () => { window.location.href = '/contacto?modulo=tesoreria' }
const descargarPlantilla = () => { window.location.href = '/plantilla-flujo-caja.xlsx' }
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
.hero-cash{ background: linear-gradient(180deg, #ffffff, var(--bg-soft)); }
.hero-title{ font-size:40px; font-weight:800; margin:0 0 8px; color:var(--primary); }
.hero-subtitle{ font-size:18px; color:var(--muted); margin-bottom:12px; }
.hero-controls{ display:flex; gap:12px; align-items:center; flex-wrap:wrap; margin-top:8px; }
.bullets{ padding-left:16px; margin:8px 0 0; }
.bullets li{ margin:4px 0; color:var(--text); }
.hero-card{ position:relative; border:none; }
.hero-image{ width:100%; height:auto; display:block; }
.ribbon{
  position:absolute; top:12px; left:-8px; background:var(--primary); color:#fff;
  padding:6px 12px; font-size:12px; font-weight:700; border-radius:4px;
}

/* Liquidez */
.liquidity .kpi-block{
  display:grid; grid-template-columns: 1fr 1fr; gap:8px; margin-bottom:8px;
}
.bars .bar{ display:flex; align-items:center; gap:8px; }

/* Calendario */
.calendar-list{ list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:8px; }
.cal-text{ margin-left:6px; color:var(--text); }
.cal-monto{ float:right; }

/* Tabs */
.tabs{ background:#fff; }
.ul{ padding-left:16px; margin:0; }
.ul li{ margin:6px 0; }
.kpi-inline{ display:flex; gap:16px; flex-wrap:wrap; }

/* Footer corrida */
.run-footer{
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
