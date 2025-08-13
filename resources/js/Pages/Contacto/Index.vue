<template>
  <a-row justify="center">
    <a-col :xs="24" :sm="20" :md="16" :lg="12">
      <a-card title="Contáctenos">
        <a-alert
          v-if="flash.success"
          type="success"
          :message="flash.success"
          show-icon
          class="mb-3"
        />

        <a-form
          layout="vertical"
          :model="form"
          :rules="rules"
          @finish="submit"
          @finishFailed="onFail"
        >
          <!-- honeypot -->
          <input v-model="form.website" type="text" style="display:none;" autocomplete="off" />

          <a-form-item label="Empresa" name="empresa">
            <a-input v-model:value="form.empresa" maxlength="150" />
          </a-form-item>

          <a-row :gutter="12">
            <a-col :span="12">
              <a-form-item label="RUC" name="ruc">
                <a-input v-model:value="form.ruc" maxlength="11" placeholder="11 dígitos" />
              </a-form-item>
            </a-col>
            <a-col :span="12">
              <a-form-item label="Giro de negocio" name="rubro_id">
                <a-select
                  v-model:value="form.rubro_id"
                  allow-clear
                  :options="rubrosOptions"
                  :loading="false"
                />
              </a-form-item>
            </a-col>
          </a-row>

          <a-row :gutter="12">
            <a-col :span="12">
              <a-form-item label="Nombre de contacto" name="nombre_contacto">
                <a-input v-model:value="form.nombre_contacto" maxlength="120" />
              </a-form-item>
            </a-col>
            <a-col :span="12">
              <a-form-item label="Email de contacto" name="email_contacto">
                <a-input v-model:value="form.email_contacto" maxlength="150" />
              </a-form-item>
            </a-col>
          </a-row>

          <a-form-item label="Teléfono de contacto" name="telefono_contacto">
            <a-input v-model:value="form.telefono_contacto" maxlength="30" />
          </a-form-item>

          <a-form-item label="Desea" name="desea">
            <a-radio-group v-model:value="form.desea">
              <a-radio value="cotizacion">Cotización</a-radio>
              <a-radio value="demo">Demo</a-radio>
            </a-radio-group>
          </a-form-item>

          <a-form-item label="Mensaje" name="mensaje">
            <a-textarea v-model:value="form.mensaje" :rows="4" />
          </a-form-item>

          <a-space>
            <a-button type="primary" html-type="submit" :loading="processing">Enviar</a-button>
            <a-button @click="reset" :disabled="processing">Limpiar</a-button>
          </a-space>
        </a-form>
      </a-card>
    </a-col>
  </a-row>
</template>

<script setup>
import { computed, ref } from 'vue'
import { useForm, usePage, router } from '@inertiajs/vue3'
import { message } from 'ant-design-vue'

const props = defineProps({
  rubros: { type: Array, default: () => [] },
})

const flash = computed(() => usePage().props.flash || {})

const form = useForm({
  website: '',           // honeypot
  empresa: '',
  ruc: '',
  rubro_id: undefined,
  nombre_contacto: '',
  email_contacto: '',
  telefono_contacto: '',
  desea: undefined,
  mensaje: '',
  url_origen: window.location.href,
})

const rules = {
  empresa: [{ required: true, message: 'Campo obligatorio.' }],
  nombre_contacto: [{ required: true, message: 'Campo obligatorio.' }],
  email_contacto: [
    { required: true, message: 'Campo obligatorio.' },
    { type: 'email', message: 'Email inválido.' },
  ],
  desea: [{ required: true, message: 'Selecciona una opción.' }],
  ruc: [{ len: 11, message: 'Debe tener 11 dígitos.', trigger: 'blur' }],
}

const rubrosOptions = computed(() =>
  props.rubros.map(r => ({ value: r.id, label: r.nombre }))
)

const processing = ref(false)

const submit = async () => {
  processing.value = true
  form.post(route('contacto.store'), {
    preserveScroll: true,
    onSuccess: () => {
      message.success('¡Enviado! Te contactaremos pronto.')
      reset()
    },
    onError: () => {
      message.error('Revisa los campos marcados.')
    },
    onFinish: () => {
      processing.value = false
    },
  })
}

const onFail = () => {
  message.warning('Completa los campos obligatorios.')
}

const reset = () => {
  form.reset()
  form.website = ''
  form.url_origen = window.location.href
}
</script>

<style scoped>
.mb-3 { margin-bottom: 12px; }
</style>
