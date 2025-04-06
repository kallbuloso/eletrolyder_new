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
      $table->enum('status', ['A', 'I', 'B'])->default('A'); // A - Ativo, I - Inativo, B - Bloqueado
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
