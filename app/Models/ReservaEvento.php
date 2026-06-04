<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservaEvento extends Model
{
    use HasFactory;

    protected $table = 'reservas_eventos';

    protected $fillable = [
        'nome_cliente',
        'evento',
        'data_evento',
        'data_reserva',
        'horario',
        'tipo_reserva',
        'local',
        'quantidade',
        'valor_ingresso',
        'status',
    ];
}
