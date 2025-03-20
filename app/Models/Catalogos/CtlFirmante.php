<?php

namespace App\Models\Catalogos;

use App\Traits\Paginable;
use App\Traits\Search;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtlFirmante extends Model
{
    use HasFactory, Paginable, Search;

    protected $table = 'franquicias_configuracionfranquicia';

    protected $guarded = ['id'];

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_edicion';

}
