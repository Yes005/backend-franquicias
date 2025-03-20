<?php

use App\Enum\PermissionEnum;
use App\Helpers\Utils;
use App\Http\Controllers\User\RolesController;
use Dflydev\DotAccessData\Util;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (){
    Route::controller(RolesController::class)->prefix('roles')->group(function (){
        Route::get('/', 'getRoles')->middleware(Utils::permission([PermissionEnum::LISTAR_ROLES]));
        Route::get('/listar-select', 'listarRolesSelect');
        Route::post('/crear', 'crearRol')->middleware(Utils::permission([PermissionEnum::CREAR_ROL]));
        Route::put('/actualizar/{id}', 'actualizarRol')->middleware(Utils::permission([PermissionEnum::ACTUALIZAR_ROL]));
        Route::patch('/cambiar-estado/{id}','cambiarEstado')->middleware(Utils::permission([PermissionEnum::ACTUALIZAR_ROL]));
    });
});
