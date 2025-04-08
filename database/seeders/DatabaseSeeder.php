<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tenant;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
        ]);
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'karl@admim.com',
        // ]);

        $tenantQtd = 2;
        $userQtd = 3;
        $clientQtd = 10;

        $tenant = Tenant::factory()->create([
            'status' => 'A',
            'blocking_reason' => null,
        ]);

        Company::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        // Client::factory($clientQtd)->create([
        //   'tenant_id' => $tenant->id,
        // ]);

        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
            'name' => 'Test User',
            'email' => 'karl@admim.com',
        ]);

        $role = Role::create(['tenant_id' => $tenant->id, 'name' => 'Administrador', 'description' => 'Acesso total ao sistema']);
        $gerente = Role::create(['tenant_id' => $tenant->id, 'name' => 'Gerente', 'description' => 'Acesso limitado ao sistema']);
        $atendente = Role::create(['tenant_id' => $tenant->id, 'name' => 'Atendente', 'description' => 'Acesso limitado ao sistema']);
        $tecnico = Role::create(['tenant_id' => $tenant->id, 'name' => 'Técnico', 'description' => 'Acesso limitado ao sistema']);
        $role->syncPermissions(Permission::all());
        setPermissionsTeamId($tenant->id);
        $user->assignRole([$role]);

        for ($j = 0; $j < $userQtd; $j++) {
            $user = User::factory()->create([
                'tenant_id' => $tenant->id,
            ]);

            if ($j === 0) {
                $tecnico->syncPermissions(Permission::all());
                setPermissionsTeamId($tenant->id);
                $user->assignRole([$tecnico]);
            } elseif ($j === 1) {
                $user->assignRole([$gerente]);
            } else {
                $user->assignRole([$atendente]);
            }
        }

        $this->createTenant($tenantQtd, $userQtd, $clientQtd);
    }

    private function createTenant($tenantQtd = 2, $userQtd = 3, $clientQtd = 100): void
    {
        for ($i = 0; $i < $tenantQtd; $i++) {
            // $person = fake()->randomElement(['F', 'J']);
            $status = fake()->randomElement(['A', 'I', 'B']);
            $tenant = Tenant::factory()->create([
                'status' => $status,
                'blocking_reason' => $status === 'B' ? fake()->sentence() : null,
            ]);

            Company::factory()->create([
                'tenant_id' => $tenant->id,
            ]);

            // Client::factory($clientQtd)->create([
            //   'tenant_id' => $tenant->id,
            // ]);


            $user = User::factory()->create([
                'tenant_id' => $tenant->id,
                'name' => "Test User {$tenant->id}",
            ]);

            $role = Role::create(['tenant_id' => $tenant->id, 'name' => 'Administrador']);
            $gerente = Role::create(['tenant_id' => $tenant->id, 'name' => 'Gerente']);
            $atendente = Role::create(['tenant_id' => $tenant->id, 'name' => 'Atendente']);
            $tecnico = Role::create(['tenant_id' => $tenant->id, 'name' => 'Técnico']);
            $role->syncPermissions(Permission::all());
            setPermissionsTeamId($tenant->id);
            $user->assignRole([$role]);

            for ($j = 0; $j < $userQtd; $j++) {
                $user = User::factory()->create([
                    'tenant_id' => $tenant->id,
                ]);

                if ($j === 0) {
                    $tecnico->syncPermissions(Permission::all());
                    setPermissionsTeamId($tenant->id);
                    $user->assignRole([$tecnico]);
                } elseif ($j === 1) {
                    $user->assignRole([$gerente]);
                } else {
                    $user->assignRole([$atendente]);
                }
            }
        }
    }
}
