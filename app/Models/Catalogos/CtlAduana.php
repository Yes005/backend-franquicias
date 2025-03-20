<?php

namespace App\Models\Catalogos;

use App\Models\Franquicia;
use App\Traits\Paginable;
use App\Traits\Search;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CtlAduana extends Model
{
    use HasFactory;

    use Paginable;
    use Search;

    protected $table = 'franquicias_aduana';

    protected $guarded = ['id'];

    public $timestamps = false;

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_edicion';

    protected $dates = ['fecha_creacion', 'fecha_edicion'];


    public function getActivoAttribute($value)
    {
        return (bool) $value;
    }

    public function franquicias(): HasMany
    {
        return $this->hasMany(Franquicia::class, 'aduana_id');
    }
}
