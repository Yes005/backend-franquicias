<?php

namespace App\Models;

use App\Models\Catalogos\CtlAduana;
use App\Models\Catalogos\CtlClases;
use App\Models\Catalogos\CtlEntidad;
use App\Models\Catalogos\CtlEstado;
use App\Models\Catalogos\CtlFactura;
use App\Models\Catalogos\CtlInstitucion;
use App\Models\Catalogos\CtlOficial;
use App\Traits\Paginable;
use App\Traits\Search;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Franquicia extends Model
{
    use HasFactory, Paginable, Search;

    protected $table = 'franquicias_franquicia';

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_edicion';

    protected $guarded = ['id'];

    protected $appends = ['entidad'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (array_key_exists('tipo', $model->getAttributes())) {
                if ($model->tipo == 1) {
                    $model->oficial_id = null;
                } elseif ($model->tipo == 2) {
                    $model->institucion_id = null;
                }
            }
        });
    }

    public function tipos(): BelongsTo
    {
        return $this->belongsTo(CtlEntidad::class, 'tipo');
    }

    public function estados(): BelongsTo
    {
        return $this->belongsTo(CtlEstado::class, 'estado');
    }

    public function aduana(): BelongsTo
    {
        return $this->belongsTo(CtlAduana::class, 'aduana_id');
    }

    public function clase(): BelongsTo
    {
        return $this->belongsTo(CtlClases::class, 'clase_id');
    }

    public function corrector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'corrector_id');
    }

    public function factura(): BelongsTo
    {
        return $this->belongsTo(CtlFactura::class, 'factura_comercial_id');
    }

    public function institucion(): BelongsTo
    {
        return $this->belongsTo(CtlInstitucion::class, 'institucion_id');
    }

    public function oficial(): BelongsTo
    {
        return $this->belongsTo(CtlOficial::class, 'oficial_id');
    }

    public function usuario_creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_creador_id');
    }

    public function documentos(): HasMany
    {
        return $this->hasMany(FranquiciaDocumentos::class, 'franquicia_id');
    }

    public function clasificacionesFranquicia(): HasMany
    {
        return $this->hasMany(MntClasificacionFranquicia::class, 'franquicia_id');
    }

    public function clasificacionesDocumentos(): HasMany
    {
        return $this->hasMany(MntClasificacionDocumentos::class, 'franquicia_id');
    }

    public function getEntidadAttribute()
    {

        return $this->tipo == 1 ? $this->institucion :  $this->oficial;
    }
}
