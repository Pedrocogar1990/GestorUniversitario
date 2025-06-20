<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <div class="d-flex ms-auto">
                <button class="btn btn-outline-danger" @click="handleLogout">
                    Cerrar sesión
                </button>
            </div>
        </div>
    </nav>
    <div>
        <h1>Dashboard Estudiantes</h1>
        <p>Bienvenido al panel de control de estudiantes.</p>
    </div>
   
</template>

<script setup>
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()

async function handleLogout() {
  try {
    const token = localStorage.getItem('token')
    console.log('Token antes de logout:', token)
    
    await axios.post('/api/logout')
    console.log('Logout OK')
  } catch (e) {
    console.warn('Error al cerrar sesión en backend', e.response?.data || e)
  } finally {
    localStorage.removeItem('token')
    router.push('/login')
  }
}
</script>

