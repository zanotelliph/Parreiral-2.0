<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'cliente';

    protected $fillable = [
        'nome',
        'data_nascimento',
        'email',
        'telefone',
        'cep',
        'data_cadastro',
        'status_financeiro',
        'cpf',
        'endereco',
        'imagem',
        'preferenciadecompra',
        'historicodevisitas',
        'categoria_id',
    ];

    public function compras(): HasMany
    {
        return $this->hasMany(CompraProduto::class);
    }

    public function identificador(): HasOne
    {
        return $this->hasOne(ClienteIdentificador::class);
    }

    public function getImagemUrlAttribute(): string
    {
        return $this->imagem
            ? asset('storage/' . $this->imagem)
            : asset('images/sem-imagem.svg');
    }
}
