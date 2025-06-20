<template>
  <div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
      <div class="container">
        <div class="d-flex ms-auto">
          <button class="btn btn-outline-danger" @click="handleLogout">
            Cerrar sesión
          </button>
        </div>
      </div>
    </nav>


    <div class="min-vh-100 bg-light p-4">

      <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mb-4">
        <div>
          <h1 class="display-5 fw-bold text-primary">Bienvenido, Admin</h1>
          <p class="text-muted mt-2">
            Panel principal del sistema de gestión universitaria.
          </p>
        </div>
        <img src="../../media/logo-unigestor.svg" alt="Ilustración universidad" class="img-fluid mt-4 mt-md-0"
          style="width: 12rem;" />
      </div>


      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mb-5">
        <div class="col">
          <div class="bg-white p-3 rounded shadow text-center">
            <p class="h3 fw-bold text-primary">{{ stats.students }}</p>
            <p class="small text-muted">Estudiantes</p>
          </div>
        </div>
        <div class="col">
          <div class="bg-white p-3 rounded shadow text-center">
            <p class="h3 fw-bold text-primary">{{ stats.professors }}</p>
            <p class="small text-muted">Profesores</p>
          </div>
        </div>
        <div class="col">
          <div class="bg-white p-3 rounded shadow text-center">
            <p class="h3 fw-bold text-primary">{{ stats.careers }}</p>
            <p class="small text-muted">Carreras</p>
          </div>
        </div>
        <div class="col">
          <div class="bg-white p-3 rounded shadow text-center">
            <p class="h3 fw-bold text-primary">{{ stats.enrollments }}</p>
            <p class="small text-muted">Matrículas activas</p>
          </div>
        </div>
      </div>


      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <div class="col">
          <DashboardCard icon="users" title="Estudiantes"
            description="Gestiona la información de los alumnos inscritos en la universidad." to="/students" />
        </div>
        <div class="col">
          <DashboardCard icon="chalkboard-teacher" title="Profesores"
            description="Consulta, edita y administra los datos del profesorado." to="/professors" />
        </div>
        <div class="col">
          <DashboardCard icon="book" title="Asignaturas"
            description="Organiza y visualiza las materias impartidas por carrera y profesor." to="/subjects" />
        </div>
        <div class="col">
          <DashboardCard icon="graduation-cap" title="Carreras"
            description="Crea y administra las titulaciones y sus planes de estudio." to="/careers" />
        </div>
        <div class="col">
          <DashboardCard icon="clipboard-list" title="Matrículas"
            description="Registra y gestiona las inscripciones de estudiantes en asignaturas." to="/enrollments" />
        </div>
        <div class="col">
          <DashboardCard icon="user-cog" title="Usuarios"
            description="Administra las cuentas del sistema, roles y permisos." to="/users" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import DashboardCard from '@/components/DashboardCard.vue'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const stats = ref({
  students: 0,
  professors: 0,
  careers: 0,
  enrollments: 0,
})

onMounted(async () => {
  try {
    const { data } = await axios.get('/api/dashboard-data', { withCredentials: true })
    stats.value = data
  } catch (error) {
    console.error('Error al cargar estadísticas:', error)

    if (error.response && error.response.status === 401) {
      router.push('/login')
    }
  }
})

async function handleLogout() {
  try {
    await axios.post('/api/logout', {}, { withCredentials: true })
    router.push('/login')
  } catch (e) {
    console.warn('Error al cerrar sesión en backend', e)
  }
}
</script>
