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
            $table->string('name');
            // status_type: entrada = 0, em andamento = 1, saída = 3
            $table->tinyInteger('status_type');
            // generates_revenue: 0 = não gera receita, 1 = gera receita
            $table->tinyInteger('generates_revenue');
            // Colunas de relacionamento polimórfico (por exemplo: statusable_id e statusable_type)
            $table->morphs('statusable');
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
