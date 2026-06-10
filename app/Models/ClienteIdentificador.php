<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClienteIdentificador extends Model
{
    protected $table = 'cliente_identificadores';

    protected $fillable = [
        'cliente_id',
        'codigo_externo',
        'tipo_documento',
        'documento',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
}
