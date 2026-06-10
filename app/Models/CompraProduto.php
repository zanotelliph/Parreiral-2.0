<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produto;

class CompraProduto extends Model
{
    use HasFactory;

    protected $table = 'compras_produtos';
    

    protected $fillable = [
    'produto_id',
    'item_compra',
    'descricao',
    'custo_compra',
    'desconto',
    'parcelas',
    'forma_pagamento',
    'valor_total',
    'data_compra',
];
    public function produto()
{
    return $this->belongsTo(Produto::class);
}
}
