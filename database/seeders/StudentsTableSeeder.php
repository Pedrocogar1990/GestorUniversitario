<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Career;
use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
       public function run()
    {
        $careers = Career::all();
        $students = [
            ['name' => 'Juan', 'lastName' => 'Pérez', 'dni' => '10000001', 'email' => 'juan.perez@university.edu', 'birthDate' => '2000-05-15', 'career_id' => $careers->where('careerCode', 'IS-001')->first()->id],
            ['name' => 'María', 'lastName' => 'Gómez', 'dni' => '10000002', 'email' => 'maria.gomez@university.edu', 'birthDate' => '1999-08-20', 'career_id' => $careers->where('careerCode', 'MED-002')->first()->id],
            ['name' => 'Luis', 'lastName' => 'Martínez', 'dni' => '10000003', 'email' => 'luis.martinez@university.edu', 'birthDate' => '2001-03-10', 'career_id' => $careers->where('careerCode', 'ADM-003')->first()->id],
            ['name' => 'Ana', 'lastName' => 'Rodríguez', 'dni' => '10000004', 'email' => 'ana.rodriguez@university.edu', 'birthDate' => '2000-07-22', 'career_id' => $careers->where('careerCode', 'DER-004')->first()->id],
            ['name' => 'Carlos', 'lastName' => 'López', 'dni' => '10000005', 'email' => 'carlos.lopez@university.edu', 'birthDate' => '1998-11-05', 'career_id' => $careers->where('careerCode', 'PSI-005')->first()->id],
            ['name' => 'Sofía', 'lastName' => 'Díaz', 'dni' => '10000006', 'email' => 'sofia.diaz@university.edu', 'birthDate' => '2002-02-18', 'career_id' => $careers->where('careerCode', 'ARQ-006')->first()->id],
            ['name' => 'Javier', 'lastName' => 'Hernández', 'dni' => '10000007', 'email' => 'javier.hernandez@university.edu', 'birthDate' => '1999-09-30', 'career_id' => $careers->where('careerCode', 'IC-007')->first()->id],
            ['name' => 'Patricia', 'lastName' => 'Sánchez', 'dni' => '10000008', 'email' => 'patricia.sanchez@university.edu', 'birthDate' => '2000-04-12', 'career_id' => $careers->where('careerCode', 'ENF-008')->first()->id],
            ['name' => 'Miguel', 'lastName' => 'Ramírez', 'dni' => '10000009', 'email' => 'miguel.ramirez@university.edu', 'birthDate' => '2001-01-25', 'career_id' => $careers->where('careerCode', 'BIO-009')->first()->id],
            ['name' => 'Lucía', 'lastName' => 'Flores', 'dni' => '10000010', 'email' => 'lucia.flores@university.edu', 'birthDate' => '1999-06-08', 'career_id' => $careers->where('careerCode', 'ECO-010')->first()->id],
            ['name' => 'Alejandro', 'lastName' => 'Castro', 'dni' => '10000011', 'email' => 'alejandro.castro@university.edu', 'birthDate' => '2000-12-03', 'career_id' => $careers->where('careerCode', 'COM-011')->first()->id],
            ['name' => 'Elena', 'lastName' => 'Ortega', 'dni' => '10000012', 'email' => 'elena.ortega@university.edu', 'birthDate' => '1998-10-17', 'career_id' => $careers->where('careerCode', 'QUI-012')->first()->id],
            ['name' => 'Daniel', 'lastName' => 'Vargas', 'dni' => '10000013', 'email' => 'daniel.vargas@university.edu', 'birthDate' => '2001-07-09', 'career_id' => $careers->where('careerCode', 'MAT-013')->first()->id],
        ];

        Student::insert($students);
    }
}