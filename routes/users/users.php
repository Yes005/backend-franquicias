<?php

use App\Enum\PermissionEnum;
use App\Helpers\Utils;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (){
    Route::controller(UserController::class)->prefix('usuarios')->group(function (){
        Route::get('/','getUsers')->middleware(Utils::permission([PermissionEnum::LISTAR_USERS]));
        Route::post('/crear','createUser')->middleware(Utils::permission([PermissionEnum::CREAR_USER]));
        Route::put('/actualizar/{id}', 'editUser')->middleware(Utils::permission([PermissionEnum::ACTUALIZAR_USER]));
        Route::patch('/update-password', 'updatePassword');
        Route::post('/recuperar-password', 'recoverPassword');
        Route::patch('/cambiar-estado/{id}', 'changeState')->middleware(Utils::permission([PermissionEnum::ACTUALIZAR_USER]));
        Route::put('/desbloquear-usuario/{id}', 'unblockedUser')->middleware(Utils::permission([PermissionEnum::DESBLOQUEAR_USER]));
    });
});
