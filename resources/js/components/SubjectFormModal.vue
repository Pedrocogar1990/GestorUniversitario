<template>
    <div
        class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex justify-content-center align-items-center z-3">
        <div class="bg-white rounded p-4 w-100"
            style="max-width: 40rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);">
            <h2 class="h5 fw-semibold mb-3">
                {{ subject?.id ? 'Editar' : 'Nueva' }} Asignatura
            </h2>

            <form @submit.prevent="saveSubject">
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input v-model="form.name" type="text" class="form-control" />
                    <div v-if="errors.name" class="text-danger small mt-1">{{ errors.name }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Código</label>
                    <input v-model="form.subjectCode" type="text" class="form-control" />
                    <div v-if="errors.subjectCode" class="text-danger small mt-1">{{ errors.subjectCode }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Créditos</label>
                    <input v-model.number="form.credits" type="number" min="0" class="form-control" />
                    <div v-if="errors.credits" class="text-danger small mt-1">{{ errors.credits }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Carrera</label>
                    <select v-model="form.career_id" class="form-select">
                        <option value="">Seleccione una carrera</option>
                        <option v-for="career in careers" :key="career.id" :value="career.id">
                            {{ career.name }}
                        </option>
                    </select>
                    <div v-if="errors.career_id" class="text-danger small mt-1">{{ errors.career_id }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Profesor</label>
                    <select v-model="form.professor_id" class="form-select">
                        <option value="">Seleccione un profesor</option>
                        <option v-for="professor in professors" :key="professor.id" :value="professor.id">
                            {{ professor.name || professor.nombre }} {{ professor.lastname || professor.apellido }}
                        </option>

                    </select>
                    <div v-if="errors.professor_id" class="text-danger small mt-1">{{ errors.professor_id }}</div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button @click="$emit('close')" type="button" class="btn btn-link text-secondary me-2">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Guardar
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

const props = defineProps({ subject: Object })
const emit = defineEmits(['close', 'saved'])

const form = ref({
    name: '',
    subjectCode: '',
    credits: 0,
    career_id: '',
    professor_id: ''
})

const errors = ref({})

const careers = ref([])
const professors = ref([])

const fetchCareers = async () => {
  const response = await axios.get('/api/careers')
  careers.value = response.data.data
}

const fetchProfessors = async () => {
    try {
        const response = await axios.get('/api/professors')
        professors.value = response.data.data 
    } catch (error) {
        console.error('Error al cargar profesores:', error)
        professors.value = []
    }
}


const saveSubject = async () => {
    errors.value = {}
    try {
        if (props.subject?.id) {
            await axios.put(`/api/subjects/${props.subject.id}`, form.value)
        } else {
            await axios.post('/api/subjects', form.value)
        }
        emit('saved')
        emit('close')

        Swal.fire({
            position: "center",
            icon: "success",
            title: "Operación realizada con éxito",
            showConfirmButton: false,
            timer: 1500
        });
    } catch (e) {
        if (e.response?.status === 422) {
            const backendErrors = e.response.data.errors
            errors.value = {
                name: backendErrors.name ? backendErrors.name[0] : '',
                subjectCode: backendErrors.subjectCode ? backendErrors.subjectCode[0] : '',
                credits: backendErrors.credits ? backendErrors.credits[0] : '',
                career_id: backendErrors.career_id ? backendErrors.career_id[0] : '',
                professor_id: backendErrors.professor_id ? backendErrors.professor_id[0] : ''
            }
        } else {
            console.error(e)
        }
    }
}

const resetForm = () => {
    form.value = {
        name: '',
        subjectCode: '',
        credits: 0,
        career_id: '',
        professor_id: ''
    }
    errors.value = {}
}

watch(
    () => props.subject,
    (newVal) => {
        if (newVal) {
            form.value = {
                name: newVal.name || '',
                subjectCode: newVal.subjectCode || '',
                credits: newVal.credits || 0,
                career_id: newVal.career_id || '',
                professor_id: newVal.professor_id || ''
            }
        } else {
            resetForm()
        }
    },
    { immediate: true }
)

onMounted(() => {
    fetchCareers()
    fetchProfessors()
})
</script>
