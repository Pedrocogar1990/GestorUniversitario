<template>
  <div class="p-4">
    <h1 class="h4 fw-bold mb-4">Listado de Matrículas</h1>

 
    <div class="d-flex justify-content-between align-items-center mb-3">
      <input v-model="search" @input="fetchEnrollments" type="text" class="form-control w-50"
        placeholder="Buscar por nombre de estudiante o asignatura" />
      <button @click="showCreateModal = true" class="btn btn-success">
        Nueva Matrícula
      </button>
    </div>


    <div class="row">
      <div class="col-12 col-md-6 col-lg-4 mb-4" v-for="enrollment in enrollments.data" :key="enrollment.id">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title">{{ enrollment.student.name }} {{ enrollment.student.lastName }}</h5>
            <ul class="list-unstyled mb-3">
              <li><strong>Asignatura:</strong> {{ enrollment.subject.name }}</li>
              <li><strong>Código:</strong> {{ enrollment.subject.subjectCode }}</li>
              <li><strong>Fecha:</strong> {{ enrollment.registration_date }}</li>
            </ul>
          </div>
          <div class="d-flex justify-content-between mt-3">
            <button @click="editEnrollment(enrollment)" class="btn btn-outline-primary btn-sm w-100 me-2">
              <i class="bi bi-pencil-square me-1"></i> Editar
            </button>
            <button @click="deleteEnrollment(enrollment.id)" class="btn btn-outline-danger btn-sm w-100">
              <i class="bi bi-trash me-1"></i> Eliminar
            </button>
          </div>
        </div>
      </div>
    </div>

    
    <div class="d-flex justify-content-between align-items-center mt-3 mt-sm-5">
      <div>Página {{ enrollments.current_page }} de {{ enrollments.last_page }}</div>
      <div>
        <button class="btn btn-outline-secondary me-2" :disabled="enrollments.current_page === 1"
          @click="changePage(enrollments.current_page - 1)">
          ← Anterior
        </button>
        <button class="btn btn-outline-secondary" :disabled="enrollments.current_page === enrollments.last_page"
          @click="changePage(enrollments.current_page + 1)">
          Siguiente →
        </button>
      </div>
    </div>

    
    <div class="text-end mt-4">
      <router-link to="/inicio" class="btn btn-primary">
        ← Volver a inicio
      </router-link>
    </div>

   
    <EnrollmentFormModal v-if="showCreateModal" @close="showCreateModal = false" @saved="fetchEnrollments" />

    
    <EnrollmentFormModal v-if="editingEnrollment" :enrollment="editingEnrollment" @close="editingEnrollment = null"
      @saved="fetchEnrollments" />
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'
import EnrollmentFormModal from './EnrollmentFormModal.vue'
import Swal from 'sweetalert2'

const enrollments = ref({ data: [], current_page: 1, last_page: 1 })
const showCreateModal = ref(false)
const editingEnrollment = ref(null)
const search = ref('')
const page = ref(1)
const perPage = 12

const fetchEnrollments = async () => {
  try {
    const { data } = await axios.get('/api/enrollments', {
      params: {
        search: search.value,
        page: page.value,
        per_page: perPage
      }
    })
    enrollments.value = data
  } catch (error) {
    console.error('Error al cargar matrículas:', error)
    Swal.fire('Error', 'No se pudieron cargar las matrículas.', 'error')
  }
}

const changePage = (newPage) => {
  page.value = newPage
  fetchEnrollments()
}

const editEnrollment = (enrollment) => {
  editingEnrollment.value = { ...enrollment }
}

const deleteEnrollment = async (id) => {
  const result = await Swal.fire({
    title: "¿Estás seguro?",
    text: "Esta matrícula será eliminada.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar"
  })

  if (result.isConfirmed) {
    try {
      await axios.delete(`/api/enrollments/${id}`)
      await Swal.fire("Eliminado", "La matrícula ha sido eliminada.", "success")
      fetchEnrollments()
    } catch (e) {
      console.error(e)
      Swal.fire("Error", "No se pudo eliminar la matrícula.", "error")
    }
  }
}

watch(search, () => {
  page.value = 1
  fetchEnrollments()
})

onMounted(fetchEnrollments)
</script>
