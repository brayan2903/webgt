<template>
    <AuthenticatedLayout>

  <a-space direction="vertical" style="width:100%">
    <a-card title="Solicitudes de contacto">
      <a-form layout="inline" @submit.prevent="filtrar">
        <a-form-item label="Buscar">
          <a-input v-model:value="localFilters.buscar" allow-clear placeholder="Empresa, nombre, email, RUC..." style="min-width:260px" />
        </a-form-item>

        <a-form-item label="Rubro">
          <a-select v-model:value="localFilters.rubro_id" allow-clear style="min-width:200px"
                    :options="rubrosOptions" />
        </a-form-item>

        <a-form-item label="Desea">
          <a-select v-model:value="localFilters.desea" allow-clear style="min-width:160px">
            <a-select-option value="cotizacion">Cotización</a-select-option>
            <a-select-option value="demo">Demo</a-select-option>
          </a-select>
        </a-form-item>

        <a-form-item label="Por página">
          <a-select v-model:value="localFilters.perPage" style="min-width:110px">
            <a-select-option :value="10">10</a-select-option>
            <a-select-option :value="25">25</a-select-option>
            <a-select-option :value="50">50</a-select-option>
          </a-select>
        </a-form-item>

        <a-form-item>
          <a-space>
            <a-button type="primary" @click="filtrar">Filtrar</a-button>
            <a-button @click="limpiar">Limpiar</a-button>
          </a-space>
        </a-form-item>
      </a-form>

      <a-table
        class="mt-3"
        :data-source="solicitudes.data"
        :columns="columns"
        :loading="cargando"
        :pagination="false"
        row-key="id"
        :scroll="{ x: 1000 }"
      >
        <template #bodyCell="{ column, record }">
          <template v-if="column.key === 'empresa'">
            <div><strong>{{ record.empresa }}</strong></div>
            <div class="text-muted">{{ record.ruc || '—' }}</div>
          </template>

          <template v-else-if="column.key === 'contacto'">
            <div>{{ record.nombre_contacto }}</div>
            <div class="text-muted">{{ record.email_contacto }}</div>
            <div class="text-muted">{{ record.telefono_contacto || '—' }}</div>
          </template>

          <template v-else-if="column.key === 'rubro'">
            {{ record.rubro?.nombre || '—' }}
          </template>

          <template v-else-if="column.key === 'desea'">
            <a-tag v-if="record.desea === 'cotizacion'">Cotización</a-tag>
            <a-tag v-else>Demo</a-tag>
          </template>

          <template v-else-if="column.key === 'mensaje'">
            <span :title="record.mensaje">{{ recortar(record.mensaje, 80) }}</span>
          </template>

          <template v-else-if="column.key === 'fecha'">
            {{ formatDate(record.created_at) }}
          </template>
        </template>
      </a-table>

      <div class="mt-2" style="display:flex; justify-content:flex-end;">
        <a-pagination
          :current="solicitudes.current_page"
          :pageSize="solicitudes.per_page"
          :total="solicitudes.total"
          @change="onPageChange"
          @showSizeChange="onPageSizeChange"
          :pageSizeOptions="['10','25','50']"
          show-size-changer
          show-total
        />
      </div>
    </a-card>
  </a-space>
  </AuthenticatedLayout>
</template>

<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { computed, reactive, ref } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import dayjs from 'dayjs'

const page = usePage()
const props = defineProps({
  solicitudes: { type: Object, required: true },
  rubros: { type: Array, default: () => [] },
  filters: { type: Object, default: () => ({}) },
})

const solicitudes = computed(() => props.solicitudes)
const cargando = ref(false)

const rubrosOptions = computed(() =>
  props.rubros.map(r => ({ value: r.id, label: r.nombre }))
)

const localFilters = reactive({
  buscar: props.filters.buscar || '',
  rubro_id: props.filters.rubro_id || undefined,
  desea: props.filters.desea || undefined,
  perPage: props.filters.perPage || 10,
})

const columns = [
  { title: 'Empresa / RUC', key: 'empresa', dataIndex: 'empresa', width: 240 },
  { title: 'Contacto', key: 'contacto', dataIndex: 'nombre_contacto', width: 240 },
  { title: 'Rubro', key: 'rubro', dataIndex: ['rubro','nombre'], width: 160 },
  { title: 'Desea', key: 'desea', dataIndex: 'desea', width: 110 },
  { title: 'Mensaje', key: 'mensaje', dataIndex: 'mensaje', ellipsis: true },
  { title: 'Fecha', key: 'fecha', dataIndex: 'created_at', width: 150 },
]

const formatDate = (iso) => iso ? dayjs(iso).format('YYYY-MM-DD HH:mm') : ''

const recortar = (txt, n) => {
  if (!txt) return '—'
  return txt.length > n ? txt.slice(0, n) + '…' : txt
}

const navegar = (extra = {}) => {
  cargando.value = true
  router.get(route('solicitudes.index'), {
    ...localFilters,
    page: extra.page ?? solicitudes.value.current_page,
    perPage: extra.perPage ?? localFilters.perPage,
  }, {
    preserveScroll: true,
    preserveState: true,
    replace: true,
    onFinish: () => { cargando.value = false }
  })
}

const filtrar = () => navegar({ page: 1 })
const limpiar = () => {
  localFilters.buscar = ''
  localFilters.rubro_id = undefined
  localFilters.desea = undefined
  localFilters.perPage = 10
  navegar({ page: 1, perPage: 10 })
}
const onPageChange = (pageNum) => navegar({ page: pageNum })
const onPageSizeChange = (pageNum, size) => {
  localFilters.perPage = size
  navegar({ page: 1, perPage: size })
}
</script>

<style scoped>
.mt-2 { margin-top: 12px; }
.mt-3 { margin-top: 16px; }
.text-muted { color: #888; font-size: 12px; }
</style>
