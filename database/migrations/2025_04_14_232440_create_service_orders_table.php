<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained();
            // References to status and step (lookup tables)
            $table->foreignId('client_id')->nullable()->constrained(); // Cliente
            $table->foreignId('so_status_id')->nullable()->constrained('so_statuses'); // Status
            $table->foreignId('so_step_id')->nullable()->constrained('so_status_steps'); // Etapa do status
            // Equipment relation
            $table->foreignId('so_equipment_id')->nullable()->constrained('so_equipments'); // Equipamento
            $table->string('order_number')->unique(); // Ordem de serviço
            // Warranty expiration date
            $table->date('warranty_expires_on')->nullable(); // Vencimento da garantia
            // Monetary values
            $table->decimal('labor_cost', 10, 2)->nullable(); // Custos de mão de obra
            $table->decimal('parts_cost', 10, 2)->nullable(); // Custos de peças
            $table->decimal('service_cost', 10, 2)->nullable(); // Custos de serviço
            $table->decimal('discount', 10, 2)->nullable(); // Desconto
            $table->decimal('advance_payment', 10, 2)->nullable(); // Pagamento antecipado/sinal
            // Editing and historical tracking
            $table->boolean('in_use')->default(false); // Em uso
            $table->string('currently_editing')->nullable();
            $table->string('initially_attended_by')->nullable();
            $table->timestamp('abandonment_alert')->nullable(); // Data de alerta de abandono
            $table->string('quoted_by_technician')->nullable(); // Avaliado pelo técnico
            $table->string('repaired_by_technician')->nullable(); // Reparado pelo técnico
            $table->text('internal_notes')->nullable(); // Notas internas
            $table->timestamp('closed_at')->nullable(); // Fecha
            $table->timestamp('reopened_at')->nullable(); // Reabre
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_orders');
    }
};
