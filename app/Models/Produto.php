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
    'lote',
    'lote_produto',
    'preco',
    'preco_produto',
    'desconto_promocao',
    'descricao',
    'quantidade_disponivel',
];
}
