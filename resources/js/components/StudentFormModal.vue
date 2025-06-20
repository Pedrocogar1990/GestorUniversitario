<template>
  <div
    class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex justify-content-center align-items-center z-3">
    <div class="bg-white rounded p-4 w-100" style="max-width: 40rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);">
      <h2 class="h5 fw-semibold mb-3">
        {{ student?.id ? 'Editar' : 'Nuevo' }} Estudiante
      </h2>

      <form @submit.prevent="saveStudent">
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input v-model="form.name" type="text" class="form-control" />
          <div v-if="errors.name" class="text-danger small mt-1">{{ errors.name }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Apellido</label>
          <input v-model="form.lastName" type="text" class="form-control" />
          <div v-if="errors.lastName" class="text-danger small mt-1">{{ errors.lastName }}</div>
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
          <label class="form-label">Fecha de nacimiento</label>
          <input v-model="form.birthDate" type="date" class="form-control" />
          <div v-if="errors.birthDate" class="text-danger small mt-1">{{ errors.birthDate }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Carrera</label>
          <select v-model="form.career_id" class="form-select">
            <option value="">Seleccione una carrera</option>
            <option v-for="career in careers" :key="career.id" :value="career.id">
              {{ career.name }}
            </option>
          </select>
          <div v-if="errors.career_id" class="text-danger small mt-1">{{ errors.career_id }}</div>
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
import { ref, watch, onMounted } from 'vue'
import axios from 'axios'

const props = defineProps({ student: Object })
const emit = defineEmits(['close', 'saved'])

const form = ref({
  name: '',
  lastName: '',
  dni: '',
  email: '',
  birthDate: '',
  career_id: ''
})

const errors = ref({})

const careers = ref([])

const fetchCareers = async () => {
  const response = await axios.get('/api/careers')
  careers.value = response.data.data
}

const saveStudent = async () => {
  errors.value = {}
  try {
    if (props.student?.id) {
      await axios.put(`/api/students/${props.student.id}`, form.value)
    } else {
      await axios.post('/api/students', form.value)
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
      const backendErrors = e.response.data.errors
      errors.value = {
        name: backendErrors.name ? 'El nombre es obligatorio.' : '',
        lastName: backendErrors.lastName ? 'El apellido es obligatorio.' : '',
        dni: backendErrors.dni ? 'El dni es obligatorio.' : '',
        email: backendErrors.email ? 'El correo electrónico no es válido o está duplicado.' : '',
        birthDate: backendErrors.birthDate ? 'La fecha de nacimiento es obligatoria.' : '',
        career_id: backendErrors.career_id ? 'Debes seleccionar una carrera.' : ''
      }
    } else {
      console.error(e)
    }
  }
}

const resetForm = () => {
  form.value = {
    name: '',
    lastName: '',
    dni: '',
    email: '',
    birthDate: '',
    career_id: ''
  }
  errors.value = {
  }
}

watch(
  () => props.student,
  (newVal) => {
    if (newVal) {
      form.value = {
        name: newVal.name || '',
        lastName: newVal.lastName || '',
        dni: newVal.dni || '',
        email: newVal.email || '',
        birthDate: newVal.birthDate || '',
        career_id: newVal.career_id || ''
      }
    } else {
      resetForm()
    }
  },
  { immediate: true }
)

onMounted(fetchCareers)
</script>
