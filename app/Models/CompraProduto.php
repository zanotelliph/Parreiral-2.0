<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use App\Models\Produto;
=======
use Illuminate\Database\Eloquent\Relations\BelongsTo;
>>>>>>> 19262168641d0837dcd9295cfe234fbe446609f2

class CompraProduto extends Model
{
    use HasFactory;

    protected $table = 'compras_produtos';
    

    protected $fillable = [
<<<<<<< HEAD
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
=======
        'cliente_id',
        'produto_id',
        'fornecedor',
        'quantidade',
        'valor_total',
        'data_compra',
        'observacao',
    ];

    protected $casts = [
        'data_compra' => 'date',
        'valor_total' => 'decimal:2',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class);
    }
>>>>>>> 19262168641d0837dcd9295cfe234fbe446609f2
}
