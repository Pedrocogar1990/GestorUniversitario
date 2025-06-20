<template>
  <div
    class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex justify-content-center align-items-center z-3"
  >
    <div
      class="bg-white rounded p-4 w-100"
      style="max-width: 40rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);"
    >
      <h2 class="h5 fw-semibold mb-3">
        {{ form.id ? 'Editar' : 'Nuevo' }} Usuario
      </h2>

      <form @submit.prevent="saveUser">
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input v-model="form.name" type="text" class="form-control" />
          <div v-if="errors.name" class="text-danger small mt-1">{{ errors.name }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input v-model="form.email" type="email" class="form-control" />
          <div v-if="errors.email" class="text-danger small mt-1">{{ errors.email }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Contraseña</label>
          <input
            v-model="form.password"
            type="password"
            class="form-control"
            :required="!form.id"
          />
          <div v-if="errors.password" class="text-danger small mt-1">
            {{ errors.password }}
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Confirmar Contraseña</label>
          <input
            v-model="form.password_confirmation"
            type="password"
            class="form-control"
            :required="!form.id"
          />
        </div>

        <fieldset class="mb-3">
          <legend>Rol</legend>
          <div v-for="role in roles" :key="role.id" class="form-check">
            <input
              type="radio"
              :value="role.name"
              v-model="form.role"
              :id="'role-' + role.id"
              class="form-check-input"
              name="user-role"
            />
            <label :for="'role-' + role.id" class="form-check-label">{{ role.name }}</label>
          </div>
          <div v-if="errors.role" class="text-danger small mt-1">{{ errors.role }}</div>
        </fieldset>

        <div class="d-flex justify-content-end mt-4">
          <button
            @click="$emit('close')"
            type="button"
            class="btn btn-link text-secondary me-2"
            :disabled="loading"
          >
            Cancelar
          </button>
          <button type="submit" class="btn btn-primary" :disabled="loading">
            {{ loading ? 'Guardando...' : 'Guardar' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import axios from 'axios'
import Swal from 'sweetalert2'

const props = defineProps({ user: Object })
const emit = defineEmits(['close', 'saved'])

const form = ref({
  id: null,
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  role: '' 
})

const errors = ref({})
const roles = ref([])
const loading = ref(false)

const loadRoles = async () => {
  try {
    const { data } = await axios.get('/api/roles')
    roles.value = data
  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'No se pudieron cargar los roles'
    })
  }
}

const resetForm = () => {
  form.value = {
    id: null,
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: ''
  }
  errors.value = {}
}

watch(
  () => props.user,
  (newUser) => {
    if (newUser) {
      form.value = {
        id: newUser.id,
        name: newUser.name || '',
        email: newUser.email || '',
        password: '',
        password_confirmation: '',
        role: newUser.roles?.[0]?.name || '' 
      }
    } else {
      resetForm()
    }
  },
  { immediate: true }
)

const saveUser = async () => {
  loading.value = true
  errors.value = {}
  try {
    if (form.value.id) {
      await axios.put(`/api/users/${form.value.id}`, form.value)
    } else {
      await axios.post('/api/users', form.value)
    }
    Swal.fire({
      icon: 'success',
      title: 'Éxito',
      text: 'Usuario guardado correctamente'
    })
    emit('saved')
    emit('close')
  } catch (error) {
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Error al guardar el usuario'
      })
    }
  } finally {
    loading.value = false
  }
}

onMounted(loadRoles)
</script>
