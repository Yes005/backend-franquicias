<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CtlMunicipio extends Model
{
    use HasFactory;

    protected $table = 'ctl_municipio';
    protected $guarded = ['id'];

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(CtlDepartamento::class, 'id_departamento');
    }

    public function distritos(): HasMany
    {
        return $this->hasMany(CtlDistrito::class, 'id_municipio');
    }
}
