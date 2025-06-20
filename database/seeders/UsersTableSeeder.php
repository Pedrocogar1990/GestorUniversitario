<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('admin123'),
            ]
        );
        $admin->assignRole('admin');


        $student = User::firstOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Student User',
                'password' => bcrypt('student123'),
            ]
        );
        $student->assignRole('student');

        
        $professor = User::firstOrCreate(
            ['email' => 'professor@example.com'],
            [
                'name' => 'Professor User',
                'password' => bcrypt('professor123'),
            ]
        );
        $professor->assignRole('professor');
    }
}
