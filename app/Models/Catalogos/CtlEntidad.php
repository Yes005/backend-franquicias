<?php

namespace App\Models\Catalogos;

use App\Models\Franquicia;
use App\Traits\Search;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CtlEntidad extends Model
{
    use HasFactory, Search;

    protected $table = 'ctl_entidad';

    public function franquicias(): HasMany
    {
        return $this->hasMany(Franquicia::class, 'tipo');
    }
}
