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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained();
            $table->string('name')->required();
            $table->string('nick_name')->nullable();
            $table->string('contact')->nullable();
            // Documento
            $table->enum('person', ['F', 'J'])->default('F'); // F - Física, J - Jurídica
            $table->string('cpf_cnpj')->nullable();
            $table->date('birth_date')->nullable();
            // Avatar
            $table->string('avatar')->nullable();
            // site e E-mail
            $table->string('site')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
};
