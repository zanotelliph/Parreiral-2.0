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
<<<<<<< HEAD
    'nome',
    'cpf',
    'telefone',
    'email',
    'data_nascimento',
    'cep',
    'data_cadastro',
    'status_financeiro',
    'endereco',

    'rua',
    'numero',
    'complemento',
    'bairro',
    'cidade',
    'estado',

    'preferenciadecompra',
    'observacoes',

    'numero_visitas',
    'data_ultima_visita',
    'cliente_fidelizado',
    'nivel_fidelidade',

    'historicodevisitas',
    'imagem',
    'categoria_id'
];
    function edit($id)
{
    $dado = cliente::find($id);

    return view('cliente.form', [
        'dado' => $dado
    ]);
}
=======
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
>>>>>>> 19262168641d0837dcd9295cfe234fbe446609f2
}
