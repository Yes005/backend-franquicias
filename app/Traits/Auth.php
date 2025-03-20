<?php

namespace App\Traits;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Trait Auth for handling user authentication
 * @package App\Traits
 */
trait Auth
{

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the custom claims that will be stored in the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    /**
     * Check if the user has the necessary permissions
     * @param array $permissions
     * @return bool
     */
    public function hasPermissions(array $permissions): bool
    {
        $user = $this;

        if (!$user) return false;

        return $user->roles()->where('ctl_roles.activo', true)
            ->where('mnt_rol_usuarios.activo', true)
            ->whereHas('permisos', function ($query) use ($permissions) {
                $query->where('mnt_rol_permisos.activo', true)
                    ->where('ctl_permisos.activo', true)
                    ->whereIn('ctl_permisos.nombre', $permissions);
            })->exists();
    }
}
