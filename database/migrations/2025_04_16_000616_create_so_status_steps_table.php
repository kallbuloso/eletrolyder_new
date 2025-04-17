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
        Schema::create('so_status_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained();
            $table->foreignId('status_id')->nullable()->constrained('so_statuses');
            $table->string('name');
            // Colunas de relacionamento polimórfico (por exemplo: stepable_id e stepable_type)
            $table->morphs('stepable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('so_status_steps');
    }
};
