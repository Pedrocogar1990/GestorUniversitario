<template>
  <div
    class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex justify-content-center align-items-center z-3">
    <div class="bg-white rounded p-4 w-100" style="max-width: 40rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);">
      <h2 class="h5 fw-semibold mb-3">
        {{ professor?.id ? 'Editar Profesor' : 'Nuevo Profesor' }}
      </h2>

      <form @submit.prevent="saveProfessor">
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input v-model="form.name" type="text" class="form-control" />
          <div v-if="errors.name" class="text-danger small mt-1">{{ errors.name }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Apellido</label>
          <input v-model="form.lastname" type="text" class="form-control" />
          <div v-if="errors.lastname" class="text-danger small mt-1">{{ errors.lastname }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label">DNI</label>
          <input v-model="form.dni" type="text" class="form-control" />
          <div v-if="errors.dni" class="text-danger small mt-1">{{ errors.dni }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input v-model="form.email" type="email" class="form-control" />
          <div v-if="errors.email" class="text-danger small mt-1">{{ errors.email }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Departamento</label>
          <input v-model="form.department" type="text" class="form-control" />
          <div v-if="errors.department" class="text-danger small mt-1">{{ errors.department }}</div>
        </div>

        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" id="tutor" v-model="form.tutor" />
          <label class="form-check-label" for="tutor">¿Es tutor?</label>
        </div>

        <div class="d-flex justify-content-end mt-4">
          <button @click="$emit('close')" type="button" class="btn btn-link text-secondary me-2">
            Cancelar
          </button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'

const props = defineProps({ professor: Object })
const emit = defineEmits(['close', 'saved'])

const form = ref({
  name: '',
  lastname: '',
  dni: '',
  email: '',
  department: '',
  tutor: false,
})

const errors = ref({})

const saveProfessor = async () => {
  errors.value = {}
  try {
    if (props.professor?.id) {
      await axios.put(`/api/professors/${props.professor.id}`, form.value)
    } else {
      await axios.post('/api/professors', form.value)
    }
    emit('saved')
    emit('close')
    
    Swal.fire({
      position: "center",
      icon: "success",
      title: "Operación realizada con éxito",
      showConfirmButton: false,
      timer: 1500

    });
  } catch (e) {
    if (e.response?.status === 422) {
      errors.value = e.response.data.errors
    } else {
      console.error(e)
    }
  }
}

watch(
  () => props.professor,
  (newVal) => {
    if (newVal) {
      form.value = {
        name: newVal.name || '',
        lastname: newVal.lastname || '',
        dni: newVal.dni || '',
        email: newVal.email || '',
        department: newVal.department || '',
        tutor: !!newVal.tutor,
      }
    } else {
      form.value = {
        name: '',
        lastname: '',
        dni: '',
        email: '',
        department: '',
        tutor: false,
      }
    }
    errors.value = {}
  },
  { immediate: true }
)
</script>
