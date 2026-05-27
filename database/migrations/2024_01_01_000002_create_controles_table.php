<?php
// database/migrations/2024_01_01_000002_create_controles_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('controles', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->enum('tipo', ['entrada', 'saida']);
            $table->decimal('valor', 12, 2);
            $table->enum('status', ['pendente', 'concluido', 'cancelado'])->default('pendente');
            $table->foreignId('cadastro_id')->nullable()->constrained('cadastros')->nullOnDelete();
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('controles');
    }
};
