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
            [
                'name' => 'role',
                'description' => 'Gerenciar perfis de usuários',
            ],
            [
                'name' => 'user',
                'description' => 'Gerenciar usuários',
            ],
            [
                'name' => 'address',
                'description' => 'Gerenciar endereços',
            ],
            [
                'name' => 'phone',
                'description' => 'Gerenciar telefones',
            ],
        ]; // addResources

        $permissions = [
            'listar',
            'mostrar', // 'show' não é usado neste exemplo, mas pode ser usado para mostrar um único recurso
            'criar',
            'editar',
            'deletar',
        ];

        foreach ($resources as $resource) {
            foreach ($permissions as $permission) {
                $res = $resource['name'] . ' ' . $permission;
                Permission::create(['name' => $res, 'description' => $resource['description']]);
            }
        }
        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'Super-admin', 'description' => 'Acesso total ao sistema']);
        $role3 = Role::create(['name' => 'Gerente', 'description' => 'Acesso limitado ao sistema']);
        $role3->syncPermissions(['user listar']);

        $role2 = Role::create(['name' => 'Administrador', 'description' => 'Acesso administrativo ao sistema']);
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
