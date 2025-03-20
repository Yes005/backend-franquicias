<?php

namespace App\Models\Catalogos;

use App\Models\Franquicia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CtlEstado extends Model
{
    use HasFactory;

    protected $table = 'ctl_estados';

    protected $guarded = ['id'];

    public function franquicias(): HasMany
    {
        return $this->hasMany(Franquicia::class, 'estado');
    }
}
