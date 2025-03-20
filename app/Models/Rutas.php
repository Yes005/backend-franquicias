<?php

namespace App\Models;

use App\Models\Catalogos\CtlPermiso;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rutas extends Model
{
    use HasFactory;

    protected $table = 'mnt_rutas';

    protected $fillable = [
        'nombre',
        'url',
        'icono',
        'nombreUri',
    ];

    public function permisos(){
        return $this->belongsToMany(CtlPermiso::class, 'mnt_rutas_permiso','ruta_id','permiso_id');
    }
}
