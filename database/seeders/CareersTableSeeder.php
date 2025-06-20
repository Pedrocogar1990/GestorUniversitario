<?php

namespace Database\Seeders;

use App\Models\Career;
use Illuminate\Database\Seeder;

class CareersTableSeeder extends Seeder
{
    public function run()
    {
        $careers = [
            ['name' => 'Ingeniería en Sistemas', 'description' => 'Desarrollo de software y redes.', 'careerCode' => 'IS-001', 'duration' => 5],
            ['name' => 'Medicina', 'description' => 'Diagnóstico y tratamiento de enfermedades.', 'careerCode' => 'MED-002', 'duration' => 6],
            ['name' => 'Administración', 'description' => 'Gestión de empresas.', 'careerCode' => 'ADM-003', 'duration' => 4],
            ['name' => 'Derecho', 'description' => 'Leyes y sistema judicial.', 'careerCode' => 'DER-004', 'duration' => 5],
            ['name' => 'Psicología', 'description' => 'Estudio de la mente humana.', 'careerCode' => 'PSI-005', 'duration' => 4],
            ['name' => 'Arquitectura', 'description' => 'Diseño de estructuras y espacios.', 'careerCode' => 'ARQ-006', 'duration' => 5],
            ['name' => 'Ingeniería Civil', 'description' => 'Construcción de infraestructura.', 'careerCode' => 'IC-007', 'duration' => 5],
            ['name' => 'Enfermería', 'description' => 'Cuidado de pacientes.', 'careerCode' => 'ENF-008', 'duration' => 4],
            ['name' => 'Biología', 'description' => 'Estudio de organismos vivos.', 'careerCode' => 'BIO-009', 'duration' => 4],
            ['name' => 'Economía', 'description' => 'Análisis de mercados y recursos.', 'careerCode' => 'ECO-010', 'duration' => 4],
            ['name' => 'Comunicación', 'description' => 'Medios y periodismo.', 'careerCode' => 'COM-011', 'duration' => 4],
            ['name' => 'Química', 'description' => 'Estudio de la materia.', 'careerCode' => 'QUI-012', 'duration' => 4],
            ['name' => 'Matemáticas', 'description' => 'Ciencias exactas y aplicadas.', 'careerCode' => 'MAT-013', 'duration' => 4],
        ];

        Career::insert($careers);
    }
}