<template>
  <section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

              <form @submit.prevent="handleLogin">
                <div class="mb-md-5 mt-md-4 pb-5">
                  <h2 class="fw-bold mb-5">Inicia sesión</h2>

                  <div class="form-outline form-white mb-4">
                    <input v-model="email" type="email" id="typeEmailX" class="form-control form-control-lg" required />
                    <label class="form-label" for="typeEmailX">Email</label>
                  </div>

                  <div class="form-outline form-white mb-4">
                    <input v-model="password" type="password" id="typePasswordX" class="form-control form-control-lg" required />
                    <label class="form-label" for="typePasswordX">Contraseña</label>
                  </div>

                  <button class="btn btn-outline-light btn-lg px-5" type="submit">
                    Iniciar sesión
                  </button>

                  <div v-if="error" class="text-danger mt-3">{{ error }}</div>
                </div>

                <div>
                  <p class="mb-0">¿No tienes cuenta?
                    <router-link to="/register" class="text-white-50 fw-bold">Regístrate</router-link>
                  </p>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const email = ref('')
const password = ref('')
const error = ref(null)
const router = useRouter()

const handleLogin = async () => {
  try {
    
    await axios.get('/sanctum/csrf-cookie', { withCredentials: true })

    
    const { data } = await axios.post('/api/login', {
      email: email.value,
      password: password.value
    }, { withCredentials: true })

 
    const roles = data.user.roles.map(role => role.name)

    if (roles.includes('admin')) {
      router.push('/inicio')
    } else if (roles.includes('student')) {
      router.push('/dashboard-students')
    } else if (roles.includes('professor')) {
      router.push('/dashboard-professors')
    } else {
      router.push('/login')
    }

  } catch (err) {
    if (err.response?.status === 422) {
      error.value = Object.values(err.response.data.errors).flat().join(', ')
    } else if (err.response?.status === 401) {
      error.value = 'Credenciales incorrectas'
    } else {
      error.value = 'Error al iniciar sesión'
    }
  }
}
</script>
