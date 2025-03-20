<?php

namespace App\Models\Catalogos;

use App\Models\Franquicia;
use App\Models\MntClasificacionFranquicia;
use App\Traits\Paginable;
use App\Traits\Search;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CtlInstitucion extends Model
{
    use HasFactory, Paginable, Search;

    protected $table = 'franquicias_institucion';

    protected $guarded = ['id'];

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_edicion';

    public function franquicias(): HasMany
    {
        return $this->hasMany(Franquicia::class, 'institucion_id');
    }

}
