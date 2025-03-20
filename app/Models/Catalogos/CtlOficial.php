<?php

namespace App\Models\Catalogos;

use App\Models\Franquicia;
use App\Models\MntClasificacionFranquicia;
use App\Traits\Paginable;
use App\Traits\Search;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CtlOficial extends Model
{
    use HasFactory, Paginable,Search;

    protected $table = 'franquicias_oficial';

    protected $guarded = ['id'];

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_edicion';

    public function getActivoAttribute($value)
    {
        return (bool) $value;
    }

    public function franquicias(): HasMany
    {
        return $this->hasMany(Franquicia::class, 'oficial_id');
        
    }

}
