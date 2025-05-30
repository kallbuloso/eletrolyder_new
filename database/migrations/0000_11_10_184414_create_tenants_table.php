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
    Schema::create('tenants', function (Blueprint $table) {
      $table->id();
      // Status
      $table->enum('status', [0, 1, 2])->default(0); // 0 - Ativo, 1 - Inativo, 2 - Bloqueado
      // Motivo do Bloqueio
      $table->string('blocking_reason')->nullable();
      // Planos
      // $table->foreignId('plan_id')->constrained();
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tenants');
  }
};
