<?php

use App\Enum\PermissionEnum;
use App\Helpers\Utils;
use App\Http\Controllers\Franquicias\ReportesController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function(){

    Route::controller(ReportesController::class)
    ->prefix('reportes')->group(function(){
        //TODO: validar permisos
        Route::get('/','index');
        Route::get('/franquicias','franquicias')->middleware(Utils::permission([PermissionEnum::GENERAR_REPORTES]));
        Route::get('/franquicias/{id}','franquiciaById')->middleware(Utils::permission([PermissionEnum::PREVISUALIZAR_DOCUMENTO_FRANQUICIA]));

    });
});
