<template>
  <div class="p-4">
    <h1 class="h4 fw-bold mb-4">Listado de Estudiantes</h1>

 
    <div class="d-flex justify-content-between align-items-center mb-3">
      <input v-model="search" @input="fetchStudents" type="text" class="form-control w-50"
        placeholder="Buscar por nombre, apellido, email o DNI" />
      <button @click="showCreateModal = true" class="btn btn-success">
        Nuevo Estudiante
      </button>
    </div>

   
    <div class="row">
      <div class="col-12 col-md-6 col-lg-4 mb-4" v-for="student in students.data" :key="student.id">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title">{{ student.name }} {{ student.lastName }}</h5>
            <ul class="list-unstyled mb-3">
              <li><strong>DNI:</strong> {{ student.dni }}</li>
              <li><strong>Email:</strong> {{ student.email }}</li>
              <li><strong>Fecha de nacimiento:</strong> {{ student.birthDate }}</li>
              <li><strong>Carrera:</strong> {{ student.career.name }}</li>
            </ul>
          </div>
          <div class="d-flex justify-content-between mt-3">
            <button @click="editStudent(student)" class="btn btn-outline-primary btn-sm w-100 me-2">
              <i class="bi bi-pencil-square me-1"></i> Editar
            </button>
            <button @click="deleteStudent(student.id)" class="btn btn-outline-danger btn-sm w-100">
              <i class="bi bi-trash me-1"></i> Eliminar
            </button>
          </div>
        </div>
      </div>
    </div>

   
    <div class="d-flex justify-content-between align-items-center mt-3 mt-sm-5">

      <div>
        Página {{ students.current_page }} de {{ students.last_page }}
      </div>
      <div>
        <button class="btn btn-outline-secondary me-2" :disabled="students.current_page === 1"
          @click="changePage(students.current_page - 1)">
          ← Anterior
        </button>
        <button class="btn btn-outline-secondary" :disabled="students.current_page === students.last_page"
          @click="changePage(students.current_page + 1)">
          Siguiente →
        </button>
      </div>
    </div>

   
    <div class="text-end mt-4">
      <router-link to="/inicio" class="btn btn-primary">
        ← Volver a inicio
      </router-link>
    </div>

    
    <StudentFormModal v-if="showCreateModal" @close="showCreateModal = false" @saved="fetchStudents" />

  
    <StudentFormModal v-if="editingStudent" :student="editingStudent" @close="editingStudent = null"
      @saved="fetchStudents" />
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'
import StudentFormModal from './StudentFormModal.vue'

const students = ref({})
const showCreateModal = ref(false)
const editingStudent = ref(null)
const search = ref('')
const page = ref(1)
const perPage = 12

const fetchStudents = async () => {
  const { data } = await axios.get('/api/students', {
    params: {
      search: search.value,
      page: page.value,
      per_page: perPage
    }
  })
  students.value = data
}

const changePage = (newPage) => {
  page.value = newPage
  fetchStudents()
}

const editStudent = (student) => {
  editingStudent.value = { ...student }
}

const deleteStudent = async (id) => {
  const result = await Swal.fire({
    title: "¿Estás seguro que desea borrar el estudiante?",
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
      await axios.delete(`/api/students/${id}`);
      await Swal.fire({
        title: "Eliminado",
        text: "El estudiante ha sido eliminado con éxito.",
        icon: "success"
      });
      fetchStudents();
    } catch (error) {
      console.error(error);
      Swal.fire({
        title: "Error",
        text: "No se pudo eliminar el estudiante.",
        icon: "error"
      });
    }
  }
}


watch(search, () => {
  page.value = 1
})

onMounted(fetchStudents)
</script>
