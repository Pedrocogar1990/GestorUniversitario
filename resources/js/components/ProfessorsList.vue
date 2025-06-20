<template>
  <div class="p-4">
    <h1 class="h4 fw-bold mb-4">Listado de Profesores</h1>


    <div class="d-flex justify-content-between align-items-center mb-3">
      <input v-model="search" @input="fetchProfessors" type="text" class="form-control w-50"
        placeholder="Buscar por nombre, apellido, DNI, departamento o email" />
      <button @click="showCreateModal = true" class="btn btn-success">
        Nuevo Profesor
      </button>
    </div>

  
    <div class="row">
      <div class="col-12 col-md-6 col-lg-4 mb-4" v-for="professor in professors.data" :key="professor.id">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title">{{ professor.name }} {{ professor.lastname }}</h5>
            <ul class="list-unstyled mb-3">
              <li><strong>DNI:</strong> {{ professor.dni }}</li>
              <li><strong>Email:</strong> {{ professor.email }}</li>
              <li><strong>Departamento:</strong> {{ professor.department }}</li>
              <li>
                <strong>Tutor:</strong>
                <span class="badge" :class="professor.tutor ? 'bg-success' : 'bg-secondary'">
                  {{ professor.tutor ? 'Sí' : 'No' }}
                </span>
              </li>
            </ul>
          </div>
          <div class="d-flex justify-content-between mt-3">
            <button @click="editProfessor(professor)" class="btn btn-outline-primary btn-sm w-100 me-2">
              <i class="bi bi-pencil-square me-1"></i> Editar
            </button>
            <button @click="deleteProfessor(professor.id)" class="btn btn-outline-danger btn-sm w-100">
              <i class="bi bi-trash me-1"></i> Eliminar
            </button>
          </div>
        </div>
      </div>
    </div>



   
    <div class="d-flex justify-content-between align-items-center mt-3" v-if="professors.total">
      <div>
        Página {{ professors.current_page }} de {{ professors.last_page }}
      </div>
      <div>
        <button class="btn btn-outline-secondary me-2" :disabled="professors.current_page === 1"
          @click="changePage(professors.current_page - 1)">
          ← Anterior
        </button>
        <button class="btn btn-outline-secondary" :disabled="professors.current_page === professors.last_page"
          @click="changePage(professors.current_page + 1)">
          Siguiente →
        </button>
      </div>
    </div>


    <div class="text-end mt-4">
      <router-link to="/inicio" class="btn btn-primary">
        ← Volver a inicio
      </router-link>
    </div>

  
    <ProfessorFormModal v-if="showCreateModal" @close="showCreateModal = false" @saved="fetchProfessors" />
    <ProfessorFormModal v-if="editingProfessor" :professor="editingProfessor" @close="editingProfessor = null"
      @saved="fetchProfessors" />
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'
import ProfessorFormModal from './ProfessorFormModal.vue'

const professors = ref({ data: [] })
const search = ref('')
const showCreateModal = ref(false)
const editingProfessor = ref(null)
const page = ref(1)
const perPage = 12

const fetchProfessors = async () => {
  const { data } = await axios.get('/api/professors', {
    params: {
      search: search.value,
      page: page.value,
      per_page: perPage,
    },
  })
  professors.value = data
}

const changePage = (newPage) => {
  page.value = newPage
  fetchProfessors()
}

const editProfessor = (professor) => {
  editingProfessor.value = { ...professor }
}

const deleteProfessor = async (id) => {
  const result = await Swal.fire({
    title: "¿Estás seguro que desea borrar el profesor?",
    text: "Esta acción no se puede deshacer.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar"
  });

  if (result.isConfirmed) {
    try {
      await axios.delete(`/api/professors/${id}`);
      await Swal.fire({
        title: "Eliminado",
        text: "El profesor ha sido eliminado con éxito.",
        icon: "success"
      });
      fetchProfessors();
    } catch (error) {
      console.error(error);
      Swal.fire({
        title: "Error",
        text: "No se pudo eliminar el profesor.",
        icon: "error"
      });
    }
  }
}


watch(search, () => {
  page.value = 1
  fetchProfessors()
})

onMounted(fetchProfessors)
</script>
