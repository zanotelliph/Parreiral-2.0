<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservas_eventos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_cliente');
            $table->string('evento');
            $table->date('data_evento');
            $table->string('local');
            $table->integer('quantidade')->default(1);
            $table->decimal('valor_ingresso', 10, 2)->default(0);
            $table->string('status')->default('pendente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas_eventos');
    }
};