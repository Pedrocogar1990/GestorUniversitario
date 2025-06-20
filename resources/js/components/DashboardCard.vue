<template>
  <div class="bg-white rounded shadow-sm border border-secondary-subtle p-4 d-flex flex-column justify-content-between h-100 card-hover">
    <div class="d-flex align-items-center gap-3">
      <div class="p-3 rounded-circle bg-light">
        <i :class="`fas fa-${icon} fs-4 text-primary`"></i>
      </div>
      <div>
        <h2 class="h6 fw-semibold text-dark mb-1">{{ title }}</h2>
        <p class="text-muted small mb-0">{{ description }}</p>
      </div>
    </div>
    <router-link
      :to="to"
      class="mt-3 text-primary text-decoration-none align-self-end small fw-medium"
    >
      Ver más →
    </router-link>
  </div>
</template>

<script setup>
defineProps({
  icon: String,
  title: String,
  description: String,
  to: String,
})
</script>

<style scoped>
.card-hover {
  transition: box-shadow 0.3s ease-in-out;
}
.card-hover:hover {
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}
</style>
