<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
    use HasFactory;

    protected $table = 'cliente';

    protected $fillable = [
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
}
