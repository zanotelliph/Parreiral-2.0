<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cliente', function (Blueprint $table) {
            $table->date('data_nascimento')->nullable()->after('email');
            $table->string('cep', 10)->nullable()->after('telefone');
            $table->date('data_cadastro')->nullable()->after('cep');
            $table->string('status_financeiro')->default('em dia')->after('data_cadastro');
        });
    }

    public function down(): void
    {
        Schema::table('cliente', function (Blueprint $table) {
            $table->dropColumn(['data_nascimento', 'cep', 'data_cadastro', 'status_financeiro']);
        });
    }
};
