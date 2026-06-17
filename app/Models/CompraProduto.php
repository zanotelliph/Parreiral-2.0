<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompraProduto extends Model
{
    use HasFactory;

    protected $table = 'compras_produtos';

    protected $fillable = [
        'produto_id',
        'item_compra',
        'descricao',
        'quantidade',
        'custo_compra',
        'desconto',
        'parcelas',
        'forma_pagamento',
        'valor_total',
        'data_compra',
        'observacao'
    ];

    protected $casts = [
        'data_compra' => 'date',
        'valor_total' => 'decimal:2',
    ];

    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class);
    }
}