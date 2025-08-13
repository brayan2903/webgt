<template>
  <section id="landing-apps">
    <Head title="PRISMA | Aplicativos Móviles — Ventas, Reparto, Almacén y Gestión" />

    <!-- HERO -->
    <header class="hero">
      <div class="hero-wrap">
        <div class="hero-copy">
          <p class="pill">Suite de Apps Móviles</p>
          <h1>
            Productividad en campo, <span class="accent">en tiempo real</span>
          </h1>
          <p class="sub">
            Apps para <b>Vendedores, Repartidores, Almaceneros, Gerentes y Supervisores</b>. Offline básico, GPS,
            fotos/firma y sincronización directa con el ERP.
          </p>
          <div class="hero-ctas">
            <a-button type="primary" size="large" @click="contactar">Solicitar demo</a-button>
            <a-button size="large" ghost @click="descargarBrochure">Ver brochure</a-button>
          </div>

          <div class="badges">
            <a-tag color="green">Android / iOS</a-tag>
            <a-tag color="blue">Modo Offline</a-tag>
            <a-tag color="purple">GPS & Geocercas</a-tag>
            <a-tag color="gold">Fotos • Firma • POD</a-tag>
          </div>
        </div>

        <a-card :hoverable="true" class="hero-card" :body-style="{ padding: 0 }" aria-label="Apps móviles PRISMA">
          <img src="/ERPDigital.png" alt="Aplicativos Móviles PRISMA" class="hero-img" />
          <div class="ribbon">Operación en tu bolsillo</div>
        </a-card>
      </div>

      <div class="kpis">
        <a-row :gutter="[16,16]">
          <a-col :xs="12" :md="6">
            <a-card class="kpi" :bordered="false">
              <a-statistic title="Visitas efectivas" :value="2" suffix="x" />
            </a-card>
          </a-col>
          <a-col :xs="12" :md="6">
            <a-card class="kpi" :bordered="false">
              <a-statistic title="Tiempo de reparto" :value="25" suffix="%" />
            </a-card>
          </a-col>
          <a-col :xs="12" :md="6">
            <a-card class="kpi" :bordered="false">
              <a-statistic title="Inventario preciso" :value="99.5" suffix="%" />
            </a-card>
          </a-col>
          <a-col :xs="12" :md="6">
            <a-card class="kpi" :bordered="false">
              <a-statistic title="Alertas en tiempo real" :value="1" suffix="min" />
            </a-card>
          </a-col>
        </a-row>
      </div>
    </header>

    <!-- ROLES / APPS -->
    <section class="modules">
      <h2 class="title">Aplicativos por rol</h2>
      <p class="subtitle">Diseñados para cada equipo, sincronizados con el ERP.</p>

      <a-row :gutter="[16,16]">
        <a-col v-for="m in roles" :key="m.key" :xs="24" :sm="12" :lg="8">
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

            <div class="chips">
              <span v-for="(t,i) in m.tags" :key="i" class="chip">{{ t }}</span>
            </div>

            <a-space>
              <a-button type="primary" size="small" :href="m.href">Ver detalles</a-button>
              <a-button size="small" ghost @click="contactar">Quiero esta app</a-button>
            </a-space>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- FLUJO -->
    <section class="flow">
      <h2 class="title">Flujo en campo y backoffice</h2>
      <a-steps :current="5" responsive>
        <a-step title="Planificar" description="Rutas, cuotas y precios" />
        <a-step title="Visitar" description="Check-in GPS • agenda" />
        <a-step title="Vender / Preparar" description="Pedido • picking • FE" />
        <a-step title="Entregar / POD" description="Firma • foto • geolocalización" />
        <a-step title="Cobrar" description="QR • POS • efectivo • contraentrega" />
        <a-step title="Reportar" description="KPIs, incidencias y auditoría" />
      </a-steps>
    </section>

    <!-- DIFERENCIALES -->
    <section class="value">
      <a-row :gutter="[16,16]">
        <a-col :xs="24" :md="12">
          <a-card :hoverable="true" title="Ventajas de la suite móvil">
            <ul class="ul">
              <li>Sincronización fiable con reintentos y cola offline.</li>
              <li>Control geográfico: zonas, cercos y validación de visita.</li>
              <li>Plantillas por canal y listas de precios por segmentación.</li>
              <li>POD completo: firma, evidencias fotográficas y timestamp.</li>
              <li>Alertas push: stock bajo, morosidad, desvíos de ruta.</li>
            </ul>
          </a-card>
        </a-col>

        <a-col :xs="24" :md="12">
          <a-card :hoverable="true" title="Seguridad y administración">
            <ul class="ul">
              <li>SSO/roles y permisos por menú, acción y dataset.</li>
              <li>Cifrado en tránsito y almacenamiento local seguro.</li>
              <li>Políticas MDM: bloqueo remoto y borrado selectivo.</li>
              <li>Bitácora de auditoría y trazabilidad completa.</li>
              <li>API para integraciones con terceros.</li>
            </ul>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- FAQ -->
    <section class="faq">
      <h2 class="title">Preguntas frecuentes</h2>
      <a-collapse accordion ghost>
        <a-collapse-panel key="1" header="¿Funciona offline?">
          Sí. Las apps operan con caché local y sincronizan cuando hay conexión; se incluye control de conflictos.
        </a-collapse-panel>
        <a-collapse-panel key="2" header="¿Puedo limitar zonas/rutas por usuario?">
          Sí. Asignas territorios, rutas y clientes por rol, con validación por GPS y geocercas.
        </a-collapse-panel>
        <a-collapse-panel key="3" header="¿Cómo se integra con la facturación?">
          El pedido puede disparar FE (SUNAT) y la app captura el POD; todo sincroniza con ventas y tesorería.
        </a-collapse-panel>
        <a-collapse-panel key="4" header="¿Qué dispositivos soportan?">
          Android e iOS modernos. Opcional: lectores de código y printers Bluetooth (según modelo).
        </a-collapse-panel>
      </a-collapse>
    </section>

    <!-- CTA FINAL -->
    <section class="final-cta">
      <a-card class="cta-card" :hoverable="true">
        <a-row :gutter="[16,16]" align="middle">
          <a-col :xs="24" :md="18">
            <h3>Impulsa tu operación con Apps Móviles</h3>
            <p>Agenda una demo y prueba los flujos con tus datos y territorios.</p>
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

const roles = [
  {
    key:'vendedores',
    title:'Vendedores',
    icon:'🧑‍💼',
    bullets:[
      'Agenda y check-in GPS', 'Pedido con listas de precio y promos',
      'Catálogo, fotos y stocks en vivo', 'FE y cobro en ruta (QR/POS)'
    ],
    tags:['Visitas','Cuotas','Pedidos','Cobro'],
    href:'/apps/vendedores'
  },
  {
    key:'repartidores',
    title:'Repartidores',
    icon:'🚚',
    bullets:[
      'Rutas optimizadas', 'POD con firma/foto', 'Contraentrega y devoluciones',
      'Incidencias y reintentos'
    ],
    tags:['Rutas','POD','Contraentrega','Incidencias'],
    href:'/apps/repartidores'
  },
  {
    key:'almaceneros',
    title:'Almaceneros',
    icon:'🏷️',
    bullets:[
      'Recepción y conteo ciego', 'Picking/packing con código de barras',
      'Ubicaciones, lotes/series', 'Transferencias y ajustes'
    ],
    tags:['Picking','Lotes','Series','Ubicaciones'],
    href:'/apps/almaceneros'
  },
  {
    key:'gerentes',
    title:'Gerentes',
    icon:'📈',
    bullets:[
      'Dashboard móvil de KPIs', 'Alertas de margen, quiebres y OTD',
      'Ranking de vendedores y productos', 'Aprobaciones en un toque'
    ],
    tags:['KPIs','Alertas','Aprobaciones','Ranking'],
    href:'/apps/gerentes'
  },
  {
    key:'supervisor',
    title:'Supervisor',
    icon:'🛰️',
    bullets:[
      'Monitoreo GPS y geocercas', 'Auditoría de visita y foto-evidencia',
      'Reasignación de rutas', 'Checklist de estándares'
    ],
    tags:['GPS','Auditoría','Rutas','Checklist'],
    href:'/apps/supervisor'
  },
]

/** CTAs */
const contactar = () => { window.location.href = '/contacto?modulo=apps-moviles' }
const descargarBrochure = () => { window.location.href = '/brochure-apps-moviles.pdf' }
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

#landing-apps{ background: #fff; }

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

/* KPIs */
.kpis{ margin-top: 18px; }
.kpi{ background:var(--card); border-radius:14px; box-shadow: 0 4px 16px rgba(15,23,42,.06); }

/* ROLES */
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
.chips{ display:flex; gap:6px; flex-wrap:wrap; margin-bottom:10px; }
.chip{
  font-size: 12px; padding: 4px 8px; border-radius: 999px;
  background: #eef7fb; color: #0e7490; border: 1px solid #d8eef7;
}

/* FLOW */
.flow{ padding: 40px 16px; background:#fff; }

/* VALUE */
.value{ padding: 40px 16px; background: var(--bg); }

/* FAQ */
.faq{ padding: 40px 16px; background:#fff; }

/* CTA FINAL */
.final-cta{
  padding: 48px 16px 72px;
  background: linear-gradient(180deg, var(--bg), #ffffff);
}
.cta-card{ border:1px solid #eaf0f5; border-radius:16px; }
.cta-actions{ display:flex; flex-direction:column; gap:8px; }

/* Accesibilidad */
:focus-visible{ outline: 3px solid var(--ring); outline-offset: 2px; }
</style>
