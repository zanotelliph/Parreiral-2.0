<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cliente_identificadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->unique()->constrained('cliente')->cascadeOnDelete();
            $table->string('codigo_externo', 50)->unique();
            $table->string('tipo_documento', 30)->default('cpf');
            $table->string('documento', 30)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cliente_identificadores');
    }
};
