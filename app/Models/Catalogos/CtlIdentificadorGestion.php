<?php

namespace App\Models\Catalogos;

use App\Traits\Paginable;
use App\Traits\Search;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtlIdentificadorGestion extends Model
{
    use HasFactory;

    use Paginable;

    use Search;

    protected $table = 'franquicias_identificadorgestion';

    protected $guarded = ['id'];

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_edicion';

    protected $dates = ['fecha_creacion', 'fecha_edicion'];
}
