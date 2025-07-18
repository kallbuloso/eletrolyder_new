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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained();
            $table->string('name');
            $table->string('fantasy_name')->nullable();
            $table->string('contact_name')->nullable();
            // Documento
            $table->enum('person', ['F', 'J'])->default('F'); // F - Física, J - Jurídica
            $table->string('cpf_cnpj');
            $table->string('rg_ie')->nullable();
            $table->string('ccm_im')->nullable();
            $table->date('birth_date');
            // Logo
            $table->string('logo')->nullable();

            $table->string('email')->nullable()->unique();
            $table->string('website')->nullable();
            // Observações
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
