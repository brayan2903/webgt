<template>
  <section id="landing-gc">
    <Head title="PRISMA | Gestión Comercial — Bienvenido" />

    <!-- HERO -->
    <header class="hero">
      <div class="hero-wrap">
        <div class="hero-copy">
          <p class="pill">Nuevo · Suite Comercial Integrada</p>
          <h1>
            Gestiona tu <span class="accent">ciclo comercial</span><br />
            del pedido al cobro
          </h1>
          <p class="sub">
            PRISMA unifica compras, almacén, ventas, distribución y tesorería en tiempo real,
            con facturación electrónica SUNAT y apps móviles por rol.
          </p>
          <div class="hero-ctas">
            <a-button type="primary" size="large" @click="contactar">Solicitar demo</a-button>
            <a-button size="large" ghost @click="descargarBrochure">Ver brochure</a-button>
          </div>

          <div class="badges">
            <a-tag color="blue">F.E. SUNAT</a-tag>
            <a-tag color="green">Stock en vivo</a-tag>
            <a-tag color="purple">Rutas & POD</a-tag>
            <a-tag color="gold">CxC / CxP</a-tag>
          </div>
        </div>

        <a-card :hoverable="true" class="hero-card" :body-style="{ padding: 0 }" aria-label="Ilustración Gestión Comercial">
          <img src="/ERPDigital.png" alt="PRISMA Gestión Comercial" class="hero-img" />
          <div class="ribbon">Bienvenido a PRISMA</div>
        </a-card>
      </div>

      <div class="kpis">
        <a-row :gutter="[16,16]">
          <a-col :xs="12" :md="6">
            <a-card class="kpi" :bordered="false">
              <a-statistic title="Ahorro en reprocesos" :value="27" suffix="%" />
            </a-card>
          </a-col>
          <a-col :xs="12" :md="6">
            <a-card class="kpi" :bordered="false">
              <a-statistic title="OTD promedio" :value="96" suffix="%" />
            </a-card>
          </a-col>
          <a-col :xs="12" :md="6">
            <a-card class="kpi" :bordered="false">
              <a-statistic title="Cierre contable" value="≤ 5 días" />
            </a-card>
          </a-col>
          <a-col :xs="12" :md="6">
            <a-card class="kpi" :bordered="false">
              <a-statistic title="Implementaciones" :value="120" suffix="+" />
            </a-card>
          </a-col>
        </a-row>
      </div>
    </header>

    <!-- STRIP LOGOS -->
    <section class="logos">
      <div class="logos-wrap">
        <img src="/logo.png" alt="Cliente 1" />
        <img src="/logo.png" alt="Cliente 2" />
        <img src="/logo.png" alt="Cliente 3" />
        <img src="/logo.png" alt="Cliente 4" />
        <img src="/logo.png" alt="Cliente 5" />
      </div>
    </section>

    <!-- MÓDULOS -->
    <section class="modules">
      <h2 class="title">Módulos que aceleran tu operación</h2>
      <p class="subtitle">Activa solo lo que necesitas. Todo integrado.</p>

      <a-row :gutter="[16,16]">
        <a-col v-for="m in modulos" :key="m.key" :xs="24" :sm="12" :lg="8">
          <a-card class="mod" :hoverable="true">
            <template #title>
              <div class="mod-title">
                <div class="icon">{{ m.icon }}</div>
                <span>{{ m.title }}</span>
              </div>
            </template>

            <ul class="ul">
              <li v-for="(b,i) in m.bullets" :key="i">{{ b }}</li>
            </ul>

            <a-space>
              <a-button type="primary" size="small" :href="m.href">Ver módulo</a-button>
              <a-button size="small" ghost @click="contactar">Cotizar</a-button>
            </a-space>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- FLUJO -->
    <section class="flow">
      <h2 class="title">Flujo integrado de punta a punta</h2>
      <a-steps :current="5" responsive>
        <a-step title="Compras" description="OC, recepción, costos" />
        <a-step title="Almacén" description="Ubicaciones, lotes/series" />
        <a-step title="Ventas" description="Pedidos, precios y promos" />
        <a-step title="Distribución" description="Rutas, POD, contraentrega" />
        <a-step title="Tesorería" description="CxC/CxP, flujo de caja" />
        <a-step title="Contabilidad" description="Asientos, IGV, PLE" />
      </a-steps>
    </section>

    <!-- VALOR DIFERENCIAL -->
    <section class="value">
      <a-row :gutter="[16,16]">
        <a-col :xs="24" :md="12">
          <a-card :hoverable="true" title="¿Por qué PRISMA?">
            <ul class="ul">
              <li>Arquitectura modular para crecer sin fricción.</li>
              <li>Tiempo real: stock, precios, márgenes y cobranza.</li>
              <li>Automatiza guías, FE SUNAT, PLE y conciliaciones.</li>
              <li>Apps móviles por rol: ventas, reparto, almacén.</li>
              <li>API para ecommerce, pasarelas y contabilidad.</li>
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
            <small class="note">* Integrado con Facturación Electrónica SUNAT.</small>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- TESTIMONIOS -->
    <section class="testimonials">
      <h2 class="title">Empresas que confían</h2>
      <a-row :gutter="[16,16]">
        <a-col :xs="24" :md="8">
          <a-card :hoverable="true" class="quote-card">
            <p class="quote">“Reducimos 27% el costo por entrega y el OTD subió a 96%.”</p>
            <small>Operaciones — Retail Lima</small>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="8">
          <a-card :hoverable="true" class="quote-card">
            <p class="quote">“Cierre contable en 5 días, PLE sin observaciones.”</p>
            <small>Finanzas — Alimentos</small>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="8">
          <a-card :hoverable="true" class="quote-card">
            <p class="quote">“Los vendedores duplicaron visitas efectivas con la app.”</p>
            <small>Comercial — Consumo Masivo</small>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- FAQ -->
    <section class="faq">
      <h2 class="title">Preguntas frecuentes</h2>
      <a-collapse accordion ghost>
        <a-collapse-panel key="1" header="¿Puedo empezar solo con ventas y sumar módulos luego?">
          Sí. La suite es modular. Puedes activar compras, almacén o tesorería cuando tu operación lo requiera.
        </a-collapse-panel>
        <a-collapse-panel key="2" header="¿La facturación está homologada con SUNAT?">
          Sí, soportamos Factura, Boleta, NC/ND, Guías y PLE. Integración con OSE/SEE según tu esquema.
        </a-collapse-panel>
        <a-collapse-panel key="3" header="¿Ofrecen apps móviles?">
          Sí, para vendedores, repartidores (POD) y almacén (picking/ingresos). Funcionalidad offline básica.
        </a-collapse-panel>
        <a-collapse-panel key="4" header="¿Cómo migran mis datos?">
          Te damos plantillas (clientes, SKUs, precios, saldos) y acompañamos el corte con ambiente de pruebas.
        </a-collapse-panel>
      </a-collapse>
    </section>

    <!-- CTA FINAL -->
    <section class="final-cta">
      <a-card class="cta-card" :hoverable="true">
        <a-row :gutter="[16,16]" align="middle">
          <a-col :xs="24" :md="18">
            <h3>Activa tu Gestión Comercial completa</h3>
            <p>Agenda una demo y te mostramos el flujo completo con tus datos.</p>
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

/** Módulos destacados */
const modulos = [
  { key:'compras',      title:'Compras',       icon:'🧾', bullets:['OC & proveedores','Costos y detracciones','Recepción & calidad'], href:'/modulos/compras' },
  { key:'almacen',      title:'Almacén',       icon:'📦', bullets:['Stock en tiempo real','Ubicaciones • lotes/series','Movimientos y valorización'], href:'/modulos/almacen' },
  { key:'ventas',       title:'Ventas',        icon:'🛒', bullets:['Pedidos • listas de precio','Promos & canales','Facturación SUNAT'], href:'/modulos/ventas' },
  { key:'distribucion', title:'Distribución',  icon:'🚚', bullets:['Ruteo y secuencia','POD (firma/foto/GPS)','Contraentrega'], href:'/modulos/distribucion' },
  { key:'tesoreria',    title:'Tesorería',     icon:'💳', bullets:['CxC / CxP','Flujo de caja','Conciliación bancaria'], href:'/modulos/tesoreria' },
  { key:'produccion',   title:'Producción',    icon:'🏭', bullets:['Órdenes & BOM','Consumos y mermas','OEE y costos'], href:'/modulos/produccion' },
]

/** Comparativa por proceso (1=cubre) */
const comparativa = ref([
  { key:'compras', proceso:'Compras',      compras:1, almacen:1, ventas:0, distribucion:0, tesoreria:1, produccion:0 },
  { key:'almacen', proceso:'Almacén',      compras:1, almacen:1, ventas:1, distribucion:1, tesoreria:0, produccion:1 },
  { key:'ventas',  proceso:'Ventas',       compras:0, almacen:1, ventas:1, distribucion:1, tesoreria:1, produccion:0 },
  { key:'distrib', proceso:'Distribución', compras:0, almacen:1, ventas:1, distribucion:1, tesoreria:1, produccion:0 },
  { key:'teso',    proceso:'Tesorería',    compras:1, almacen:0, ventas:1, distribucion:1, tesoreria:1, produccion:0 },
  { key:'prod',    proceso:'Producción',   compras:1, almacen:1, ventas:0, distribucion:0, tesoreria:0, produccion:1 },
])

const colsComparativa = [
  { title:'Proceso',      dataIndex:'proceso',      key:'proceso' },
  { title:'Compras',      dataIndex:'compras',      key:'compras' },
  { title:'Almacén',      dataIndex:'almacen',      key:'almacen' },
  { title:'Ventas',       dataIndex:'ventas',       key:'ventas' },
  { title:'Distribución', dataIndex:'distribucion', key:'distribucion' },
  { title:'Tesorería',    dataIndex:'tesoreria',    key:'tesoreria' },
  { title:'Producción',   dataIndex:'produccion',   key:'produccion' },
]

const checksCols = ['compras','almacen','ventas','distribucion','tesoreria','produccion']

/** CTAs */
const contactar = () => { window.location.href = '/contacto?modulo=gestion-comercial' }
const descargarBrochure = () => { window.location.href = '/brochure-gestion-comercial.pdf' }
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

#landing-gc{ background: #fff; }

/* HERO */
.hero{
  padding: 64px 16px 24px;
  background:
    radial-gradient(1200px 400px at 10% -10%, var(--ring), transparent 60%),
    linear-gradient(180deg, #ffffff, var(--bg));
}
.hero-wrap{
  display:grid; gap:24px; align-items:center;
  grid-template-columns: 1fr;
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

/* STRIP LOGOS */
.logos{ padding: 28px 0 8px; background: #fff; }
.logos-wrap{
  display:flex; gap:24px; flex-wrap:wrap; justify-content:center; align-items:center;
}
.logos-wrap img{ height:28px; opacity:.65; filter: grayscale(100%); transition: opacity .2s; }
.logos-wrap img:hover{ opacity: 1; }

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

/* TESTIMONIOS */
.testimonials{ padding: 40px 16px; background:#fff; }
.quote-card{ border:1px solid #eaf0f5; }
.quote{ font-style:italic; color:#2a3340; margin: 0 0 6px; }

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
