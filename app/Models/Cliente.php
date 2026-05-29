<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'email',
        'endereco',
        'cpf',
        'telefone',
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
