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
        // Tipos de dispositivos e equipamentos
        Schema::create('so_devices_type', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained();
            $table->string('description'); // Descrição do tipo de dispositivo
            $table->timestamps();
        });

        // Dispositivos e equipamentos
        Schema::create('so_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained();
            $table->foreignId('so_device_type_id')->constrained('so_devices_type'); // Tipo de dispositivo (ex: notebook, desktop, impressora, etc.)
            $table->string('description')->nullable(); // Descrição do dispositivo
            $table->string('brand'); // Marca
            $table->string('model'); // Modelo
            $table->string('serial_number'); // Número de série (ex: SN123456789)
            $table->text('damages')->nullable(); // Danos visíveis no dispositivo
            $table->text('accessories')->nullable(); // Acessórios
            $table->text('notes')->nullable(); // Notas/Observações
            $table->string('warranty_provider')->nullable(); // fornecedor da garantia
            $table->date('purchase_date')->nullable(); // data de compra
            $table->string('reseller')->nullable(); // revendedor
            $table->string('invoice_number')->nullable(); // número da nota
            $table->string('warranty_certificate')->nullable(); // certificado de garantia
            $table->timestamps();
        });

        // Status para Ordens de Serviço
        Schema::create('so_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained();
            $table->string('description'); // Descrição do status            
            $table->tinyInteger('status_type'); // status_type: entrada = 0, em andamento = 1, saída = 2
            $table->tinyInteger('is_active')->default(1); // 0 = inativo, 1 = ativo
            $table->tinyInteger('generates_revenue')->nullable(); // generates_revenue: 0 = gera receita, 1 = não gera receita // generates_revenue: 0 = gera receita, 1 = não gera receita
            $table->timestamps();
        });

        // Etapas de status para Ordens de Serviço
        Schema::create('so_status_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained();
            $table->foreignId('so_status_id')->nullable()->constrained('so_statuses');
            $table->string('description');
            $table->timestamps();
        });
        
        // Equipamentos relacionados às Ordens de Serviço
        // Schema::create('so_equipments', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('tenant_id')->nullable()->constrained();
        //     $table->foreignId('client_id')->nullable()->constrained();
        //     $table->string('device_type')->nullable(); // tipo de dispositivo (ex: notebook, desktop, impressora, etc.)
        //     $table->string('brand')->nullable(); // marca
        //     $table->string('model')->nullable(); // modelo
        //     $table->string('serial_number')->nullable(); // número de série (ex: SN123456789)
        //     $table->text('damages')->nullable(); // danos visíveis no dispositivo
        //     $table->text('accessories')->nullable(); // acessórios
        //     $table->text('notes')->nullable(); // notas
        //     $table->string('warranty_provider')->nullable(); // fornecedor da garantia
        //     $table->date('purchase_date')->nullable(); // data de compra
        //     $table->string('reseller')->nullable(); // revendedor
        //     $table->string('invoice_number')->nullable(); // número da nota
        //     $table->string('warranty_certificate')->nullable(); // certificado de garantia
        //     $table->timestamps();
        // });

        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // Ordem de serviço
            $table->foreignId('tenant_id')->nullable()->constrained();
            $table->foreignId('client_id')->constrained('clients');
            $table->foreignId('so_device_id')->constrained('so_devices');
            // $table->foreignId('so_service_id')->constrained('so_services');
            $table->foreignId('so_status_id')->nullable()->constrained('so_statuses'); // Status
            $table->foreignId('so_step_id')->nullable()->constrained('so_status_steps'); // Etapa do status
            // Warranty expiration date
            $table->date('warranty_expires_on')->nullable(); // Vencimento da garantia
            // Monetary values
            $table->decimal('labor_cost', 10, 2)->nullable(); // Custos de mão de obra
            $table->decimal('parts_cost', 10, 2)->nullable(); // Custos de peças
            $table->decimal('service_cost', 10, 2)->nullable(); // Custos de serviço
            $table->decimal('discount', 10, 2)->nullable(); // Desconto
            $table->decimal('advance_payment', 10, 2)->nullable(); // Pagamento antecipado/sinal
            // Editing and historical tracking
            $table->boolean('in_use')->default(false); // Em uso (para evitar edição simultânea)
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

        Schema::create('service_order_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('service_orders');
            $table->foreignId('so_status_id')->constrained('so_statuses');
            $table->foreignId('so_status_steps_id')->constrained('so_status_steps');
            $table->foreignId('changed_by')->constrained('users');
            $table->timestamp('changed_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_order_history');
        Schema::dropIfExists('service_orders');
        Schema::dropIfExists('so_status_steps');
        Schema::dropIfExists('so_statuses');
        Schema::dropIfExists('so_devices');
        Schema::dropIfExists('so_devices_type');
    }
};
