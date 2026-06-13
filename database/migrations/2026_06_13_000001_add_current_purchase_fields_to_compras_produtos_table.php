<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('compras_produtos', function (Blueprint $table) {
            if (!Schema::hasColumn('compras_produtos', 'fornecedor')) {
                $table->string('fornecedor')->nullable()->after('descricao');
            }

            if (!Schema::hasColumn('compras_produtos', 'quantidade')) {
                $table->integer('quantidade')->default(1)->after('fornecedor');
            }

            if (!Schema::hasColumn('compras_produtos', 'observacao')) {
                $table->text('observacao')->nullable()->after('data_compra');
            }
        });
    }

    public function down(): void
    {
        Schema::table('compras_produtos', function (Blueprint $table) {
            foreach (['fornecedor', 'quantidade', 'observacao'] as $column) {
                if (Schema::hasColumn('compras_produtos', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
