<template>
  <WebLayout>
    <Head title="PRISMA | App Móvil de Vendedores — Preventa y ruta con geolocalización" />

    <!-- HERO MOBILE-FIRST -->
    <section class="hero-mobile">
      <a-row :gutter="[24,24]" align="middle">
        <a-col :xs="24" :lg="12">
          <h1 class="hero-title">App de Vendedores PRISMA</h1>
          <p class="hero-subtitle">
            Visita, toma pedido, factura y cobra desde tu móvil, incluso <strong>sin internet</strong>.
            Geolocalización, catálogos, precios y promociones en tiempo real.
          </p>
          <div class="chips">
            <a-tag>Ruta & geocercas</a-tag>
            <a-tag>Precios por cliente</a-tag>
            <a-tag>Promos & combos</a-tag>
            <a-tag>Firma & foto</a-tag>
            <a-tag>POS móvil</a-tag>
          </div>
          <div class="cta">
            <a-button type="primary" size="large" @click="contactar">Solicitar demo</a-button>
            <a-button size="large" ghost @click="descargarFicha">Ficha técnica</a-button>
          </div>
        </a-col>

        <a-col :xs="24" :lg="12">
          <a-card :hoverable="true" class="phone-card" :bodyStyle="{padding:0}">
            <a-carousel autoplay>
              <div class="slide"><img src="/logo.png" alt="Home App Vendedor" /></div>
              <div class="slide"><img src="/logo.png" alt="Catálogo y precios" /></div>
              <div class="slide"><img src="/logo.png" alt="Ruta & mapa" /></div>
            </a-carousel>
            <div class="phone-bezel"></div>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- GRID DE VALOR DIFERENTE (ICONOS + COPIA BREVE) -->
    <section class="value-grid">
      <a-row :gutter="[16,16]">
        <a-col :xs="24" :md="8">
          <a-card :hoverable="true">
            <div class="icon-row"><img src="/logo.png" alt="Ruta" /><h3>Ruta inteligente</h3></div>
            <p>Plan de visitas con <strong>geocercas</strong>, ventanas horarias y comprobación en sitio.</p>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="8">
          <a-card :hoverable="true">
            <div class="icon-row"><img src="/logo.png" alt="Preventa" /><h3>Preventa & catálogo</h3></div>
            <p>Listas por cliente, combos, descuentos y bloqueo de stock desde el ERP.</p>
          </a-card>
        </a-col>
        <a-col :xs="24" :md="8">
          <a-card :hoverable="true">
            <div class="icon-row"><img src="/logo.png" alt="Cobranza" /><h3>Cobranza móvil</h3></div>
            <p>Recibos, notas y <strong>POS</strong> móvil; aplica moras y registra promesas de pago.</p>
          </a-card>
        </a-col>
      </a-row>
    </section>

    <!-- KPIs / OBJETIVOS DEL VENDEDOR -->
    <section class="kpis">
      <a-row :gutter="[16,16]" justify="center">
        <a-col :xs="12" :md="6" class="kpi">
          <a-statistic title="Cumplimiento de cuota" :value="86" suffix="%" />
        </a-col>
        <a-col :xs="12" :md="6" class="kpi">
          <a-statistic title="Ticket promedio" prefix="S/ " :value="178" />
        </a-col>
        <a-col :xs="12" :md="6" class="kpi">
          <a-statistic title="Visitas efectivas" :value="22" suffix="/día" />
        </a-col>
        <a-col :xs="12" :md="6" class="kpi">
          <a-statistic title="Cobranza" :value="92" suffix="%" />
        </a-col>
      </a-row>
    </section>

    <!-- TABS: Funciones clave -->
    <section class="tabs">
      <a-tabs default-active-key="visitas" size="large" centered>
        <a-tab-pane key="visitas" tab="Visitas & Ruta">
          <a-row :gutter="[16,16]">
            <a-col :xs="24" :md="12">
              <a-card :hoverable="true" title="Plan del día">
                <ul class="ul">
                  <li>Secuenciación automática por zona y prioridad</li>
                  <li>Check-in con GPS y fotos</li>
                  <li>Encuestas rápidas y NPS</li>
                </ul>
                <a-button type="primary" @click="abrirAgenda">Agendar nueva visita</a-button>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="12">
              <a-card :hoverable="true" title="Mapa & geocercas">
                <ul class="ul">
                  <li>Validación de visita en sitio</li>
                  <li>Alertas de no-visitado y reintentos</li>
                  <li>Rastreo de avance en tiempo real</li>
                </ul>
              </a-card>
            </a-col>
          </a-row>
        </a-tab-pane>

        <a-tab-pane key="pedido" tab="Pedido & Promos">
          <a-row :gutter="[16,16]">
            <a-col :xs="24" :md="12">
              <a-card :hoverable="true" title="Catálogo & precios">
                <ul class="ul">
                  <li>Precios por canal/cliente y vigencias</li>
                  <li>Promos: combos, 2x1, descuentos por volumen</li>
                  <li>Stock y sustitutos sugeridos</li>
                </ul>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="12">
              <a-card :hoverable="true" title="Documentos">
                <ul class="ul">
                  <li>Pedido → Guía → Factura/Boleta SUNAT</li>
                  <li>Firma, foto y envío por email/WhatsApp</li>
                  <li>Devoluciones y notas desde la app</li>
                </ul>
              </a-card>
            </a-col>
          </a-row>
        </a-tab-pane>

        <a-tab-pane key="offline" tab="Offline & Sincronización">
          <a-row :gutter="[16,16]">
            <a-col :xs="24" :md="12">
              <a-card :hoverable="true" title="Modo offline">
                <ul class="ul">
                  <li>Captura pedidos y cobros sin señal</li>
                  <li>Cola de sincronización inteligente</li>
                  <li>Conflictos y merge por último cambio</li>
                </ul>
              </a-card>
            </a-col>
            <a-col :xs="24" :md="12">
              <a-card :hoverable="true" title="Integraciones">
                <ul class="ul">
                  <li>ERP PRISMA (inventario, precios, crédito)</li>
                  <li>Geocoding/Maps y pasarelas de pago</li>
                  <li>Reporte de actividades al gerente</li>
                </ul>
              </a-card>
            </a-col>
          </a-row>
        </a-tab-pane>
      </a-tabs>
    </section>

    <!-- AGENDA DEL DÍA (tabla con estados) -->
    <section class="agenda">
      <h2 class="section-title">Agenda del día</h2>
      <a-table
        :data-source="agenda"
        :columns="colsAgenda"
        row-key="id"
        :pagination="{ pageSize: 6 }"
        size="middle"
      >
        <template #bodyCell="{ column, record }">
          <template v-if="column.dataIndex === 'estado'">
            <a-badge :status="estadoMap[record.estado] || 'default'" />
            <span style="margin-left:6px">{{ record.estado }}</span>
          </template>
        </template>
      </a-table>
    </section>

    <!-- CTA final sobria -->
    <section class="cta">
      <a-card class="cta-card" :hoverable="true">
        <a-row :gutter="[16,16]" align="middle">
          <a-col :xs="24" :md="18">
            <h3>Vende más en menos tiempo</h3>
            <p>Agenda una demo: rutas, pedidos, promociones y cobranza en una sola app.</p>
          </a-col>
          <a-col :xs="24" :md="6" class="cta-actions">
            <a-button type="primary" size="large" block @click="contactar">Agendar demo</a-button>
            <a-button size="large" block @click="descargarFicha">Ficha técnica</a-button>
          </a-col>
        </a-row>
      </a-card>
    </section>

    <!-- Drawer: Agendar visita -->
    <a-drawer v-model:open="drawerOpen" title="Agendar visita (demo)" placement="right" width="420">
      <a-form layout="vertical">
        <a-form-item label="Cliente">
          <a-input v-model:value="form.cliente" placeholder="Razón social / nombre" />
        </a-form-item>
        <a-form-item label="Dirección">
          <a-input v-model:value="form.direccion" placeholder="Ubicación" />
        </a-form-item>
        <a-form-item label="Fecha y hora">
          <a-date-picker v-model:value="form.fecha" style="width:100%" show-time />
        </a-form-item>
        <a-form-item label="Objetivo">
          <a-select v-model:value="form.objetivo" :options="optObjetivo" />
        </a-form-item>
        <a-space style="width:100%" direction="vertical">
          <a-button type="primary" block @click="contactar">Guardar y asignar</a-button>
          <a-button block @click="drawerOpen=false">Cerrar</a-button>
        </a-space>
      </a-form>
    </a-drawer>
  </WebLayout>
</template>

<script setup>
import WebLayout from '@/Layouts/WebLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'

/* Estado UI */
const drawerOpen = ref(false)
const form = ref({ cliente: '', direccion: '', fecha: null, objetivo: 'Visita de venta' })
const optObjetivo = [
  { label: 'Visita de venta', value: 'Visita de venta' },
  { label: 'Cobranza', value: 'Cobranza' },
  { label: 'Reposición / Merch', value: 'Reposición / Merch' },
]

/* Agenda demo */
const agenda = ref([
  { id: 1, hora: '09:00', cliente: 'Bodega San Pedro', zona: 'SJL', estado: 'Pendiente' },
  { id: 2, hora: '10:15', cliente: 'Farmacia Esperanza', zona: 'ATE', estado: 'En ruta' },
  { id: 3, hora: '12:00', cliente: 'Minimarket Surco', zona: 'SURCO', estado: 'Visitado' },
  { id: 4, hora: '15:30', cliente: 'Boutique Miraflores', zona: 'MIR', estado: 'Pendiente' },
  { id: 5, hora: '17:00', cliente: 'Rest. Don Pepe', zona: 'BARR', estado: 'Visitado' },
  { id: 6, hora: '18:30', cliente: 'Tienda La 21', zona: 'SMP', estado: 'En ruta' },
])

const colsAgenda = [
  { title: 'Hora', dataIndex: 'hora', key: 'hora' },
  { title: 'Cliente', dataIndex: 'cliente', key: 'cliente' },
  { title: 'Zona', dataIndex: 'zona', key: 'zona' },
  { title: 'Estado', dataIndex: 'estado', key: 'estado' },
]

const estadoMap = { 'Pendiente': 'processing', 'En ruta': 'warning', 'Visitado': 'success' }

/* Acciones CTA */
const contactar = () => { window.location.href = '/contacto?modulo=app-vendedores' }
const descargarFicha = () => { window.location.href = '/ficha-app-vendedores.pdf' }
const abrirAgenda = () => { drawerOpen.value = true }
</script>

<style scoped>
/* PALETA: AZUL (brand) + PLOMO (gris) */
:root{
  --brand-blue:#0a6aff; /* azul del acento */
  --brand-gray:#5b6470; /* plomo del logo */
  --bg-soft:#f4f6f9;
  --text:#1f2d3d;
}

/* Secciones */
section{ padding:64px 16px; }
.section-title{ text-align:center; font-size:26px; margin-bottom:16px; color:var(--text); }

/* HERO */
.hero-mobile{
  background: linear-gradient(180deg, #ffffff, var(--bg-soft));
}
.hero-title{
  font-size:40px; font-weight:800; margin:0 0 8px; color:var(--brand-blue);
}
.hero-subtitle{
  font-size:18px; color:var(--brand-gray); margin-bottom:12px;
}
.chips :deep(.ant-tag){
  border-color: var(--brand-blue); color: var(--brand-blue);
  margin-bottom:6px;
}
.cta{ display:flex; gap:12px; flex-wrap:wrap; margin-top:10px; }

/* Mockup phone */
.phone-card{ position:relative; border:none; background:#101418; border-radius:24px; overflow:hidden; }
.phone-bezel{
  position:absolute; inset:8px; border:2px solid #222a33; border-radius:20px; pointer-events:none;
}
.slide img{ width:100%; height:auto; display:block; }

/* Value grid */
.value-grid{ background:#fff; }
.icon-row{ display:flex; align-items:center; gap:10px; margin-bottom:6px; }
.icon-row img{ width:22px; height:22px; object-fit:contain; filter: grayscale(100%); opacity:.7; }
.icon-row h3{ margin:0; color:var(--text); }

/* KPIs */
.kpis{ background:#fff; text-align:center; }
.kpi :deep(.ant-statistic-title){ color:var(--brand-gray); }
.kpi :deep(.ant-statistic-content){ color:var(--text); font-weight:700; font-size:24px; }

/* Tabs */
.tabs{ background:#fff; }
.ul{ padding-left:16px; margin:0; }
.ul li{ margin:6px 0; color:#2a3340; }

/* Agenda */
.agenda{ background:#fff; }
:deep(.ant-table){ border-radius:10px; }

/* CTA */
.cta{ background: linear-gradient(180deg, var(--bg-soft), #ffffff); }
.cta-card{ border:1px solid #e3e8ef; }
.cta-actions{ display:flex; flex-direction:column; gap:8px; }

/* Responsive */
@media (max-width: 768px){
  .hero-title{ font-size:32px; }
  .hero-subtitle{ font-size:16px; }
}
</style>
