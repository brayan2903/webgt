<template>
  <!-- DESKTOP: MegaMenu con rutas reales -->
  <a-dropdown
    trigger="click"
    placement="bottom"
    :overlayStyle="{ width: '800px', padding: '20px', borderRadius: '16px' }"
    overlayClassName="mega-overlay"
    :getPopupContainer="getContainer"
    class="mega-trigger"
    @visibleChange="handleVisibleChange"
    :visible="isVisible"
  >
    <!-- Trigger modificado -->
    <span
      class="nav-link pointer-cursor"
      :class="{ active: active || isVisible }"
      @click="toggleDropdown"
      aria-haspopup="true"
      :aria-expanded="isVisible"
    >
      <span class="nav-text">Módulos</span>
      <i class="ri-arrow-down-s-line" :class="{ 'rotate-icon': isVisible }"></i>
    </span>

    <template #overlay>
      <div class="mega" role="menu" aria-orientation="vertical">
        <a-row :gutter="[24, 16]">
          <!-- Gestión Comercial -->
          <a-col :xs="24" :sm="12" :lg="8" class="mega-col">
            <div class="mega-title">
              <i class="ri-store-2-line"></i>
              Gestión Comercial
            </div>
            <ul class="mega-list">
              <li v-for="(item, index) in comercial" :key="index">
                <Link
                  :href="route(comercialRoutes[index])"
                  class="mega-link"
                  role="menuitem"
                  @click="closeAll"
                >
                  <span>{{ item }}</span>
                  <i class="ri-arrow-right-line"></i>
                </Link>
              </li>
            </ul>
          </a-col>

          <!-- Finanzas -->
          <a-col :xs="24" :sm="12" :lg="8" class="mega-col">
            <div class="mega-title">
              <i class="ri-money-dollar-circle-line"></i>
              Finanzas
            </div>
            <ul class="mega-list">
              <li v-for="(item, index) in finanzas" :key="index">
                <Link
                  :href="route(finanzasRoutes[index])"
                  class="mega-link"
                  role="menuitem"
                  @click="closeAll"
                >
                  <span>{{ item }}</span>
                  <i class="ri-arrow-right-line"></i>
                </Link>
              </li>
            </ul>
          </a-col>

          <!-- Aplicativos Móviles -->
          <a-col :xs="24" :sm="12" :lg="8" class="mega-col">
            <div class="mega-title">
              <i class="ri-smartphone-line"></i>
              Aplicativos Móviles
            </div>
            <ul class="mega-list">
              <li v-for="(item, index) in moviles" :key="index">
                <Link
                  :href="route(movilesRoutes[index])"
                  class="mega-link"
                  role="menuitem"
                  @click="closeAll"
                >
                  <span>{{ item }}</span>
                  <i class="ri-arrow-right-line"></i>
                </Link>
              </li>
            </ul>
          </a-col>
        </a-row>

        <div class="mega-footer">
          <a-space>
            <a-tag color="blue">
              <i class="ri-flashlight-line"></i>
              Nuevo
            </a-tag>
            <small>
              ERP de facturación electrónica para Perú — integra SUNAT, controla inventario y automatiza tus operaciones.
            </small>
          </a-space>
        </div>
      </div>
    </template>
  </a-dropdown>

  <!-- MÓVIL: Drawer con rutas reales -->
  <a-drawer
    :open="open"
    placement="top"
    :height="'auto'"
    :headerStyle="{ border: 'none' }"
    :bodyStyle="{ padding: '20px' }"
    :closable="true"
    @close="closeDrawer"
    class="mega-drawer"
  >
    <template #title>
      <div class="drawer-header">
        <i class="ri-apps-2-line"></i>
        <span>Módulos del Sistema</span>
      </div>
    </template>

    <div class="drawer-content">
      <a-collapse accordion :bordered="false">
        <!-- Gestión Comercial -->
        <a-collapse-panel key="1" class="collapse-panel">
          <template #header>
            <div class="panel-header">
              <i class="ri-store-2-line"></i>
              <span>Gestión Comercial</span>
            </div>
          </template>
          <div class="panel-links">
            <Link
              v-for="(item, index) in comercial"
              :key="index"
              :href="route(comercialRoutes[index])"
              class="panel-link"
              @click="closeAll"
            >
              {{ item }}
            </Link>
          </div>
        </a-collapse-panel>

        <!-- Finanzas -->
        <a-collapse-panel key="2" class="collapse-panel">
          <template #header>
            <div class="panel-header">
              <i class="ri-money-dollar-circle-line"></i>
              <span>Finanzas</span>
            </div>
          </template>
          <div class="panel-links">
            <Link
              v-for="(item, index) in finanzas"
              :key="index"
              :href="route(finanzasRoutes[index])"
              class="panel-link"
              @click="closeAll"
            >
              {{ item }}
            </Link>
          </div>
        </a-collapse-panel>

        <!-- Aplicativos Móviles -->
        <a-collapse-panel key="3" class="collapse-panel">
          <template #header>
            <div class="panel-header">
              <i class="ri-smartphone-line"></i>
              <span>Aplicativos Móviles</span>
            </div>
          </template>
          <div class="panel-links">
            <Link
              v-for="(item, index) in moviles"
              :key="index"
              :href="route(movilesRoutes[index])"
              class="panel-link"
              @click="closeAll"
            >
              {{ item }}
            </Link>
          </div>
        </a-collapse-panel>
      </a-collapse>
    </div>
  </a-drawer>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

const props = defineProps({
  open: { type: Boolean, default: false },
  active: { type: Boolean, default: false },
})

const emit = defineEmits(['update:open', 'update:active'])

const isVisible = ref(false)

// Textos para los menús
const comercial = ['Almacén', 'Compras', 'Producción', 'Ventas', 'Distribución', 'Tesorería']
const finanzas = ['Contabilidad', 'Planillas']
const moviles = ['Vendedores', 'Repartidores', 'Almaceneros', 'Gerentes', 'Supervisor']

// Rutas correspondientes a cada item
const comercialRoutes = [
  'modulos.almacen',
  'modulos.compras',
  'modulos.produccion',
  'modulos.ventas',
  'modulos.distribucion',
  'modulos.tesoreria'
]

const finanzasRoutes = [
  'modulos.contabilidad',
  'modulos.planillas'
]

const movilesRoutes = [
  'modulos.vendedores',
  'modulos.repartidores',
  'modulos.almaceneros',
  'modulos.gerentes',
  'modulos.supervisor'
]

const getContainer = (trigger) => trigger?.closest('.header') ?? document.body

const toggleDropdown = () => {
  isVisible.value = !isVisible.value
  emit('update:active', isVisible.value)
}

const handleVisibleChange = (visible) => {
  isVisible.value = visible
  emit('update:active', visible)
}

const closeDrawer = () => {
  emit('update:open', false)
}

const closeAll = () => {
  isVisible.value = false
  emit('update:open', false)
  emit('update:active', false)
}

watch(() => props.open, (newVal) => {
  if (!newVal) {
    isVisible.value = false
  }
})

watch(() => props.active, (newVal) => {
  isVisible.value = newVal
})
</script>

<style scoped>
/* Mega Menu Desktop */
.mega {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

/* Agrega esta nueva clase */
.pointer-cursor {
  cursor: pointer;
}

.mega-title {
  display: flex;
  align-items: center;
  gap: 8px;
  font-weight: 700;
  color: #545c70;
  margin: 6px 0 12px;
  font-size: 1rem;
  padding-bottom: 6px;
  border-bottom: 1px solid #f0f0f0;
}

.mega-title i {
  font-size: 1.1rem;
  color: var(--primary-color);
}

.mega-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.mega-link {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 12px;
  font-size: 0.95rem;
  color: var(--text-color);
  text-decoration: none;
  border-radius: 8px;
  transition: all 0.2s ease;
  margin-bottom: 4px;
}

.mega-link:hover {
  background: var(--light-bg);
  color: var(--primary-color);
  transform: translateX(5px);
}

.mega-link i {
  opacity: 0;
  transition: all 0.2s ease;
  color: var(--primary-color);
}

.mega-link:hover i {
  opacity: 1;
}

.mega-col {
  min-height: 180px;
  padding: 0 8px;
}

.mega-footer {
  margin-top: 16px;
  border-top: 1px solid #f0f0f0;
  padding-top: 12px;
  color: #667;
  font-size: 0.85rem;
}

.mega-overlay .ant-dropdown-menu {
  box-shadow: none;
  padding: 0;
}

/* Animación del icono */
.rotate-icon {
  transform: rotate(180deg);
  transition: transform 0.2s ease;
}

/* Mega Menu Mobile (Drawer) */
.mega-drawer :deep(.ant-drawer-header) {
  padding: 20px;
}

.mega-drawer :deep(.ant-drawer-body) {
  padding: 0;
}

.drawer-header {
  display: flex;
  align-items: center;
  gap: 10px;
  font-weight: 600;
  font-size: 1.1rem;
}

.drawer-header i {
  font-size: 1.2rem;
  color: var(--primary-color);
}

.collapse-panel :deep(.ant-collapse-header) {
  padding: 16px 20px !important;
  background: rgba(0, 147, 196, 0.05);
  border-radius: 0 !important;
}

.collapse-panel :deep(.ant-collapse-content-box) {
  padding: 0 !important;
}

.panel-header {
  display: flex;
  align-items: center;
  gap: 10px;
  font-weight: 500;
}

.panel-header i {
  color: var(--primary-color);
}

.panel-links {
  display: flex;
  flex-direction: column;
  padding: 0 20px 12px 44px;
}

.panel-link {
  padding: 10px 0;
  color: var(--text-color);
  text-decoration: none;
  transition: all 0.2s ease;
  border-bottom: 1px solid #f0f0f0;
}

.panel-link:hover {
  color: var(--primary-color);
  padding-left: 8px;
}

.panel-link:last-child {
  border-bottom: none;
}

.nav-link {
  position: relative;
}

.nav-link.active {
  color: var(--primary-color);
}

.nav-link.active::after {
  content: '';
  position: absolute;
  bottom: -2px;
  left: 1rem;
  right: 1rem;
  height: 2px;
  background: var(--primary-color);
}
</style>
