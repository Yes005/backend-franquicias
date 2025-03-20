<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtlCorrelativo extends Model
{
    use HasFactory;

    protected $table = 'franquicias_correlativo';

    protected $guarded = ['id'];

    public $timestamps = false;

}
