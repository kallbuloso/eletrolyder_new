<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Client;
use App\Models\Tenant;
use App\Models\Company;
use App\Models\SoStatus;
use App\Models\Supplier;
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

        // $tenantQtd = 1;
        $userQtd = 10;
        $clientQtd = 120;
        $supplierQtd = 150;

        $tenant = Tenant::factory()->create([
            'status' => 'A',
            'blocking_reason' => null,
        ]);

        Company::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        Client::factory($clientQtd)->create([
            'tenant_id' => $tenant->id,
        ]);

        Supplier::factory($supplierQtd)->create([
            'tenant_id' => $tenant->id,
        ]);

        $this->createSoStatuses($tenant->id);
        // SoStatus::factory(10)->create([
        //     'tenant_id' => $tenant->id,
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

        // $this->createTenant($tenantQtd, $userQtd, $clientQtd);
    }
    
    /**
     * Run the database seeds.
     */
    public function createSoStatuses($tenantId): void
    {
        $statuses = [
            [
                'name' => 'Entrada para orçamento',
                'status_type' => 0,
                'generates_revenue' => 0
            ],
            [
                'name' => 'Garantia Loja',
                'status_type' => 0,
                'generates_revenue' => 1
            ],
            [
                'name' => 'Garantia Fabricante',
                'status_type' => 0,
                'generates_revenue' => 0
            ],
            [
                'name' => 'Orçamento em andamento',
                'status_type' => 1,
                'generates_revenue' => 1
            ],
            [
                'name' => 'Orçamento finalizado',
                'status_type' => 1,
                'generates_revenue' => 0
            ],
            [
                'name' => 'Conserto Aprovado',
                'status_type' => 1,
                'generates_revenue' => 1
            ],
            [
                'name' => 'Conserto em andamento',
                'status_type' => 1,
                'generates_revenue' => 1
            ],
            [
                'name' => 'Conserto Finalizado',
                'status_type' => 1,
                'generates_revenue' => 1
            ],
        ];

        foreach ($statuses as $status) {
            SoStatus::factory()->create([
                'tenant_id' => $tenantId,
                'description' => $status['name'],
                'status_type' => $status['status_type'],
                'generates_revenue' => $status['generates_revenue'],
            ]);
        }
        // Create a default status if none exist
        // if (SoStatus::where('tenant_id', $tenantId)->count() === 0) {
        //     $this->createDefaultSoStatus($tenantId);
        // }
        // SoStatus::factory()->create([
        //     'tenant_id' => $tenantId,
        // ]);
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

            Client::factory($clientQtd)->create([
                'tenant_id' => $tenant->id,
            ]);

            Supplier::factory($clientQtd)->create([
                'tenant_id' => $tenant->id,
            ]);


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
