<template>
  <section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

              <div class="mb-md-5 mt-md-4 pb-5">

                <h2 class="fw-bold mb-2 text-uppercase">Registro</h2>
                <p class="text-white-50 mb-5">¡Crea tu cuenta para comenzar!</p>

                <div class="form-outline form-white mb-4">
                  <input v-model="name" type="text" id="name" class="form-control form-control-lg" required />
                  <label class="form-label" for="name">Nombre</label>
                </div>

                <div class="form-outline form-white mb-4">
                  <input v-model="lastName" type="text" id="lastName" class="form-control form-control-lg" required />
                  <label class="form-label" for="lastName">Apellidos</label>
                </div>

                <div class="form-outline form-white mb-4">
                  <input v-model="email" type="email" id="email" class="form-control form-control-lg" required />
                  <label class="form-label" for="email">Correo electrónico</label>
                </div>

                <div class="form-outline form-white mb-4">
                  <input v-model="password" type="password" id="password" class="form-control form-control-lg" required />
                  <label class="form-label" for="password">Contraseña</label>
                </div>

                <div class="form-outline form-white mb-4">
                  <input v-model="confirmPassword" type="password" id="confirmPassword" class="form-control form-control-lg" required />
                  <label class="form-label" for="confirmPassword">Confirmar contraseña</label>
                </div>

                <button @click="handleRegister" class="btn btn-outline-light btn-lg px-5" type="submit">Registrarse</button>

                <div v-if="error" class="text-danger mt-3">{{ error }}</div>

              </div>

              <div>
                <p class="mb-0">¿Ya tienes cuenta?
                  <router-link to="/login" class="text-white-50 fw-bold">Inicia sesión</router-link>
                </p>
              </div>

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

const name = ref('')
const lastName = ref('')
const email = ref('')
const password = ref('')
const confirmPassword = ref('')
const error = ref(null)
const router = useRouter()

const handleRegister = async () => {
  if (password.value !== confirmPassword.value) {
    error.value = 'Las contraseñas no coinciden'
    return
  }

  try {
    await axios.post('/api/register', {
      name: name.value,
      lastName: lastName.value,
      email: email.value,
      password: password.value,
      password_confirmation: confirmPassword.value,
    })

    router.push('/login')
  } catch (err) {
    error.value = err.response?.data?.message || 'Error al registrarse'
  }
}

</script>
