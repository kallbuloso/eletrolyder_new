<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createPermissions();
    }

    public function createPermissions(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $resources = [
            'role',
            'user'
        ];

        $permissions = [
            'list',
            'show', // 'show' não é usado neste exemplo, mas pode ser usado para mostrar um único recurso
            'create',
            'edit',
            'delete',
        ];

        foreach ($resources as $resource) {
            foreach ($permissions as $permission) {
                $res = $resource . ' ' . $permission;

                Permission::create(['name' => $res]);
            }
        }
        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'Super-admin']);
        $role3 = Role::create(['name' => 'Gerente']);
        $role3->syncPermissions(['user list']);

        $role2 = Role::create(['name' => 'Administrador']);
        $role2->syncPermissions(Permission::all());


        $user = \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'karl@admim.com',
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Example User',
            'email' => 'test@example.com',
        ]);
        $user->assignRole($role3);
    }
}
