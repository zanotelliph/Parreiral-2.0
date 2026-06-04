<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';

    protected $fillable = [
        'nome_evento',
        'descricao',
        'data_inicio',
        'hora_inicio',
        'data_fim',
        'hora_fim',
        'limite_pessoas',
        'valor_ingresso_1',
        'valor_ingresso_2',
        'valor_ingresso_3',
    ];
}
