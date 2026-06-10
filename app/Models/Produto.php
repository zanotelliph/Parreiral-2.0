<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'categoria_produto',
        'tipo_uva',
        'descricao',
        'quantidade_disponivel',
        'valor_unitario',
    ];
}
