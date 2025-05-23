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
        Schema::create('so_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained();
            $table->string('description');
            // status_type: entrada = 0, em andamento = 1, saída = 2
            $table->tinyInteger('status_type');
            // generates_revenue: 0 = gera receita, 1 = não gera receita
            $table->tinyInteger('generates_revenue')->nullable();
            // plano de contas
            $table->foreignId('accounting_plan_id')->nullable()->constrained('accounting_plans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('so_statuses');
    }
};
