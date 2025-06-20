<?php

namespace Database\Seeders;

use App\Models\Professor;
use Illuminate\Database\Seeder;

class ProfessorsTableSeeder extends Seeder
{
     public function run()
    {
        $professors = [
            ['name' => 'Carlos', 'lastname' => 'Mendoza', 'dni' => '12345678', 'tutor' => true, 'email' => 'carlos.mendoza@university.edu', 'department' => 'Ciencias de la Computación'],
            ['name' => 'Ana', 'lastname' => 'Gómez', 'dni' => '87654321', 'tutor' => false, 'email' => 'ana.gomez@university.edu', 'department' => 'Medicina'],
            ['name' => 'Luis', 'lastname' => 'Torres', 'dni' => '11223344', 'tutor' => true, 'email' => 'luis.torres@university.edu', 'department' => 'Derecho'],
            ['name' => 'María', 'lastname' => 'Fernández', 'dni' => '44332211', 'tutor' => false, 'email' => 'maria.fernandez@university.edu', 'department' => 'Psicología'],
            ['name' => 'Jorge', 'lastname' => 'Ramírez', 'dni' => '55667788', 'tutor' => true, 'email' => 'jorge.ramirez@university.edu', 'department' => 'Arquitectura'],
            ['name' => 'Laura', 'lastname' => 'Díaz', 'dni' => '88776655', 'tutor' => false, 'email' => 'laura.diaz@university.edu', 'department' => 'Ingeniería Civil'],
            ['name' => 'Pedro', 'lastname' => 'Sánchez', 'dni' => '99001122', 'tutor' => true, 'email' => 'pedro.sanchez@university.edu', 'department' => 'Enfermería'],
            ['name' => 'Sofía', 'lastname' => 'López', 'dni' => '22110099', 'tutor' => false, 'email' => 'sofia.lopez@university.edu', 'department' => 'Biología'],
            ['name' => 'Ricardo', 'lastname' => 'Martínez', 'dni' => '33445566', 'tutor' => true, 'email' => 'ricardo.martinez@university.edu', 'department' => 'Economía'],
            ['name' => 'Elena', 'lastname' => 'García', 'dni' => '66554433', 'tutor' => false, 'email' => 'elena.garcia@university.edu', 'department' => 'Comunicación'],
            ['name' => 'Fernando', 'lastname' => 'Hernández', 'dni' => '77889900', 'tutor' => true, 'email' => 'fernando.hernandez@university.edu', 'department' => 'Química'],
            ['name' => 'Isabel', 'lastname' => 'Ruiz', 'dni' => '00998877', 'tutor' => false, 'email' => 'isabel.ruiz@university.edu', 'department' => 'Matemáticas'],
            ['name' => 'Diego', 'lastname' => 'Jiménez', 'dni' => '12348765', 'tutor' => true, 'email' => 'diego.jimenez@university.edu', 'department' => 'Ingeniería en Sistemas'],
        ];

        Professor::insert($professors);
    }
}
