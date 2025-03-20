<?php

namespace App\Models\Catalogos;

use App\Models\MntClasificacionFranquicia;
use App\Traits\Paginable;
use App\Traits\Search;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CtlClasificacion extends Model
{
    use HasFactory, Paginable, Search;

    protected $table = 'ctl_clasificacion';

    protected $guarded = ['id'];

    public function clasificacionesFranquicia(): HasMany
    {
        return $this->hasMany(MntClasificacionFranquicia::class, 'clasificacion_id');
    }
}
