<template>
  <WebLayout>
    <Head title="ERP PRISMA | Planillas — Nómina electrónica, T-Registro y PLAME" />

    <!-- HERO con estilo editorial -->
    <section class="hero-payroll">
      <a-row :gutter="[24,24]" align="middle">
        <a-col :xs="24" :lg="14">
          <h1 class="hero-title">Planillas PRISMA</h1>
          <p class="hero-subtitle">
            Calcula sueldos, horas extra, beneficios y aportes en minutos.
            Genera archivos para <strong>T-Registro</strong>, <strong>PLAME</strong>, <strong>AFPnet</strong> y <strong>PDT</strong>,
            con boleta electrónica y portal del colaborador.
          </p>

          <div class="hero-controls">
            <span>Periodicidad:</span>
            <a-segmented v-model:value="periodicidad" :options="['Mensual','Quincenal','Semanal']" size="large" />
            <a-space>
              <a-button type="primary" size="large" @click="irContacto">Solicitar demo</a-button>
              <a-button size="large" ghost @click="abrirSimuladorCosto">Simular costo laboral</a-button>
            </a-space>
          </div>

          <div class="hero-badges">
            <a-tag color="blue">Boleta electrónica</a-tag>
            <a-tag color="green">T-Registro / PLAME</a-tag>
            <a-tag color="purple">AFPnet / ONP</a-tag>
          </div>
        </a-col>

        <a-col :xs="24" :lg="10">
          <a-card :hoverable="true" class="hero-card" :bodyStyle="{padding:0}">
            <img src="/logo.png" class="hero-image" alt="Panel de Planillas PRISMA" />
            <div class="ribbon">Cálculo en 1 clic</div>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- TARJETAS DE CICLO (diferente a otros módulos) -->
    <section class="cycle-cards">
      <a-row :gutter="[16,16]">
        <a-col :xs="24" :md="8">
          <a-card :hoverable="true" title="Altas & Datos laborales">
            <ul class="ul">
              <li>Alta en T-Registro y legajo digital</li>
              <li>Asignación de régimen y categoría</li>
              <li>Centro de costo y proyecto</li>
              <li>Variables de planilla (HE, bonos, descuentos)</li>
            </ul>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="8">
          <a-card :hoverable="true" title="Cálculo & Validación">
            <ul class="ul">
              <li>Remuneración, HE, feriados y nocturnidad</li>
              <li>ESSALUD, ONP/AFP, Vida Ley y SCTR</li>
              <li>Inasistencias, tardanzas y licencias</li>
              <li>Alertas de tope y validaciones SUNAT</li>
            </ul>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="8">
          <a-card :hoverable="true" title="Pago & Reportes">
            <ul class="ul">
              <li>Boleta electrónica (portal del colaborador)</li>
              <li>Archivos bancarios (TXT/CSV)</li>
              <li>PLAME y AFPnet listos para envío</li>
              <li>Asientos automáticos a Contabilidad</li>
            </ul>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- TIMELINE LEGAL (CTS, Gratificación, Impuestos) -->
    <section class="timeline-legal">
      <h2 class="section-title">Calendario legal</h2>
      <a-timeline>
        <a-timeline-item color="green">Gratificación — Julio y Diciembre</a-timeline-item>
        <a-timeline-item color="gold">CTS — Mayo y Noviembre</a-timeline-item>
        <a-timeline-item color="blue">PLAME — Declaración mensual</a-timeline-item>
        <a-timeline-item color="purple">AFPnet/ONP — Aportes mensuales</a-timeline-item>
        <a-timeline-item color="red">Impuesto a la renta 5ta — Retenciones y regularización</a-timeline-item>
      </a-timeline>
    </section>

    <!-- TABLERO DE CUMPLIMIENTO -->
    <section class="compliance">
      <a-row :gutter="[16,16]">
        <a-col :xs="24" :md="6">
          <a-card :hoverable="true">
            <a-statistic title="Planillas procesadas (mes)" :value="3" />
            <a-progress :percent="88" status="active" />
            <small>Procesos cerrados según periodicidad {{ periodicidad.toLowerCase() }}</small>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="6">
          <a-card :hoverable="true">
            <a-statistic title="T-Registro" :value="100" suffix="%" />
            <small>Altas y bajas al día</small>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="6">
          <a-card :hoverable="true">
            <a-statistic title="PLAME" :value="98" suffix="%" />
            <small>Validado sin errores</small>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="6">
          <a-card :hoverable="true">
            <a-statistic title="AFPnet/ONP" :value="95" suffix="%" />
            <small>Aportes conciliados</small>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- PROXIMOS PAGOS / OBLIGACIONES -->
    <section class="payments">
      <h2 class="section-title">Próximos pagos y obligaciones</h2>
      <a-table
        :data-source="pagos"
        :columns="colsPagos"
        row-key="id"
        :pagination="{ pageSize: 5 }"
        size="middle"
      >
        <template #bodyCell="{ column, record }">
          <template v-if="column.dataIndex === 'estado'">
            <a-badge :status="estadoBadge[record.estado] || 'default'" />
            <span style="margin-left:6px">{{ record.estado }}</span>
          </template>
          <template v-else-if="column.dataIndex === 'monto'">
            S/ {{ Number(record.monto).toLocaleString('es-PE', { minimumFractionDigits: 2 }) }}
          </template>
        </template>
      </a-table>
      <div class="payments-actions">
        <a-space>
          <a-button type="primary" @click="exportarArchivoBanco">Generar archivo bancario</a-button>
          <a-button @click="descargarCalendario">Calendario anual</a-button>
        </a-space>
      </div>
    </section>

    <!-- TABS ESPECÍFICOS: Beneficios / Asistencia / Integraciones -->
    <section class="tabs-specific">
      <a-tabs default-active-key="beneficios" size="large">
        <a-tab-pane key="beneficios" tab="Beneficios">
          <a-row :gutter="[16,16]">
            <a-col :xs="24" :md="8">
              <a-card title="Vacaciones" :hoverable="true">
                <ul class="ul"><li>Bolsas y programación</li><li>Pago, fraccionamiento y pendientes</li><li>Integración con asistencia</li></ul>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="8">
              <a-card title="Gratificaciones & Bonos" :hoverable="true">
                <ul class="ul"><li>Grati legal y bonificación extraordinaria</li><li>Reglas por régimen y periodos computables</li></ul>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="8">
              <a-card title="CTS" :hoverable="true">
                <ul class="ul"><li>Cálculo, bancarización y constancias</li><li>Tope legal y proporcionalidad</li></ul>
              </a-card>
            </a-col>
          </a-row>
        </a-tab-pane>

        <a-tab-pane key="asistencia" tab="Asistencia & Novedades">
          <a-row :gutter="[16,16]">
            <a-col :xs="24" :md="12">
              <a-card title="Asistencia" :hoverable="true">
                <ul class="ul"><li>Biométrico / App móvil</li><li>Horario flexible, turnos y nocturnidad</li><li>Tardanzas y HE auto-calculadas</li></ul>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="12">
              <a-card title="Novedades" :hoverable="true">
                <ul class="ul"><li>Licencias, subsidios, préstamos y adelantos</li><li>Descuentos judiciales</li><li>Glosas y adjuntos</li></ul>
              </a-card>
            </a-col>
          </a-row>
        </a-tab-pane>

        <a-tab-pane key="integraciones" tab="Integraciones">
          <a-row :gutter="[16,16]" align="middle">
            <a-col :xs="24" :md="12">
              <a-card title="Contabilidad & Bancos" :hoverable="true">
                <ul class="ul"><li>Asientos automáticos (62x, 4011, 4111)</li><li>Archivos bancarios por entidad</li><li>Centro de costo y proyecto</li></ul>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="12">
              <a-card :hoverable="true">
                <img src="/logo.png" alt="Integraciones PRISMA" class="integrations-image" />
              </a-card>
            </a-col>
          </a-row>
        </a-tab-pane>
      </a-tabs>
    </section>

    <!-- CTA final -->
    <section class="cta">
      <a-card class="cta-card" :hoverable="true">
        <a-row :gutter="[16,16]" align="middle">
          <a-col :xs="24" :md="18">
            <h3>Planillas sin estrés y 100% cumplidas</h3>
            <p>Agenda una demo y descarga nuestra guía práctica de PLAME y T-Registro.</p>
          </a-col>
          <a-col :xs="24" :md="6" class="cta-actions">
            <a-button type="primary" size="large" block @click="irContacto">Agendar demo</a-button>
            <a-button size="large" block @click="descargarGuia">Descargar guía</a-button>
          </a-col>
        </a-row>
      </a-card>
    </section>

    <!-- Drawer: Simulador de costo laboral -->
    <a-drawer v-model:open="simOpen" title="Simulador de costo laboral (demo)" placement="right" width="420">
      <a-form layout="vertical">
        <a-form-item label="Sueldo bruto (S/)">
          <a-input-number style="width:100%" :min="0" v-model:value="sim.sueldo" />
        </a-form-item>
        <a-form-item label="AFP (aporte %)">
          <a-input-number style="width:100%" :min="0" :max="20" v-model:value="sim.afp" />
        </a-form-item>
        <a-form-item label="ESSALUD (%)">
          <a-input-number style="width:100%" :min="0" :max="20" v-model:value="sim.essalud" />
        </a-form-item>
        <a-form-item label="Asignación familiar (S/)">
          <a-input-number style="width:100%" :min="0" v-model:value="sim.asigFam" />
        </a-form-item>
        <a-result status="success" title="Resultado estimado">
          <template #subTitle>
            <div class="sim-out">
              <div><strong>Neto a pagar:</strong> S/ {{ netoPagar }}</div>
              <div><strong>Costo empleador:</strong> S/ {{ costoEmpleador }}</div>
              <div><strong>Descuentos:</strong> S/ {{ descuentos }}</div>
            </div>
          </template>
        </a-result>
        <a-space style="width:100%" direction="vertical">
          <a-button type="primary" block @click="irContacto">Quiero implementar Planillas</a-button>
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
const periodicidad = ref('Mensual')
const simOpen = ref(false)

/* Próximos pagos (demo) */
const pagos = ref([
  { id: 1, concepto: 'Planilla Mensual', vence: '28/08/2025', entidad: 'BBVA', monto: 185000, estado: 'Pendiente' },
  { id: 2, concepto: 'AFPnet', vence: '15/08/2025', entidad: 'AFP Integra', monto: 28500, estado: 'Aprobado' },
  { id: 3, concepto: 'PLAME', vence: '16/08/2025', entidad: 'SUNAT', monto: 41200, estado: 'Pendiente' },
  { id: 4, concepto: 'CTS', vence: '15/11/2025', entidad: 'BCP', monto: 92000, estado: 'Programado' },
  { id: 5, concepto: 'ONP', vence: '15/08/2025', entidad: 'ONP', monto: 11800, estado: 'Pendiente' },
])

const colsPagos = [
  { title: 'Concepto', dataIndex: 'concepto', key: 'concepto' },
  { title: 'Vence', dataIndex: 'vence', key: 'vence' },
  { title: 'Entidad', dataIndex: 'entidad', key: 'entidad' },
  { title: 'Monto', dataIndex: 'monto', key: 'monto' },
  { title: 'Estado', dataIndex: 'estado', key: 'estado' },
]

const estadoBadge = { 'Pendiente':'processing', 'Aprobado':'success', 'Programado':'default' }

/* Simulador costo laboral */
const sim = ref({ sueldo: 2500, afp: 12.5, essalud: 9, asigFam: 102.5 })
const descuentos = computed(() => (sim.value.sueldo * (sim.value.afp / 100)).toLocaleString('es-PE', { minimumFractionDigits: 2 }))
const netoPagar = computed(() => (sim.value.sueldo - (sim.value.sueldo * (sim.value.afp / 100)) + sim.value.asigFam).toLocaleString('es-PE', { minimumFractionDigits: 2 }))
const costoEmpleador = computed(() => (sim.value.sueldo + (sim.value.sueldo * (sim.value.essalud / 100)) + sim.value.asigFam).toLocaleString('es-PE', { minimumFractionDigits: 2 }))

/* Acciones */
const abrirSimuladorCosto = () => { simOpen.value = true }
const irContacto = () => { window.location.href = '/contacto?modulo=planillas' }
const exportarArchivoBanco = () => { window.location.href = '/export/pagos-planilla.txt' }
const descargarCalendario = () => { window.location.href = '/calendario-laboral.pdf' }
const descargarGuia = () => { window.location.href = '/guia-plame-tregistro.pdf' }
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
.hero-payroll{ background: linear-gradient(180deg, #ffffff, var(--bg-soft)); }
.hero-title{ font-size:40px; font-weight:800; margin:0 0 8px; color:var(--primary); }
.hero-subtitle{ font-size:18px; color:var(--muted); margin-bottom:12px; }
.hero-controls{ display:flex; gap:12px; align-items:center; flex-wrap:wrap; margin-top:8px; }
.hero-badges{ display:flex; gap:8px; flex-wrap:wrap; margin-top:8px; }
.hero-card{ position:relative; border:none; }
.hero-image{ width:100%; height:auto; display:block; }
.ribbon{
  position:absolute; top:12px; left:-8px; background:var(--primary); color:#fff;
  padding:6px 12px; font-size:12px; font-weight:700; border-radius:4px;
}

/* Ciclo */
.cycle-cards{ background:#fff; }
.ul{ padding-left:16px; margin:0; }
.ul li{ margin:6px 0; }

/* Timeline legal */
.timeline-legal{ background:#fff; }

/* Cumplimiento */
.compliance{ background:var(--bg-soft); }

/* Pagos */
.payments{ background:#fff; }
.payments-actions{ margin-top:12px; display:flex; justify-content:flex-end; }

/* Tabs específicos */
.tabs-specific{ background:#fff; }
.integrations-image{ width:100%; height:auto; display:block; }

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
