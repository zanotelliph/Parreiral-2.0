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
        'quantidade',
        'valor_total',
        'data_compra',
        'descrição',
        'custo_compra',
        'desconto',
        'forma_pagamento',
        'data_pagamento',
        'data_vencimento',
        'parcelas',
        'status'
    ];
    public function produto()
{
    return $this->belongsTo(Produto::class);
}
}
