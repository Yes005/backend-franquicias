<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitaCampoNombre extends Model
{

    use SoftDeletes;
    use HasFactory;

    protected $table = 'mnt_visita_campo_nombres';


    protected $guarded = ['id'];


    public function visitaCampo(): BelongsTo
    {
        return $this->belongsTo(VisitaCampo::class, 'visita_campo_id');
    }
}
