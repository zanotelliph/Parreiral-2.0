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
            $table->string('nome',100);
            $table->string('cpf',16);
            $table->string('telefone',20)->nullable();
            $table->timestamps('email', 50);
            $table->timestamps('endereco', 300);
            $table->timestamps('preferenciadecompra', 500);
            $table->timestamps('preferenciadecompra', 10);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parreiral_2');
    }
};
