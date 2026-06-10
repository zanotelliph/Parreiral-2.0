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
    $table->string('cpf', 16)->nullable();
    $table->string('telefone', 20)->nullable();
    $table->string('email', 50);
    $table->date('data_nascimento')->nullable();
    $table->string('cep', 10)->nullable();
    $table->date('data_cadastro')->nullable();
    $table->string('status_financeiro')->default('em dia');
    $table->string('endereco', 300)->nullable();
    $table->string('rua', 300)->nullable();
    $table->string('numero', 50)->nullable();
    $table->string('complemento', 300)->nullable();
    $table->string('bairro', 300)->nullable();
    $table->string('cidade', 300)->nullable();
    $table->string('estado', 2)->nullable();
    $table->string('preferenciadecompra', 500)->nullable();
    $table->text('observacoes')->nullable();
    $table->integer('numero_visitas')->default(0);
    $table->date('data_ultima_visita')->nullable();
    $table->boolean('cliente_fidelizado')->default(false);
    $table->tinyInteger('nivel_fidelidade')->default(0);
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
