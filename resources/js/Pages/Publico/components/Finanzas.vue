<template>
  <section id="landing-finanzas">
    <Head title="PRISMA | Finanzas — Contabilidad & Planillas" />

    <!-- HERO -->
    <header class="hero">
      <div class="hero-wrap">
        <div class="hero-copy">
          <p class="pill">Suite Financiera PRISMA</p>
          <h1>
            Control total de <span class="accent">Finanzas</span><br />
            Contabilidad y Planillas integradas
          </h1>
          <p class="sub">
            Cierra mes en menos tiempo con asientos automáticos, PLE sin observaciones y
            planillas calculadas al milímetro. Todo conectado a tus módulos operativos.
          </p>
          <div class="hero-ctas">
            <a-button type="primary" size="large" @click="contactar">Solicitar demo</a-button>
            <a-button size="large" ghost @click="descargarBrochure">Brochure</a-button>
          </div>

          <div class="badges">
            <a-tag color="blue">PLE & Libros</a-tag>
            <a-tag color="green">Conciliación bancaria</a-tag>
            <a-tag color="purple">Centro de costos</a-tag>
            <a-tag color="gold">T-Registro/PLAME</a-tag>
          </div>
        </div>

        <a-card :hoverable="true" class="hero-card" :body-style="{ padding: 0 }" aria-label="Ilustración Finanzas PRISMA">
          <img src="/ERPDigital.png" alt="PRISMA Finanzas" class="hero-img" />
          <div class="ribbon">Cierre ágil y sin estrés</div>
        </a-card>
      </div>

      <div class="kpis">
        <a-row :gutter="[16,16]">
          <a-col :xs="12" :md="6">
            <a-card class="kpi" :bordered="false">
              <a-statistic title="Cierre contable" value="≤ 5 días" />
            </a-card>
          </a-col>
          <a-col :xs="12" :md="6">
            <a-card class="kpi" :bordered="false">
              <a-statistic title="Cumplimiento PLE" :value="100" suffix="%" />
            </a-card>
          </a-col>
          <a-col :xs="12" :md="6">
            <a-card class="kpi" :bordered="false">
              <a-statistic title="Ahorro en reprocesos" :value="30" suffix="%" />
            </a-card>
          </a-col>
          <a-col :xs="12" :md="6">
            <a-card class="kpi" :bordered="false">
              <a-statistic title="Integraciones bancarias" :value="20" suffix="+" />
            </a-card>
          </a-col>
        </a-row>
      </div>
    </header>

    <!-- MÓDULOS -->
    <section class="modules">
      <h2 class="title">Módulos de Finanzas</h2>
      <p class="subtitle">Activa Contabilidad y Planillas; conéctalos al resto del ERP.</p>

      <a-row :gutter="[16,16]">
        <a-col :xs="24" :md="12">
          <a-card class="mod" :hoverable="true">
            <template #title>
              <div class="mod-title">
                <div class="icon">📚</div>
                <span>Contabilidad</span>
              </div>
            </template>

            <ul class="ul">
              <li>Plan contable, asientos automáticos y plantillas.</li>
              <li>IGV, retenciones, detracciones y PLE (libros).</li>
              <li>Centro de costos y analítica por proyecto.</li>
              <li>Integración con Compras, Ventas y Tesorería.</li>
              <li>Estados financieros y notas configurables.</li>
            </ul>

            <a-space>
              <a-button type="primary" size="small" href="/modulos/contabilidad">Ver módulo</a-button>
              <a-button size="small" ghost @click="contactar">Cotizar</a-button>
            </a-space>
          </a-card>
        </a-col>

        <a-col :xs="24" :md="12">
          <a-card class="mod" :hoverable="true">
            <template #title>
              <div class="mod-title">
                <div class="icon">🧑‍💼</div>
                <span>Planillas</span>
              </div>
            </template>

            <ul class="ul">
              <li>Remuneraciones, horas extra, asignaciones y descuentos.</li>
              <li>T-Registro, PLAME, CTS, gratificaciones y vacaciones.</li>
              <li>AFP/ONP, quinta categoría y boletas digitales.</li>
              <li>Asiento contable automático y centros de costo.</li>
              <li>Exportación bancaria (TXT/CSV) y portal colaborador.</li>
            </ul>

            <a-space>
              <a-button type="primary" size="small" href="/modulos/planillas">Ver módulo</a-button>
              <a-button size="small" ghost @click="contactar">Cotizar</a-button>
            </a-space>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- FLUJO -->
    <section class="flow">
      <h2 class="title">Flujo financiero integrado</h2>
      <a-steps :current="3" responsive>
        <a-step title="Operaciones" description="Compras/Ventas/Almacén" />
        <a-step title="Tesorería" description="CxC • CxP • Conciliación" />
        <a-step title="Contabilidad" description="Asientos, IGV, PLE" />
        <a-step title="Planillas" description="Cálculo, PLAME, asientos" />
        <a-step title="Reportes" description="EEFF, costos, ratios" />
      </a-steps>
    </section>

    <!-- COBERTURA -->
    <section class="value">
      <a-row :gutter="[16,16]">
        <a-col :xs="24" :md="12">
          <a-card :hoverable="true" title="Beneficios clave">
            <ul class="ul">
              <li>Cierre de mes rápido con validaciones automáticas.</li>
              <li>Menos errores: trazabilidad desde el documento origen.</li>
              <li>Plantillas para asientos recurrentes y periodificaciones.</li>
              <li>Planillas con reglas locales y liquidaciones sin dolor.</li>
              <li>Dashboards financieros y analítica por centros de costo.</li>
            </ul>
          </a-card>
        </a-col>

        <a-col :xs="24" :md="12">
          <a-card :hoverable="true" title="Cobertura por proceso">
            <a-table
              :data-source="comparativa"
              :columns="colsComparativa"
              row-key="key"
              :pagination="false"
              size="small"
              class="comp-table"
            >
              <template #bodyCell="{ column, record }">
                <template v-if="checksCols.includes(column.dataIndex)">
                  <a-badge :status="record[column.dataIndex] ? 'success' : 'default'" />
                </template>
                <template v-else>
                  <span>{{ record[column.dataIndex] }}</span>
                </template>
              </template>
            </a-table>
            <small class="note">* Integrado con módulos operativos, bancarios y SUNAT.</small>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- FAQ -->
    <section class="faq">
      <h2 class="title">Preguntas frecuentes</h2>
      <a-collapse accordion ghost>
        <a-collapse-panel key="1" header="¿Puedo usar solo Contabilidad o solo Planillas?">
          Sí. Son módulos independientes que puedes activar por separado y luego integrar al resto del ERP.
        </a-collapse-panel>
        <a-collapse-panel key="2" header="¿Generan los formatos PLE y PLAME?">
          Sí. Contabilidad genera PLE de libros y Planillas genera PLAME/T-Registro y asientos automáticos.
        </a-collapse-panel>
        <a-collapse-panel key="3" header="¿Cómo hacen la conciliación bancaria?">
          Importamos extractos (TXT/CSV) y conciliamos contra movimientos de Tesorería con reglas configurables.
        </a-collapse-panel>
        <a-collapse-panel key="4" header="¿Soportan centros de costo y proyectos?">
          Sí, con distribución automática desde origen y reportes por dimensión.
        </a-collapse-panel>
      </a-collapse>
    </section>

    <!-- CTA FINAL -->
    <section class="final-cta">
      <a-card class="cta-card" :hoverable="true">
        <a-row :gutter="[16,16]" align="middle">
          <a-col :xs="24" :md="18">
            <h3>Finanzas bajo control</h3>
            <p>Agenda una demo y te mostramos el cierre desde los documentos fuente.</p>
          </a-col>
          <a-col :xs="24" :md="6" class="cta-actions">
            <a-button type="primary" size="large" block @click="contactar">Agendar demo</a-button>
            <a-button size="large" block @click="descargarBrochure">Brochure</a-button>
          </a-col>
        </a-row>
      </a-card>
    </section>
  </section>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'

/** Comparativa por proceso (1=cubre) */
const comparativa = ref([
  { key:'conta',     proceso:'Contabilidad',   contabilidad:1, planillas:0, tesoreria:1, conciliacion:1, ple:1, plame:0 },
  { key:'planillas', proceso:'Planillas',      contabilidad:1, planillas:1, tesoreria:1, conciliacion:0, ple:0, plame:1 },
  { key:'reportes',  proceso:'Reportes/CC',    contabilidad:1, planillas:1, tesoreria:1, conciliacion:1, ple:1, plame:1 },
])

const colsComparativa = [
  { title:'Proceso',       dataIndex:'proceso',       key:'proceso' },
  { title:'Contabilidad',  dataIndex:'contabilidad',  key:'contabilidad' },
  { title:'Planillas',     dataIndex:'planillas',     key:'planillas' },
  { title:'Tesorería',     dataIndex:'tesoreria',     key:'tesoreria' },
  { title:'Conciliación',  dataIndex:'conciliacion',  key:'conciliacion' },
  { title:'PLE',           dataIndex:'ple',           key:'ple' },
  { title:'PLAME',         dataIndex:'plame',         key:'plame' },
]
const checksCols = ['contabilidad','planillas','tesoreria','conciliacion','ple','plame']

/** CTAs */
const contactar = () => { window.location.href = '/contacto?modulo=finanzas' }
const descargarBrochure = () => { window.location.href = '/brochure-finanzas.pdf' }
</script>

<style scoped>
:root{
  --primary:#00a0c8;
  --ink:#0f172a;
  --muted:#5c6773;
  --bg:#f6f9fc;
  --card:#ffffff;
  --ring:rgba(0,160,200,.15);
}

#landing-finanzas{ background: #fff; }

/* HERO */
.hero{
  padding: 64px 16px 24px;
  background:
    radial-gradient(1200px 400px at 10% -10%, var(--ring), transparent 60%),
    linear-gradient(180deg, #ffffff, var(--bg));
}
.hero-wrap{
  display:grid; gap:24px; align-items:center; grid-template-columns: 1fr;
}
@media (min-width: 992px){
  .hero-wrap{ grid-template-columns: 1.2fr .8fr; }
}
.pill{
  display:inline-block; font-size:12px; font-weight:700; letter-spacing:.5px;
  padding:6px 10px; border-radius:999px; background:#eaf6fb; color:#096c86; margin-bottom:10px;
}
.hero h1{
  font-size: clamp(28px, 4.2vw, 44px);
  line-height: 1.1; margin: 0 0 10px; color: var(--ink);
}
.accent{ color: var(--primary); }
.sub{ color: var(--muted); font-size: 16px; max-width: 640px; }
.hero-ctas{ display:flex; gap:12px; flex-wrap:wrap; margin: 14px 0; }
.badges{ display:flex; gap:8px; flex-wrap:wrap; }

.hero-card{ position:relative; border:none; background: transparent; box-shadow: 0 10px 30px rgba(15,23,42,.06); }
.hero-img{ width:100%; height:auto; display:block; border-radius:14px; }
.ribbon{
  position:absolute; top:12px; left:-8px;
  background:var(--primary); color:#fff; padding:6px 12px;
  font-size:12px; font-weight:700; border-radius:6px;
}

.kpis{ margin-top: 18px; }
.kpi{ background:var(--card); border-radius:14px; box-shadow: 0 4px 16px rgba(15,23,42,.06); }

/* MÓDULOS */
.modules{ padding: 56px 16px; background:#fff; }
.title{ text-align:center; font-size:28px; color: var(--ink); margin-bottom: 6px; }
.subtitle{ text-align:center; color: var(--muted); margin-bottom: 18px; }
.mod{
  height:100%; border:1px solid #e7edf3; border-radius:14px;
  transition: transform .15s ease, box-shadow .15s ease;
}
.mod:hover{ transform: translateY(-3px); box-shadow: 0 14px 28px rgba(15,23,42,.08); }
.mod-title{ display:flex; align-items:center; gap:10px; font-weight:800; color:#1f2937; }
.icon{
  width:38px; height:38px; display:grid; place-items:center; border-radius:10px;
  background:#f1fbff; font-size:18px;
}
.ul{ padding-left:16px; margin:0 0 10px; }
.ul li{ margin:6px 0; color:#2a3340; }

/* FLOW */
.flow{ padding: 40px 16px; background:#fff; }

/* VALUE */
.value{ padding: 40px 16px; background: var(--bg); }
.comp-table :deep(.ant-table){ border-radius:10px; }
.note{ display:block; margin-top:8px; color:#74808d; }

/* FAQ */
.faq{ padding: 40px 16px; background:#fff; }

/* CTA FINAL */
.final-cta{
  padding: 48px 16px 72px;
  background: linear-gradient(180deg, var(--bg), #ffffff);
}
.cta-card{ border:1px solid #eaf0f5; border-radius:16px; }
.cta-actions{ display:flex; flex-direction:column; gap:8px; }

/* Accesibilidad / focus */
:focus-visible{ outline: 3px solid var(--ring); outline-offset: 2px; }
</style>
