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
            $table->string('nome');
            $table->string('tipo_uva');
            $table->string('lote');
            $table->decimal('valor_unitario', 10, 2);
            $table->text('descricao')->nullable();
            $table->integer('quantidade_disponivel')->default(0);
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
