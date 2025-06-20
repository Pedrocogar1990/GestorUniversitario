<template>
  <div
    class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex justify-content-center align-items-center z-3">
    <div class="bg-white rounded p-4 w-100" style="max-width: 40rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);">
      <h2 class="h5 fw-semibold mb-3">
        {{ career?.id ? 'Editar' : 'Nueva' }} Carrera
      </h2>

      <form @submit.prevent="saveCareer">
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input v-model="form.name" type="text" class="form-control" />
          <div v-if="errors.name" class="text-danger small mt-1">{{ errors.name }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Código</label>
          <input v-model="form.careerCode" type="text" class="form-control" />
          <div v-if="errors.careerCode" class="text-danger small mt-1">{{ errors.careerCode }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Duración (en años)</label>
          <input v-model="form.duration" type="number" class="form-control" min="1" />
          <div v-if="errors.duration" class="text-danger small mt-1">{{ errors.duration }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Descripción</label>
          <textarea v-model="form.description" class="form-control" rows="3" />
          <div v-if="errors.description" class="text-danger small mt-1">{{ errors.description }}</div>
        </div>

        <div class="d-flex justify-content-end mt-4">
          <button @click="$emit('close')" type="button" class="btn btn-link text-secondary me-2">
            Cancelar
          </button>
          <button type="submit" class="btn btn-primary">
            Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'

const props = defineProps({ career: Object })
const emit = defineEmits(['close', 'saved'])

const form = ref({
  name: '',
  careerCode: '',
  duration: '',
  description: ''
})

const errors = ref({})

const resetForm = () => {
  form.value = {
    name: '',
    careerCode: '',
    duration: '',
    description: ''
  }
  errors.value = {}
}

const saveCareer = async () => {
  errors.value = {}
  try {
    if (props.career?.id) {
      await axios.put(`/api/careers/${props.career.id}`, form.value)
    } else {
      await axios.post('/api/careers', form.value)
    }
    emit('saved')
    emit('close')

    Swal.fire({
      icon: 'success',
      title: 'Carrera guardada',
      showConfirmButton: false,
      timer: 1500
    })
  } catch (e) {
    if (e.response?.status === 422) {
      const backendErrors = e.response.data.errors
      errors.value = {
        name: backendErrors.name?.[0] || '',
        careerCode: backendErrors.careerCode?.[0] || '',
        duration: backendErrors.duration?.[0] || '',
        description: backendErrors.description?.[0] || ''
      }
    } else {
      console.error(e)
    }
  }
}

watch(
  () => props.career,
  (newVal) => {
    if (newVal) {
      form.value = {
        name: newVal.name || '',
        careerCode: newVal.careerCode || '',
        duration: newVal.duration || '',
        description: newVal.description || ''
      }
    } else {
      resetForm()
    }
  },
  { immediate: true }
)
</script>
