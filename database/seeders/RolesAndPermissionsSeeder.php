<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
          
            'create student', 'read student', 'edit student', 'delete student',
          
            'create professor', 'read professor', 'edit professor', 'delete professor',
          
            'create subject', 'read subject', 'edit subject', 'delete subject',
         
            'create career', 'read career', 'edit career', 'delete career',
      
            'create enrollment', 'read enrollment', 'edit enrollment', 'delete enrollment',
            
            'create user', 'read user', 'edit user', 'delete user',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);
        $professorRole = Role::firstOrCreate(['name' => 'professor']);

       
        $adminRole->syncPermissions($permissions);

    }
}
