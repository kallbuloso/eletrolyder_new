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
            $table->string('name');
            $table->string('fantasy_name')->nullable();
            $table->string('contact_name')->nullable();
            // Documento
            $table->enum('person', ['F', 'J'])->default('F'); // F - Física, J - Jurídica
            $table->string('cpf_cnpj');
            $table->string('rg_insc_est')->nullable();
            $table->string('ccm')->nullable();
            $table->string('birth_date');
            // Logo
            $table->string('logo')->nullable();

            $table->string('description')->nullable();
            $table->string('email')->nullable();
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
