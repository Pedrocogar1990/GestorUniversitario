<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Database\Seeders\CareersTableSeeder;
use Database\Seeders\ProfessorsTableSeeder;
use Database\Seeders\StudentsTableSeeder;
use Database\Seeders\SubjectsTableSeeder;
use Database\Seeders\EnrollmentsTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UsersTableSeeder::class,
            CareersTableSeeder::class,
            ProfessorsTableSeeder::class,
            StudentsTableSeeder::class,
            SubjectsTableSeeder::class,
            EnrollmentsTableSeeder::class, 
        ]);
    }
}
