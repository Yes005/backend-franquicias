<?php

namespace App\Models;

use App\Traits\Paginable;
use App\Traits\Search;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MntClasificacionDocumentos extends Model
{
    use HasFactory, Paginable, Search;

    protected $table = 'mnt_clasificacion_documentos';

    protected $guarded = ['id'];

    public function usuarioCreador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_creador_id');
    }

    public function franquicias(): BelongsTo
    {
        return $this->belongsTo(Franquicia::class, 'franquicia_id');
    }
}
