<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

<<<<<<< HEAD
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
=======
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
        'imagem',
        'quantidade_disponivel',
    ];

    public function compras(): HasMany
    {
        return $this->hasMany(CompraProduto::class);
    }

    public function getImagemUrlAttribute(): string
    {
        return $this->imagem
            ? asset('storage/' . $this->imagem)
            : asset('images/sem-imagem.svg');
    }
>>>>>>> 19262168641d0837dcd9295cfe234fbe446609f2
}
