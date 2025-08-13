<template>
  <WebLayout>
    <Head title="ERP PRISMA | Módulo de Ventas — Cierra más y factura sin fricción" />

    <!-- HERO: enfoque comercial con segmented -->
    <section class="hero-sales">
      <a-row :gutter="[24,24]" align="middle">
        <a-col :xs="24" :lg="14">
          <h1 class="hero-title">Ventas PRISMA</h1>
          <p class="hero-subtitle">
            Convierte oportunidades en ingresos: cotiza, negocia, toma pedidos y
            <strong>factura electrónicamente (SUNAT)</strong> en segundos.
            Integrado con inventario, precios, comisiones y cobranza.
          </p>

          <div class="view-toggle">
            <span>Modo:</span>
            <a-segmented
              :options="['B2B','B2C','POS']"
              v-model:value="mode"
              size="large"
            />
          </div>

          <ul class="hero-bullets">
            <li v-if="mode==='B2B'">CRM ligero: oportunidades, etapas, probabilidad y forecast.</li>
            <li v-if="mode==='B2B'">Listas de precios por cliente, acuerdos y crédito.</li>

            <li v-if="mode==='B2C'">Carrito omnicanal con promos, cupones y lealtad.</li>
            <li v-if="mode==='B2C'">Sincroniza stock online y tiempos de entrega.</li>

            <li v-if="mode==='POS'">POS táctil, lectura de códigos, offline/online.</li>
            <li v-if="mode==='POS'">Cajas, arqueos y medios de pago múltiples.</li>
          </ul>

          <div class="hero-cta">
            <a-button type="primary" size="large" @click="contactar">Solicitar demo</a-button>
            <a-button size="large" ghost @click="descargarBrochure">Brochure (PDF)</a-button>
          </div>

          <div class="hero-trust">
            <a-tag color="blue">SUNAT e-Factura/Boleta</a-tag>
            <a-tag color="green">Omnicanal</a-tag>
            <a-tag color="purple">API eCommerce</a-tag>
          </div>
        </a-col>

        <a-col :xs="24" :lg="10">
          <a-card :hoverable="true" class="hero-card" :bodyStyle="{ padding: 0 }">
            <a-carousel autoplay dot-position="bottom">
              <div class="slide"><img src="/logo.png" alt="Embudo de ventas" /></div>
              <div class="slide"><img src="/logo.png" alt="Cotización y pedido" /></div>
              <div class="slide"><img src="/logo.png" alt="POS táctil" /></div>
            </a-carousel>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- PIPELINE / EMBUDO DIFERENTE -->
    <section class="pipeline">
      <h2 class="section-title">Embudo de ventas y forecast</h2>
      <a-row :gutter="[16,16]">
        <a-col v-for="col in pipeline" :key="col.title" :xs="24" :md="6">
          <a-card :hoverable="true" class="stage-card">
            <template #title>
              <div class="stage-title">
                <img :src="col.icon" alt="icon" />
                <span>{{ col.title }}</span>
              </div>
            </template>
            <a-statistic :title="col.subtitle" :value="col.value" />
            <ul class="ul-simple">
              <li v-for="(p,i) in col.points" :key="i">{{ p }}</li>
            </ul>
          </a-card>
        </a-col>
      </a-row>
      <div class="forecast">
        <a-statistic title="Forecast del mes" :value="950000" :precision="0" prefix="S/ " />
        <a-progress :percent="78" status="active" />
        <small>Basado en probabilidad por etapa y pipeline actual.</small>
      </div>
    </section>

    <!-- BLOQUE ECOMMERCE + FACTURACIÓN -->
    <section class="integrations">
      <a-row :gutter="[16,16]" align="middle">
        <a-col :xs="24" :md="12">
          <a-card :hoverable="true" title="eCommerce & Omnicanal">
            <ul class="ul-simple">
              <li>Conector a tiendas online y marketplaces.</li>
              <li>Precios, catálogo y stock sincronizados.</li>
              <li>Carritos abandonados y cupones.</li>
              <li>Click & collect y despacho programado.</li>
            </ul>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="12">
          <a-card :hoverable="true" title="Facturación Electrónica SUNAT">
            <ul class="ul-simple">
              <li>Boleta, Factura, Nota de crédito/débito.</li>
              <li>Envío automático a SUNAT y al cliente.</li>
              <li>IGV, detracciones y percepciones.</li>
              <li>Integración con Cuentas por Cobrar.</li>
            </ul>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- PROMOS, LISTAS Y COMISIONES: otro ángulo -->
    <section class="promo-commission">
      <a-row :gutter="[16,16]">
        <a-col :xs="24" :md="12">
          <a-card :hoverable="true" title="Promociones y precios">
            <a-descriptions bordered size="small" :column="1">
              <a-descriptions-item label="Listas de precios">Por cliente/segmento/canal</a-descriptions-item>
              <a-descriptions-item label="Promos">2x1, bundles, cupones, happy hour</a-descriptions-item>
              <a-descriptions-item label="Reglas">
                Prioridades, vigencias y exclusiones
              </a-descriptions-item>
              <a-descriptions-item label="Descuentos">
                Por volumen, pronto pago y mix
              </a-descriptions-item>
            </a-descriptions>
          </a-card>
        </a-col>

        <a-col :xs="24" :md="12">
          <a-card :hoverable="true" title="Comisiones y metas">
            <ul class="ul-simple">
              <li>Planes por vendedor, producto o margen.</li>
              <li>Metas mensuales y trimestrales con alertas.</li>
              <li>Liquidación automática según cobranza real.</li>
              <li>Panel de desempeño en tiempo real.</li>
            </ul>
            <div class="kpi-inline">
              <a-statistic title="Cumplimiento del equipo" :value="92" suffix="%" />
              <a-statistic title="Ticket promedio" prefix="S/ " :value="185" />
            </div>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- CÓMO SE VENDE (flujo compacto distinto) -->
    <section class="flow">
      <h2 class="section-title">Del lead al documento</h2>
      <a-steps size="small" :current="6" :responsive="true">
        <a-step title="Lead" description="Captura web/APP/importación" />
        <a-step title="Oportunidad" description="Etapas, probabilidad, tareas" />
        <a-step title="Cotización" description="Precios, impuestos y vigencias" />
        <a-step title="Pedido" description="Reserva stock y condiciones" />
        <a-step title="Entrega" description="Guía y logística integrada" />
        <a-step title="Factura" description="SUNAT, envío y cobranza" />
      </a-steps>
    </section>

    <!-- FAQ -->
    <section class="faq">
      <h2 class="section-title">Preguntas frecuentes</h2>
      <a-collapse accordion>
        <a-collapse-panel key="1" header="¿Puedo manejar listas de precios por cliente y canal?">
          Sí, define múltiples listas con reglas por segmento, canal y vigencia; se aplican automáticamente.
        </a-collapse-panel>
        <a-collapse-panel key="2" header="¿Se integra con inventario para reservar stock?">
          Totalmente. Los pedidos bloquean stock y los despachos actualizan el Kardex en tiempo real.
        </a-collapse-panel>
        <a-collapse-panel key="3" header="¿Cómo funciona la facturación electrónica?">
          Generas el documento desde el pedido/entrega; se envía a SUNAT y al cliente de inmediato.
        </a-collapse-panel>
        <a-collapse-panel key="4" header="¿El POS funciona sin internet?">
          Sí, modo offline con sincronización al recuperar conexión.
        </a-collapse-panel>
      </a-collapse>
    </section>

    <!-- CTA FINAL con Drawer de contacto rápido -->
    <section class="cta-final">
      <a-card class="cta-card" :hoverable="true">
        <a-row :gutter="[16,16]" align="middle">
          <a-col :xs="24" :md="18">
            <h3>Cierra más ventas con PRISMA</h3>
            <p>Te mostramos cotizaciones, pedidos, POS y e-Factura en una demo guiada.</p>
          </a-col>
          <a-col :xs="24" :md="6" class="cta-actions">
            <a-button type="primary" size="large" block @click="contactar">Agendar demo</a-button>
            <a-button size="large" block @click="abrirContacto">Contacto rápido</a-button>
          </a-col>
        </a-row>
      </a-card>
    </section>

    <!-- Drawer de contacto -->
    <a-drawer v-model:open="drawerOpen" title="Hablar con ventas" placement="right" width="420">
      <a-form layout="vertical">
        <a-form-item label="Nombre">
          <a-input placeholder="Tu nombre" />
        </a-form-item>
        <a-form-item label="Teléfono">
          <a-input placeholder="+51 ..." />
        </a-form-item>
        <a-form-item label="Correo">
          <a-input placeholder="tucorreo@empresa.com" />
        </a-form-item>
        <a-form-item label="Mensaje">
          <a-textarea rows="3" placeholder="Cuéntanos sobre tu operación de ventas" />
        </a-form-item>
        <a-space style="width:100%" direction="vertical">
          <a-button type="primary" block @click="contactar">Enviar y agendar demo</a-button>
          <a-button block @click="hablarVentas">Llamar ahora</a-button>
        </a-space>
      </a-form>
    </a-drawer>
  </WebLayout>
</template>

<script setup>
import WebLayout from '@/Layouts/WebLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'

const mode = ref('B2B')
const drawerOpen = ref(false)

const pipeline = [
  { title: 'Prospección', subtitle: 'Leads activos', value: 320, icon: '/logo.png',
    points: ['Captura web/API', 'Asignación a vendedor', 'Campañas'] },
  { title: 'Oportunidades', subtitle: 'En negociación', value: 140, icon: '/logo.png',
    points: ['Etapas & probabilidad', 'Tareas/recordatorios', 'Documentos adjuntos'] },
  { title: 'Cotizaciones', subtitle: 'Vigentes', value: 95, icon: '/logo.png',
    points: ['Listas y descuentos', 'Validez y condiciones', 'Aprobación'] },
  { title: 'Pedidos', subtitle: 'Para facturar', value: 78, icon: '/logo.png',
    points: ['Reserva de stock', 'Entrega/Guía', 'Factura SUNAT'] },
]

const contactar = () => {
  window.location.href = '/contacto?modulo=ventas'
}
const descargarBrochure = () => {
  window.location.href = '/brochure-ventas.pdf'
}
const hablarVentas = () => {
  window.location.href = 'tel:+51010000000' // reemplazar
}
const abrirContacto = () => {
  drawerOpen.value = true
}
</script>

<style scoped>
:root{
  --primary:#00a0c8;
  --bg:#ffffff;
  --bg-soft:#f7fbfd;
  --text:#1f2d3d;
  --muted:#5c6773;
}

section{ padding:64px 16px; }
.section-title{ text-align:center; font-size:28px; margin-bottom:16px; color:var(--text); }

/* HERO sales */
.hero-sales{
  background: linear-gradient(180deg, #ffffff, var(--bg-soft));
}
.hero-title{ font-size:40px; font-weight:800; margin:0 0 8px; color:var(--primary); }
.hero-subtitle{ font-size:18px; color:var(--muted); margin-bottom:12px; }
.view-toggle{ display:flex; align-items:center; gap:8px; margin:8px 0 12px; }
.hero-bullets{ padding-left:16px; margin:0 0 12px; }
.hero-bullets li{ margin:6px 0; color:var(--text); }
.hero-cta{ display:flex; gap:12px; flex-wrap:wrap; }
.hero-trust{ display:flex; gap:8px; flex-wrap:wrap; margin-top:8px; }
.hero-card{ border:none; }
.slide img{ width:100%; height:auto; display:block; }

/* Pipeline */
.pipeline{ background:#fff; }
.stage-card .stage-title{ display:flex; align-items:center; gap:8px; }
.stage-card .stage-title img{ width:20px; height:20px; object-fit:contain; }
.ul-simple{ padding-left:16px; margin:8px 0 0; }
.ul-simple li{ margin:4px 0; }
.forecast{
  margin-top:12px; text-align:center;
}
.forecast small{ color:var(--muted); }

/* Integrations */
.integrations{ background: var(--bg-soft); }

/* Promos & Comisiones */
.promo-commission{ background:#fff; }
.kpi-inline{ display:flex; gap:16px; margin-top:12px; flex-wrap:wrap; }

/* Flow */
.flow{ background:#fff; }

/* FAQ */
.faq{ background: var(--bg-soft); }

/* CTA final */
.cta-final{ background: linear-gradient(180deg, var(--bg-soft), #ffffff); }
.cta-card{ border:1px solid #eaf4f8; }
.cta-actions{ display:flex; flex-direction:column; gap:8px; }

/* Responsive */
@media (max-width: 768px){
  .hero-title{ font-size:32px; }
  .hero-subtitle{ font-size:16px; }
}
</style>
