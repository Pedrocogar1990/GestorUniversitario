<template>
  <div class="p-4">
    <h1 class="h4 fw-bold mb-4">Listado de Usuarios</h1>

   
    <div class="d-flex justify-content-between align-items-center mb-3">
      <input v-model="search" @input="fetchUsers" type="text" class="form-control w-50"
        placeholder="Buscar por nombre o email" />
      <button @click="showCreateModal = true" class="btn btn-success">
        Nuevo Usuario
      </button>
    </div>

    
    <div class="row">
      <div class="col-12 col-md-6 col-lg-4 mb-4" v-for="user in users.data" :key="user.id">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title">{{ user.name }}</h5>
            <ul class="list-unstyled mb-3">
              <li><strong>Email:</strong> {{ user.email }}</li>
              <li><strong>Rol:</strong> {{ user.roles.map(r => r.name).join(', ') }}</li>
            </ul>
          </div>
          <div class="d-flex justify-content-between mt-3">
            <button @click="editUser(user)" class="btn btn-outline-primary btn-sm w-100 me-2">
              <i class="bi bi-pencil-square me-1"></i> Editar
            </button>
            <button @click="deleteUser(user.id)" class="btn btn-outline-danger btn-sm w-100">
              <i class="bi bi-trash me-1"></i> Eliminar
            </button>
          </div>
        </div>
      </div>
    </div>

  
    <div class="d-flex justify-content-between align-items-center mt-3 mt-sm-5">
      <div>
        Página {{ users.current_page }} de {{ users.last_page }}
      </div>
      <div>
        <button class="btn btn-outline-secondary me-2" :disabled="users.current_page === 1"
          @click="changePage(users.current_page - 1)">
          ← Anterior
        </button>
        <button class="btn btn-outline-secondary" :disabled="users.current_page === users.last_page"
          @click="changePage(users.current_page + 1)">
          Siguiente →
        </button>
      </div>
    </div>

    
    <div class="text-end mt-4">
      <router-link to="/inicio" class="btn btn-primary">
        ← Volver a inicio
      </router-link>
    </div>

    
    <UserFormModal v-if="showCreateModal" @close="showCreateModal = false" @saved="fetchUsers" />
    <UserFormModal v-if="editingUser" :user="editingUser" @close="editingUser = null" @saved="fetchUsers" />
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import axios from 'axios'
import Swal from 'sweetalert2'
import UserFormModal from './UserFormModal.vue'

const users = ref({})
const showCreateModal = ref(false)
const editingUser = ref(null)
const search = ref('')
const page = ref(1)
const perPage = 12

const fetchUsers = async () => {
  const { data } = await axios.get('/api/users', {
    params: {
      search: search.value,
      page: page.value,
      per_page: perPage
    }
  })
  users.value = data
}

const changePage = (newPage) => {
  page.value = newPage
  fetchUsers()
}

const editUser = (user) => {
  editingUser.value = { ...user }
}

const deleteUser = async (id) => {
  const result = await Swal.fire({
    title: "¿Estás seguro que deseas eliminar el usuario?",
    text: "Esta acción no se puede deshacer.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar"
  })

  if (result.isConfirmed) {
    try {
      await axios.delete(`/api/users/${id}`)
      await Swal.fire({
        title: "Eliminado",
        text: "El usuario ha sido eliminado con éxito.",
        icon: "success"
      })
      fetchUsers()
    } catch (error) {
      console.error(error)
      Swal.fire({
        title: "Error",
        text: "No se pudo eliminar el usuario.",
        icon: "error"
      })
    }
  }
}

watch(search, () => {
  page.value = 1
})

onMounted(fetchUsers)
</script>
