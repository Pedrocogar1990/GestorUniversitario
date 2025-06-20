# 📚 Gestor Universitario

**Gestor Universitario** es una aplicación web desarrollada con Laravel 10 y Vue 3 que permite la gestión integral de una institución universitaria. A través de una interfaz intuitiva, facilita la administración de estudiantes, profesores, asignaturas, carreras y matrículas.

---

## 🚀 Funcionalidades principales

- Gestión de estudiantes, profesores, carreras y asignaturas.
- Inscripción de estudiantes en asignaturas.
- Sistema de autenticación y roles (administrador, profesor, alumno).
- Panel de administración con vistas dinámicas usando Vue 3 e Inertia.js.
- Alertas y confirmaciones visuales con SweetAlert2.

---

## 🎯 Público objetivo

Este sistema está orientado a universidades, centros educativos, y desarrolladores que deseen una base para proyectos de gestión académica.

---

## 🧩 Tecnologías utilizadas

### Backend

- **PHP 8.1**
- **Laravel 10.10**
- **Laravel Sanctum** – Autenticación con SPA.
- **Spatie Laravel Permission** – Gestión avanzada de roles y permisos.
- **Guzzle** – Cliente HTTP para consumo de APIs.
- **Tinker** – Entorno interactivo para Laravel.

### Frontend

- **Vue 3.5.16**
- **Vite 5** – Compilación moderna de frontend.
- **Vue Router 4.5.1** – Ruteo SPA.
- **Axios 1.6.4** – Cliente HTTP.
- **SweetAlert2 11.22.0** – Alertas visuales.
- **Bootstrap 5.3.6** – Estilos básicos (parcial).

---

## 🛠️ Instalación del proyecto

```bash
git clone git@github.com:Pedrocogar1990/GestorUniversitario.git
cd GestorUniversitario

# Instalar dependencias PHP
composer install

# Instalar dependencias JS
npm install

# Generar archivo .env
cp .env.example .env
php artisan key:generate

# Ejecutar migraciones y seeders
php artisan migrate --seed

# Compilar assets
npm run dev
