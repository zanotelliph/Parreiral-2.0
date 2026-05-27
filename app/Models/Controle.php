<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Controle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'descricao',
        'tipo',
        'valor',
        'status',
        'cadastro_id',
        'observacoes',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
    ];

    // Relacionamentos
    public function cadastro()
    {
        return $this->belongsTo(Cadastro::class);
    }

    // Scopes
    public function scopeTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopePeriodo($query, $inicio, $fim)
    {
        return $query->whereBetween('created_at', [$inicio, $fim]);
    }

    public function scopeBusca($query, string $termo)
    {
        return $query->where('descricao', 'like', "%{$termo}%");
    }
}
