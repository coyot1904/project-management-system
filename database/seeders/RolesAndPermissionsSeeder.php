<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);
        
        // Create Permissions
        $createProjectPermission = Permission::create(['name' => 'create-project']);
        $deleteTaskPermission = Permission::create(['name' => 'delete-task']);
                
        // Assign Permissions to Roles
        $adminRole->permissions()->attach([$createProjectPermission->id, $deleteTaskPermission->id]);
        $userRole->permissions()->attach([$createProjectPermission->id]); // Users can only create projects
    }
}
