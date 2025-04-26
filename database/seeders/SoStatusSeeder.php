<?php

namespace Database\Seeders;

use App\Models\SoStatus;

class SoStatusSeeder
{
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
        SoStatus::factory()->create([
            'tenant_id' => $tenantId,
        ]);
    }
}
