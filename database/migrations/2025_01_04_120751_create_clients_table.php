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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained();
            $table->string('name')->required();
            $table->string('nick_name')->nullable();
            // Documento
            $table->enum('person', ['F', 'J'])->nullable(); // F - Física, J - Jurídica
            $table->string('cpf_cnpj')->nullable();
            $table->enum('gender', ['M', 'F', 'L', 'NB', 'O'])->nullable(); // M - Masculino, F - Feminino, L - LGBL, NB - Não binário, O - Outro
            // Avatar
            $table->string('avatar')->nullable();
            // Observações
            $table->text('note')->nullable();
            // Status
            $table->enum('status', [0, 1, 2])->default(0); // 0 - Ativo, 1 - Inativo, 2 - Bloqueado
            $table->string('blocking_reason')->nullable(); // Motivo do bloqueio
            $table->string('last_purchase')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
