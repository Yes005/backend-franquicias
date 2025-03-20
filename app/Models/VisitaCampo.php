<?php

namespace App\Models;

use App\Models\Catalogos\CtlCategoriaVisita;
use App\Models\Catalogos\CtlEstado;
use App\Traits\Paginable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Search;
class VisitaCampo extends Model
{
    use HasFactory, Paginable, Search;

    protected $table = 'mnt_visitas_campos';

    protected $guarded = ['id'];

    protected $casts = [
        'fecha_visita' => 'date:Y-m-d',
    ];

    protected $appends = ['file_name', 'correlativo_file', 'codigo_franquicia'];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->numero_seguimiento = last(explode('-', $model->codigo_franquicia));

            $model->correlativo = VisitaCampo::where('entidad_id', $model->entidad_id)
                ->max('correlativo') + 1;
        });
    }

    protected function getCodigoFranquiciaAttribute()
    {
        return Franquicia::find($this->entidad_id)?->codigo_franquicia;
    }

    protected function getCorrelativoFileAttribute()
    {
        return $this->archivos()
            ->where('visita_campo_id', $this->id)->max('correlativo') + 1;
    }

    protected function getFileNameAttribute()
    {
        return "ArchivoAdjunto$this->correlativo_file" . "_" .
            $this->id .'-'. $this->codigo_franquicia . '-' . $this->correlativo;
    }

    public function franquicia(): BelongsTo
    {
        return $this->belongsTo(Franquicia::class, 'entidad_id');
    }

    public function archivos(): HasMany
    {
        return $this->hasMany(VisitaCampoArchivo::class, 'visita_campo_id');
    }


    public function nombres(): HasMany
    {
        return $this->hasMany(VisitaCampoNombre::class, 'visita_campo_id');
    }


    public function estado(): BelongsTo
    {
        return $this->belongsTo(CtlEstado::class, 'estado_id');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CtlCategoriaVisita::class, 'categoria_visita_id');
    }
}
