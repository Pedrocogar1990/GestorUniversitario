<template>
  <div class="p-4">
    <h1 class="h4 fw-bold mb-4">Listado de Asignaturas</h1>


    <div class="d-flex justify-content-between align-items-center mb-3">
      <input v-model="search" @input="fetchSubjects" type="text" class="form-control w-50"
        placeholder="Buscar por nombre o código" />
      <button @click="showCreateModal = true" class="btn btn-primary">
        Nueva Asignatura
      </button>
    </div>

  
    <div class="row">
      <div class="col-12 col-md-6 col-lg-4 mb-4" v-for="subject in subjects.data" :key="subject.id">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title">{{ subject.name }}</h5>
            <ul class="list-unstyled mb-3">
              <li><strong>Código:</strong> {{ subject.subjectCode }}</li>
              <li><strong>Créditos:</strong> {{ subject.credits }}</li>
              <li><strong>Carrera:</strong> {{ subject.career?.name || 'N/A' }}</li>
              <li>
                <strong>Profesor:</strong>
                {{ subject.professor ? subject.professor.name + ' ' + subject.professor.lastname : 'N/A' }}
              </li>
            </ul>
          </div>
          <div class="d-flex justify-content-between mt-3">
            <button @click="editSubject(subject)" class="btn btn-outline-primary btn-sm w-100 me-2">
              <i class="bi bi-pencil-square me-1"></i> Editar
            </button>
            <button @click="deleteSubject(subject.id)" class="btn btn-outline-danger btn-sm w-100">
              <i class="bi bi-trash me-1"></i> Eliminar
            </button>
          </div>
        </div>
      </div>
    </div>

  
    <div class="d-flex justify-content-between align-items-center mt-3 mt-sm-5">
      <div>
        Página {{ subjects.current_page }} de {{ subjects.last_page }}
      </div>
      <div>
        <button class="btn btn-outline-secondary me-2" :disabled="subjects.current_page === 1"
          @click="changePage(subjects.current_page - 1)">
          ← Anterior
        </button>
        <button class="btn btn-outline-secondary" :disabled="subjects.current_page === subjects.last_page"
          @click="changePage(subjects.current_page + 1)">
          Siguiente →
        </button>
      </div>
    </div>

    
    <div class="text-end mt-4">
      <router-link to="/inicio" class="btn btn-primary">
        ← Volver a inicio
      </router-link>
    </div>

    
    <SubjectFormModal v-if="showCreateModal" @close="showCreateModal = false" @saved="handleSaved" />

   
    <SubjectFormModal v-if="editingSubject" :subject="editingSubject" @close="editingSubject = null"
      @saved="handleSaved" />
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'
import SubjectFormModal from './SubjectFormModal.vue'

const subjects = ref({})
const showCreateModal = ref(false)
const editingSubject = ref(null)
const search = ref('')
const page = ref(1)
const perPage = 12

const fetchSubjects = async () => {
  const { data } = await axios.get('/api/subjects', {
    params: {
      search: search.value,
      page: page.value,
      per_page: perPage
    }
  })
  subjects.value = data
}

const changePage = (newPage) => {
  page.value = newPage
  fetchSubjects()
}

const editSubject = (subject) => {
  editingSubject.value = { ...subject }
}

const deleteSubject = async (id) => {
  const result = await Swal.fire({
    title: '¿Estás seguro que deseas eliminar la asignatura?',
    text: 'Esta acción no se puede deshacer.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar',
  })

  if (result.isConfirmed) {
    try {
      await axios.delete(`/api/subjects/${id}`)
      await Swal.fire({
        title: 'Eliminado',
        text: 'La asignatura ha sido eliminada con éxito.',
        icon: 'success',
      })
      fetchSubjects()
    } catch (error) {
      console.error(error)
      Swal.fire({
        title: 'Error',
        text: 'No se pudo eliminar la asignatura.',
        icon: 'error',
      })
    }
  }
}

const handleSaved = () => {
  showCreateModal.value = false
  editingSubject.value = null
  fetchSubjects()
}

watch(search, () => {
  page.value = 1
  fetchSubjects()
})

onMounted(fetchSubjects)
</script>
