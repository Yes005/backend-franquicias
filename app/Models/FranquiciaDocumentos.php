<?php

namespace App\Models;

use App\Traits\Paginable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FranquiciaDocumentos extends Model
{
    use HasFactory, Paginable;

    protected $table = 'franquicias_documentosfranquicia';

    const CREATED_AT = 'fecha_creacion';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function franquicia(): BelongsTo
    {
        return $this->belongsTo(Franquicia::class, 'franquicia_id');
    }

    public function usuarioCreador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_creador_id');
    }
}
