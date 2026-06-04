<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservas_eventos', function (Blueprint $table) {
            $table->date('data_reserva')->nullable()->after('data_evento');
            $table->time('horario')->nullable()->after('data_reserva');
            $table->string('tipo_reserva')->nullable()->after('horario');
        });
    }

    public function down(): void
    {
        Schema::table('reservas_eventos', function (Blueprint $table) {
            $table->dropColumn(['data_reserva', 'horario', 'tipo_reserva']);
        });
    }
};
