<?php

namespace App\Models;

use App\Models\Catalogos\CtlClasificacion;
use App\Models\Catalogos\CtlInstitucion;
use App\Models\Catalogos\CtlOficial;
use App\Traits\Paginable;
use App\Traits\Search;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MntClasificacionFranquicia extends Model
{
    use HasFactory, Paginable, Search;

    protected $table = 'mnt_clasificacion_franquicia';

    protected $guarded = ['id'];

    public function clasificacion(): BelongsTo
    {
        return $this->belongsTo(CtlClasificacion::class, 'clasificacion_id');
    }

    public function franquicia(): BelongsTo
    {
        return $this->belongsTo(Franquicia::class, 'franquicia_id');
    }

}
