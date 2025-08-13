<template>
  <header class="header">
    <div class="container">
      <!-- Logo -->
      <div class="logo">
        <Link :href="route('inicio')" @click="closeMenu">
          <img src="/logo.png" alt="Globaltech Logo" />
        </Link>
      </div>

      <!-- Hamburguesa (móvil) -->
      <button
        class="hamburger"
        :class="{ 'is-active': menuVisible }"
        :aria-expanded="menuVisible.toString()"
        aria-controls="main-nav"
        :aria-label="menuVisible ? 'Cerrar menú' : 'Abrir menú'"
        @click="toggleMenu"
      >
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
      </button>

      <!-- Navegación -->
      <nav
        id="main-nav"
        :class="['menu', { 'menu-mobile': true, 'menu-open': menuVisible }]"
        aria-label="Navegación principal"
      >
        <!-- Desktop: Módulos (dropdown) -->
        <div class="hide-on-mobile">
          <MegaMenu
            v-model:open="drawerOpen"
            :active="activeItem === 'modulos' || $page.component.startsWith('Publico/Modulos')"
            @update:active="setActive('modulos')"
          />
        </div>

        <!-- Móvil: botón que abre el drawer del mega-menú -->
        <a-button
          v-if="isMobile"
          class="show-on-mobile nav-link"
          type="text"
          @click="drawerOpen = true; setActive('modulos')"
        >
          Módulos
        </a-button>

        <!-- Otros enlaces -->
        <Link
          :href="route('facturacion')"
          class="nav-link"
          :class="{ active: activeItem === 'facturacion' || $page.component === 'Publico/Facturacion' }"
          @click="setActive('facturacion')"
        >
          Facturación Electrónica
        </Link>

        <Link :href="route('login')" @click="closeMenu" class="login-wrap">
          <a-button type="primary" size="small">Acceso</a-button>
        </Link>
      </nav>
    </div>
  </header>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { Link } from '@inertiajs/vue3'
import MegaMenu from '@/Components/Publico/MegaMenu.vue'

const menuVisible = ref(false)
const drawerOpen = ref(false)
const activeItem = ref('')
const isMobile = ref(false)

const checkMobile = () => {
  isMobile.value = window.innerWidth <= 768
  // Cerrar menú al cambiar a desktop
  if (!isMobile.value) {
    menuVisible.value = false
  }
}

const toggleMenu = () => {
  menuVisible.value = !menuVisible.value
}

const closeMenu = () => {
  menuVisible.value = false
}

const setActive = (name) => {
  activeItem.value = name
  closeMenu()
}

onMounted(() => {
  checkMobile()
  window.addEventListener('resize', checkMobile)
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', checkMobile)
})
</script>

<style scoped>
/* Header */
.header {
  background: #fff;
  box-shadow: 0 2px 4px rgba(0,0,0,.05);
  position: sticky;
  top: 0;
  z-index: 50;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0.9rem 24px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: relative;
}

.logo img {
  height: 48px;
  width: auto;
}

/* NAV */
.menu {
  display: flex;
  align-items: center;
  gap: 0.8rem;
}

/* Estilos para los links del header */
.nav-link {
  font-size: 1rem;
  font-weight: 600;
  padding: 0.6rem 1rem;
  border-radius: 6px;
  color: #2d3a4a;
  text-decoration: none;
  transition: all 0.18s ease-in-out;
  line-height: 1;
  white-space: nowrap;
}

.nav-link:hover {
  background: rgba(0,160,200,.08);
  color: #0093c4;
}

.nav-link.active {
  color: #0093c4;
  background: rgba(0,160,200,.08);
  box-shadow: inset 0 -2px 0 0 #0093c4;
}

.login-wrap {
  margin-left: 0.5rem;
}

/* Botón hamburguesa */
.hamburger {
  display: none;
  flex-direction: column;
  justify-content: space-around;
  width: 30px;
  height: 24px;
  background: transparent;
  border: none;
  cursor: pointer;
  padding: 0;
  z-index: 10;
}

.hamburger-line {
  display: block;
  width: 100%;
  height: 3px;
  background: #333;
  border-radius: 3px;
  transition: all 0.3s ease;
  transform-origin: center;
}

.hamburger.is-active .hamburger-line:nth-child(1) {
  transform: translateY(8px) rotate(45deg);
}

.hamburger.is-active .hamburger-line:nth-child(2) {
  opacity: 0;
  transform: scale(0);
}

.hamburger.is-active .hamburger-line:nth-child(3) {
  transform: translateY(-8px) rotate(-45deg);
}

.hide-on-mobile {
  display: block;
}

.show-on-mobile {
  display: none;
}

/* móvil */
@media (max-width: 768px) {
  .hamburger {
    display: flex;
  }

  .menu {
    display: none;
    position: fixed;
    top: 80px;
    left: 0;
    right: 0;
    background: #fff;
    padding: 20px;
    box-shadow: 0 10px 15px rgba(0,0,0,0.1);
    flex-direction: column;
    gap: 1rem;
    z-index: 49;
  }

  .menu-open {
    display: flex;
  }

  .nav-link {
    padding: 0.8rem;
    width: 100%;
    text-align: left;
  }

  .hide-on-mobile {
    display: none;
  }

  .show-on-mobile {
    display: inline-flex;
    width: 100%;
    justify-content: flex-start;
  }

  .login-wrap {
    margin-left: 0;
    margin-top: 0.5rem;
  }
}
</style>
