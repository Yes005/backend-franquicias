<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Catalogos\CtlRole;
use App\Traits\Auth;
use App\Traits\Paginable;
use App\Traits\Search;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, Notifiable, Auth,Paginable, Search;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'activo',
        'login_attempts',
        'temp_password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(CtlRole::class, 'mnt_rol_usuarios', 'usuario_id', 'rol_id');
    }


    public function personalAccessToken(): MorphMany
    {
        return $this->morphMany(PersonalAccessToken::class, 'tokenable');
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class,'id_usuario');
    }

    public function franquicias_corrector(): HasMany
    {
        return $this->hasMany(Franquicia::class, 'corrector_id');
    }

    public function franquicias_creador(): HasMany
    {
        return $this->hasMany(Franquicia::class, 'usuario_creador_id');
    }

    public function rolescreation(): HasMany
    {
        return $this->hasMany(CtlRole::class, 'id_usuario','id');
    }

    public function documentos(): HasMany
    {
        return $this->hasMany(FranquiciaDocumentos::class, 'usuario_creador_id');
    }

    public function clasificacionDocumentos(): HasMany
    {
        return $this->hasMany(MntClasificacionDocumentos::class, 'usuario_creador_id');
    }
}
