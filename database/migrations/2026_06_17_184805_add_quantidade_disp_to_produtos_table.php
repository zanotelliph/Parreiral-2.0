<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            // Alterado para 'after nome' para evitar erros caso a coluna de preço tenha outro nome
            $table->integer('quantidade_disp')->default(0)->after('nome');
        });
    }

    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn('quantidade_disp');
        });
    }
};