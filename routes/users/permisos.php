<?php

use App\Enum\PermissionEnum;
use App\Helpers\Utils;
use App\Http\Controllers\User\PermisoController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (){
    Route::controller(PermisoController::class)->prefix('permisos')->group(function (){
        Route::get('/', 'listarPermisos')->middleware(Utils::permission([PermissionEnum::LISTAR_PERMISOS]));
        Route::get('/{id}', 'getPermisosbyRol')->middleware(Utils::permission([PermissionEnum::LISTAR_PERMISOS]));

    });
});
