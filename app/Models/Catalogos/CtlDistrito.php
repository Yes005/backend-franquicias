<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CtlDistrito extends Model
{
    use HasFactory;

    protected $table = 'ctl_distrito';

    protected $guarded = ['id'];

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(CtlMunicipio::class,'id_municipio');
    }
}
