<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Client;
use App\Models\Tenant;
use App\Models\Company;
use App\Models\SoStatus;
use App\Models\Supplier;
use App\Models\SoDevicesType;
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

        // $tenantQtd = 1;
        $userQtd = 10;
        $clientQtd = 120;
        $supplierQtd = 150;

        $tenant = Tenant::factory()->create([
            'status' => 0, // 0 - Ativo, 1 - Inativo, 2 - Bloqueado
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
        $this->createSoDevicesType($tenant->id);

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

    private function createTenant($tenantQtd = 2, $userQtd = 3, $clientQtd = 100): void
    {
        for ($i = 0; $i < $tenantQtd; $i++) {
            // $person = fake()->randomElement(['F', 'J']);
            $status = fake()->randomElement([0, 1, 2]);
            $tenant = Tenant::factory()->create([
                'status' => $status,
                'blocking_reason' => $status === 2 ? fake()->sentence() : null,
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

            $this->createSoStatuses($tenant->id);

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

    /**
     * Create default service order devices.
     *
     * @param int $tenantId
     * @return void
     */
    public function createSoDevicesType($tenantId): void
    {
        $devices = [
            [
                'description' => 'Celular',
            ],
            [
                'description' => 'Tablet',
            ],
            [
                'description' => 'Notebook',
            ],
            [
                'description' => 'Desktop',
            ],
            [
                'description' => 'Impressora',
            ],
            [
                'description' => 'Monitor',
            ],
            [
                'description' => 'TV',
            ],
            [
                'description' => 'System',
            ],
            [
                'description' => 'Videogame',
            ],
            [
                'description' => 'Equipamento de áudio profissional',
            ],
            [
                'description' => 'Equipamento de laboratório',
            ],
        ];

        foreach ($devices as $device) {
            SoDevicesType::create([
                'tenant_id' => $tenantId,
                'description' => $device['description'],
                'is_active' => fake()->boolean(), // Assuming all devices are active by default
            ]);
        }
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
                'generates_revenue' => true,
                'status_steps' => [
                    'Aguardando avaliação de técnico',
                    'Orçamento em andamento',
                ]
            ],
            [
                'name' => 'Garantia da Loja',
                'status_type' => 0,
                'generates_revenue' => false,
                'status_steps' => [
                    'Aguardando avaliação de técnico',
                    'Aguardando peças',
                    'Conserto em andamento',
                ]
            ],
            [
                'name' => 'Garantia do Fabricante',
                'status_type' => 0,
                'generates_revenue' => false,
                'status_steps' => [
                    'Aguardando avaliação de técnico',
                    'Aguardando peças',
                    'Conserto em andamento',
                ]
            ],
            [
                'name' => 'Orçamento em andamento',
                'status_type' => 1,
                'generates_revenue' => true,
                'status_steps' => [
                    'Aguardando peças para concluir orçamento',
                    'Aguardando cotação de peças',
                ]
            ],
            [
                'name' => 'Orçamento finalizado',
                'status_type' => 1,
                'generates_revenue' => true,
                'status_steps' => [
                    'Aguardando aprovação do cliente',
                ]
            ],
            [
                'name' => 'Conserto Aprovado',
                'status_type' => 1,
                'generates_revenue' => true,
                'status_steps' => [
                    'Aguardando peças',
                    'Aguardando Conserto',
                ]
            ],
            [
                'name' => 'Conserto em andamento',
                'status_type' => 1,
                'generates_revenue' => true,
                'status_steps' => [
                    'Aguardando restante de peças',
                    'Aparelho em testes',
                    'Conserto em andamento',
                ]
            ],
            [
                'name' => 'Conserto Finalizado',
                'status_type' => 1,
                'generates_revenue' => true,
                'status_steps' => [
                    'Aguardando iformar ao cliente',
                    'Aguardando retirada do aparelho',
                ]
            ],
            [
                'name' => 'Entregue reparado',
                'status_type' => 2,
                'generates_revenue' => true
            ],
            [
                'name' => 'Entregue (sem garantia)',
                'status_type' => 2,
                'generates_revenue' => false
            ],
            [
                'name' => 'Entregue (sem conserto)',
                'status_type' => 2,
                'generates_revenue' => false
            ],
            [
                'name' => 'Entregue (cortesia)',
                'status_type' => 2,
                'generates_revenue' => false
            ],
            [
                'name' => 'Entregue sem reparo',
                'status_type' => 2,
                'generates_revenue' => false
            ],
        ];

        // $statuses = collect($statuses)->map(function ($status) {
        //     return [
        //         'name' => $status['name'],
        //         'status_type' => $status['status_type'],
        //         'generates_revenue' => $status['generates_revenue'],
        //     ];
        // })->toArray();

        $statusSteps = [
            [
                'description' => 'Aguardando orçamento',
            ],
            [
                'description' => 'Orçamento enviado',
            ],
            [
                'description' => 'Aguardando aprovação do cliente',
            ],
            [
                'description' => 'Aguardando peças',
            ],
            [
                'description' => 'Em conserto',
            ],
            [
                'description' => 'Conserto finalizado',
            ],
        ];

        foreach ($statuses as $status) {
            $statusCreate = SoStatus::factory()->create([
                'tenant_id' => $tenantId,
                'description' => $status['name'],
                'status_type' => $status['status_type'],
                'generates_revenue' => $status['generates_revenue'],
            ]);

            // Criação dos status_steps relacionados, se existirem
            if (!empty($status['status_steps'])) {
                foreach ($status['status_steps'] as $stepDescription) {
                    $statusCreate->statusSteps()->create([
                        'tenant_id' => $tenantId,
                        'description' => $stepDescription,
                    ]);
                }
            }
        }
        // Create a default status if none exist
        // if (SoStatus::where('tenant_id', $tenantId)->count() === 0) {
        //     $this->createDefaultSoStatus($tenantId);
        // }
        // SoStatus::factory()->create([
        //     'tenant_id' => $tenantId,
        // ]);
    }
}
