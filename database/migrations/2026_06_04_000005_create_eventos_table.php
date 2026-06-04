<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_evento');
            $table->text('descricao')->nullable();
            $table->date('data_inicio');
            $table->time('hora_inicio');
            $table->date('data_fim');
            $table->time('hora_fim');
            $table->integer('limite_pessoas')->default(0);
            $table->decimal('valor_ingresso_1', 10, 2)->default(0);
            $table->decimal('valor_ingresso_2', 10, 2)->default(0);
            $table->decimal('valor_ingresso_3', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
