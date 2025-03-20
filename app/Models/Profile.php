<?php

namespace App\Models;

use App\Models\Catalogos\CtlDistrito;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profile';

    protected $guarded = ['id'];

    protected $fillable = [
        'cod_colaborador',
        'titulo',
        'cargo',
        'id_distrito',
        'firmador',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'id_usuario');
    }

    public function distrito(): BelongsTo
    {
        return $this->belongsTo(CtlDistrito::class, 'id_distrito');
    }
}
