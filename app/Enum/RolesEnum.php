<?php

namespace App\Enum;

use App\Models\Catalogos\CtlRole;

class RolesEnum
{
    public static function getRolesId($rolNombre)
    {
        $rol = CtlRole::where('nombre', $rolNombre)->first();

        if ($rol) {
            return $rol->id;
        }

        return null;
    }
}
