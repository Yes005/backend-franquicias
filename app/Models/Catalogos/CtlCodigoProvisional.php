<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtlCodigoProvisional extends Model
{
    use HasFactory;

    protected $table = 'franquicias_codigoprovisional';

    public $timestamps = false;

    protected $guarded = ['id'];
}
