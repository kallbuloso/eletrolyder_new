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
                'generates_revenue' => false,
            ],
            [
                'name' => 'Garantia Loja',
                'status_type' => 0,
                'generates_revenue' => false,
            ],
            [
                'name' => 'Garantia Fabricante',
                'status_type' => 0,
                'generates_revenue' => false,
            ],
            [
                'name' => 'Orçamento em andamento',
                'status_type' => 1,
                'generates_revenue' => true,
            ],
            [
                'name' => 'Orçamento finalizado',
                'status_type' => 1,
                'generates_revenue' => true,
            ],
            [
                'name' => 'Conserto Aprovado',
                'status_type' => 1,
                'generates_revenue' => true,
            ],
            [
                'name' => 'Conserto em andamento',
                'status_type' => 1,
                'generates_revenue' => true,
            ],
            [
                'name' => 'Conserto Finalizado',
                'status_type' => 1,
                'generates_revenue' => true,
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
        if (SoStatus::where('tenant_id', $tenantId)->count() === 0) {
            $this->createDefaultSoStatus($tenantId);
        }
        SoStatus::factory()->create([
            'tenant_id' => $tenantId,
        ]);
    }

    /**
     * Create a default SO status.
     */
    public function createDefaultSoStatus($tenantId): void
    {
        SoStatus::factory()->create([
            'tenant_id' => $tenantId,
            'description' => 'Default Status',
            'status_type' => 0, // Default type
            'generates_revenue' => true, // Default revenue generation
        ]);
    }
}
