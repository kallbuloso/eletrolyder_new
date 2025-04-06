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
        Schema::create('phones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained();
            $table->enum('phone_type', ['P', 'C'])->default('P'); // P - Principal, C - Contato
            $table->string('phone_number')->nullable();
            $table->string('phone_contact')->nullable();
            $table->boolean('phone_has_whatsapp')->default(false);
            $table->morphs('phoneable'); // phoneable_id, phoneable_type
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phones');
    }
};
