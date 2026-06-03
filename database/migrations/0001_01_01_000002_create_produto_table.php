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
        Schema::create('produto', function (Blueprint $table) {
            $table->id();
            $table->string('Safra', 100);
            $table->string('Tipo de Uva', 50);
            $table->string('lote', 500)->nullable();
            $table->string('Preço', 500)->nullable();
            $table->string('Descrição', 300);
            $table->string('Quantidade Disponível', 10)->nullable();
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->timestamps();
        });
    }
    /** afra, tipo de uva, lote, preço, descrição e quantidade disponível.
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produto');
    }
};
