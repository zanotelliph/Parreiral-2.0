<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->string('categoria_produto')->nullable()->after('nome');
            $table->decimal('preco_produto', 10, 2)->default(0)->after('preco');
            $table->string('lote_produto')->nullable()->after('lote');
            $table->decimal('desconto_promocao', 10, 2)->default(0)->after('preco_produto');
        });
    }

    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn(['categoria_produto', 'preco_produto', 'lote_produto', 'desconto_promocao']);
        });
    }
};
