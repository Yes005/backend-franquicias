<?php

namespace App\Models\Catalogos;

use App\Models\User;
use App\Traits\Paginable;
use App\Traits\Search;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CtlRole extends Model
{
    use HasFactory, Paginable, Search;

    protected $table = 'ctl_roles';

    protected $guarded = ['id'];


    // Relationships

    public function permisos(): BelongsToMany
    {
        return $this->belongsToMany(CtlPermiso::class, 'mnt_rol_permisos', 'rol_id', 'permiso_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
