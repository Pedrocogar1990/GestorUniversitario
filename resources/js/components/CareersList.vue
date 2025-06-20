<template>
  <div class="p-4">
    <h1 class="h4 fw-bold mb-4">Listado de Carreras</h1>

   
    <div class="d-flex justify-content-between align-items-center mb-3">
      <input v-model="search" @input="fetchCareers" type="text" class="form-control w-50"
        placeholder="Buscar por nombre o código" />
      <button @click="showCreateModal = true" class="btn btn-success">
        Nueva Carrera
      </button>
    </div>

 
    <div class="row">
      <div class="col-12 col-md-6 col-lg-4 mb-4" v-for="career in careers.data" :key="career.id">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title">{{ career.name }}</h5>
            <ul class="list-unstyled mb-3">
              <li><strong>Código:</strong> {{ career.careerCode }}</li>
              <li><strong>Duración (años):</strong> {{ career.duration }}</li>
              <li><strong>Descripción:</strong> {{ career.description }}</li>
            </ul>
          </div>
          <div class="d-flex justify-content-between mt-3">
            <button @click="editCareer(career)" class="btn btn-outline-primary btn-sm w-100 me-2">
              <i class="bi bi-pencil-square me-1"></i> Editar
            </button>
            <button @click="deleteCareer(career.id)" class="btn btn-outline-danger btn-sm w-100">
              <i class="bi bi-trash me-1"></i> Eliminar
            </button>
          </div>
        </div>
      </div>
    </div>

   
    <div class="d-flex justify-content-between align-items-center mt-3 mt-sm-5">
      <div>
        Página {{ careers.current_page }} de {{ careers.last_page }}
      </div>
      <div>
        <button class="btn btn-outline-secondary me-2" :disabled="careers.current_page === 1"
          @click="changePage(careers.current_page - 1)">
          ← Anterior
        </button>
        <button class="btn btn-outline-secondary" :disabled="careers.current_page === careers.last_page"
          @click="changePage(careers.current_page + 1)">
          Siguiente →
        </button>
      </div>
    </div>

   
    <div class="text-end mt-4">
      <router-link to="/inicio" class="btn btn-primary">
        ← Volver a inicio
      </router-link>
    </div>

  
    <CareerFormModal v-if="showCreateModal" @close="showCreateModal = false" @saved="fetchCareers" />
    <CareerFormModal v-if="editingCareer" :career="editingCareer" @close="editingCareer = null" @saved="fetchCareers" />
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'
import CareerFormModal from './CareerFormModal.vue'

const careers = ref({})
const showCreateModal = ref(false)
const editingCareer = ref(null)
const search = ref('')
const page = ref(1)
const perPage = 12

const fetchCareers = async () => {
  const { data } = await axios.get('/api/careers', {
    params: {
      search: search.value,
      page: page.value,
      per_page: perPage
    }
  })
  careers.value = data
}

const changePage = (newPage) => {
  page.value = newPage
  fetchCareers()
}

const editCareer = (career) => {
  editingCareer.value = { ...career }
}

const deleteCareer = async (id) => {
  const result = await Swal.fire({
    title: "¿Estás seguro que desea borrar la carrera?",
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
      await axios.delete(`/api/careers/${id}`);
      await Swal.fire({
        title: "Eliminado",
        text: "La carrera ha sido eliminada con éxito.",
        icon: "success"
      });
      fetchCareers();
    } catch (error) {
      console.error(error);
      Swal.fire({
        title: "Error",
        text: "No se pudo eliminar la carrera.",
        icon: "error"
      });
    }
  }
}


watch(search, () => {
  page.value = 1
})

onMounted(fetchCareers)
</script>
