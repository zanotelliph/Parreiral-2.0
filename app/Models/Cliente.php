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
        'id',
    ];
    public function categoria()
    {
        return $this->belongsTo(Categoriacliente::class, 'categoria_id');
    }
}
