<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitaCampoArchivo extends Model
{
    use HasFactory;

    protected $table = 'mnt_visita_campo_archivos';


    protected $guarded = ['id'];


    public function visitaCampo(): BelongsTo
    {
        return $this->belongsTo(VisitaCampo::class, 'visita_campo_id');
    }
}
