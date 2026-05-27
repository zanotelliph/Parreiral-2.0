<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cadastro extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'documento',
        'data_nascimento',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'observacoes',
        'ativo',
    ];

    protected $casts = [
        'ativo'           => 'boolean',
        'data_nascimento' => 'date',
    ];

    // Relacionamentos
    public function controles()
    {
        return $this->hasMany(Controle::class);
    }

    // Scopes
    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeBusca($query, string $termo)
    {
        return $query->where(function ($q) use ($termo) {
            $q->where('nome',      'like', "%{$termo}%")
              ->orWhere('email',    'like', "%{$termo}%")
              ->orWhere('documento','like', "%{$termo}%");
        });
    }
}
