<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Create Permissions
    Permission::create(['name' => 'create place']);
    Permission::create(['name' => 'delete place']);
    Permission::create(['name' => 'edit place']);
    Permission::create(['name' => 'update place']);

    Permission::create(['name' => 'create review']);
    Permission::create(['name' => 'delete review']);
    Permission::create(['name' => 'edit review']);
    Permission::create(['name' => 'update review']);

  
    Permission::create(['name' => 'delete user']);
    Permission::create(['name' => 'edit user']);
    Permission::create(['name' => 'update user']);

    // Create Roles
    $adminRole = Role::create(['name' => 'admin']);
    $customerRole = Role::create(['name' => 'customer']);
    $managerRole = Role::create(['name' => 'manager']);

    // Assign Permissions to Roles
    $adminRole->givePermissionTo(['delete place', 'delete place', 'delete review']);
    $customerRole->givePermissionTo(['create review']);
    $managerRole->givePermissionTo(['create place']);

    // // Assign roles to existing users
    // $user = User::find(1); // You can create users in the database manually or via a seeder
    // $user->assignRole('admin');

    // // Optional: You can add more users and assign roles to them
    // $editor = User::find(2);
    // $editor->assignRole('editor');
    
    // $viewer = User::find(3);
    // $viewer->assignRole('viewer');
    }
}
