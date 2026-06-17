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
        Schema::table('compras_produtos', function (Blueprint $table) {
            
            $table->string('item_compra')->nullable()->change();
            
            $table->decimal('custo_compra', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compras_produtos', function (Blueprint $table) {
            
            $table->string('item_compra')->nullable(false)->change();
            $table->decimal('custo_compra', 10, 2)->nullable(false)->change();
        });
    }
};