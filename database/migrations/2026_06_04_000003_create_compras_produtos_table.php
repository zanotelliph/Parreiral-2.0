<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compras_produtos', function (Blueprint $table) {
    $table->id();

    $table->unsignedBigInteger('produto_id');
    $table->string('item_compra')->nullable();
    $table->text('descricao')->nullable();
    $table->string('fornecedor')->nullable();
    $table->integer('quantidade')->default(1);
    $table->decimal('custo_compra', 10, 2)->default(0);
    $table->decimal('desconto', 10, 2)->default(0);
    $table->integer('parcelas')->default(1);
    $table->string('forma_pagamento')->default('Não informado');
    $table->decimal('valor_total', 10, 2)->default(0);
    $table->date('data_compra');
    $table->text('observacao')->nullable();

    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('compras_produtos');
    }
};
