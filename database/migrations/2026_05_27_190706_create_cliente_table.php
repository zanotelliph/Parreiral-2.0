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
        Schema::create('cliente', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('cpf', 16);
            $table->string('telefone', 20)->nullable();
            $table->string('email', 50);
            $table->string('endereco', 300);
            $table->string('preferenciadecompra', 500)->nullable();
            $table->string('historicodevisitas', 10)->nullable();
            $table->string('imagem')->nullable();
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente');
    }
};
