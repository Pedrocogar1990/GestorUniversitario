<template>
  <div
    class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex justify-content-center align-items-center z-3">
    <div class="bg-white rounded p-4 w-100" style="max-width: 40rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);">
      <h2 class="h5 fw-semibold mb-3">
        {{ enrollment?.id ? 'Editar' : 'Nueva' }} Matrícula
      </h2>

      <form @submit.prevent="saveEnrollment">
        <div class="mb-3">
          <label class="form-label">Estudiante</label>
          <select v-model="form.student_id" class="form-select">
            <option value="">Seleccione un estudiante</option>
            <option v-for="student in students" :key="student.id" :value="student.id">
              {{ student.name }} {{ student.lastName }}
            </option>
          </select>
          <div v-if="errors.student_id" class="text-danger small mt-1">{{ errors.student_id }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Asignatura</label>
          <select v-model="form.subject_id" class="form-select">
            <option value="">Seleccione una asignatura</option>
            <option v-for="subject in subjects" :key="subject.id" :value="subject.id">
              {{ subject.name }} ({{ subject.subjectCode }})
            </option>
          </select>
          <div v-if="errors.subject_id" class="text-danger small mt-1">{{ errors.subject_id }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Fecha de matrícula</label>
          <input v-model="form.registration_date" type="date" class="form-control" />
          <div v-if="errors.registration_date" class="text-danger small mt-1">{{ errors.registration_date }}</div>
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

const props = defineProps({ enrollment: Object })
const emit = defineEmits(['close', 'saved'])

const form = ref({
  student_id: '',
  subject_id: '',
  registration_date: ''
})

const errors = ref({})
const students = ref([])
const subjects = ref([])

const fetchData = async () => {
  const [studentsRes, subjectsRes] = await Promise.all([
    axios.get('/api/students'),
    axios.get('/api/subjects')
  ])
  students.value = studentsRes.data.data || studentsRes.data
  subjects.value = subjectsRes.data.data || subjectsRes.data
}

const saveEnrollment = async () => {
  errors.value = {}
  try {
    if (props.enrollment?.id) {
      await axios.put(`/api/enrollments/${props.enrollment.id}`, form.value)
    } else {
      await axios.post('/api/enrollments', form.value)
    }

    emit('saved')
    emit('close')

    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Matrícula guardada con éxito',
      showConfirmButton: false,
      timer: 1500
    })
  } catch (e) {
    if (e.response?.status === 422) {
      const backendErrors = e.response.data.errors
      errors.value = {
        student_id: backendErrors.student_id ? 'El estudiante es obligatorio.' : '',
        subject_id: backendErrors.subject_id ? 'La asignatura es obligatoria.' : '',
        registration_date: backendErrors.registration_date ? 'La fecha es obligatoria.' : ''
      }
    } else {
      console.error(e)
    }
  }
}

const resetForm = () => {
  form.value = {
    student_id: '',
    subject_id: '',
    enrollment_date: ''
  }
  errors.value = {}
}

watch(
  () => props.enrollment,
  (newVal) => {
    if (newVal) {
      form.value = {
        student_id: newVal.student_id || '',
        subject_id: newVal.subject_id || '',
        registration_date: newVal.registration_date || ''
      }
    } else {
      resetForm()
    }
  },
  { immediate: true }
)

onMounted(fetchData)
</script>
