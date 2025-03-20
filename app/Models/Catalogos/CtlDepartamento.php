<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CtlDepartamento extends Model
{
    use HasFactory;

    protected $table = 'ctl_departamento';

    protected $guarded = ['id'];

    public function municipios(): HasMany
    {
        return $this->hasMany(CtlMunicipio::class, 'id_departamento');
    }
}
