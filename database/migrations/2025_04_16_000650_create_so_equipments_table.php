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
        Schema::create('so_equipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained();
            $table->foreignId('client_id')->nullable()->constrained();
            $table->string('device_type')->nullable();
            $table->string('brand')->nullable(); // marca
            $table->string('model')->nullable(); // modelo
            $table->string('serial_number')->nullable(); // número de série
            $table->text('damages')->nullable(); // danos visíveis no dispositivo
            $table->text('accessories')->nullable(); // acessórios
            $table->text('notes')->nullable(); // notas
            $table->string('warranty_provider')->nullable(); // fornecedor da garantia
            $table->date('purchase_date')->nullable(); // data de compra
            $table->string('reseller')->nullable(); // revendedor
            $table->string('invoice_number')->nullable(); // número da nota
            $table->string('warranty_certificate')->nullable(); // certificado de garantia
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('so_equipments');
    }
};
