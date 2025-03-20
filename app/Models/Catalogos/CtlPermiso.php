<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CtlPermiso extends Model
{
    use HasFactory;

    protected $table = 'ctl_permisos';

    protected $guarded = ['id'];


    // Relationships


    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(CtlRole::class, 'mnt_rol_permisos', 'permiso_id', 'rol_id');
    }
}
