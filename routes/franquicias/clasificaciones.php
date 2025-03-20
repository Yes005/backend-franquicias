<?php

use App\Enum\PermissionEnum;
use App\Helpers\Utils;
use App\Http\Controllers\Franquicias\ClasificacionController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::controller( ClasificacionController::class)->prefix('clasificacion')->group(function(){
        Route::get('/obtener-puntaje/{id}','getClasificaciones')->middleware(Utils::permission([PermissionEnum::VER_PUNTAJE_FRANQUICIAS]));
        Route::post('/subir-puntaje', 'guardarPuntaje')->middleware(Utils::permission([PermissionEnum::PUNTUAR_FRANQUICIAS]));
        Route::post('/guardar-observacion', 'guardarObservacion')->middleware(Utils::permission([PermissionEnum::GUARDAR_OBSERVACION]));
        Route::get('/ver-observaciones/{franquicia_id}', 'verObservaciones')->middleware(Utils::permission([PermissionEnum::LISTAR_OBSERVACIONES]));
        Route::get('/ver-archivo-observacion/{id}', 'verArchivoObservacion')->middleware(Utils::permission([PermissionEnum::PREVISUALIZAR_ARCHIVO_OBSERVACION]));
        Route::delete('/eliminar-observacion/{id}', 'deleteObservacion')->middleware(Utils::permission([PermissionEnum::ELIMINAR_OBSERVACION]));
        Route::get('/obtener-promedio-entidad/{id}', 'getAverageEntidad')->middleware(Utils::permission([PermissionEnum::VER_PROMEDIO_ENTIDAD]));
        Route::get('/obtener-promedio-entidades', 'getAverageEntidades')->middleware(Utils::permission([PermissionEnum::VER_PROMEDIO_ENTIDADES]));
    });
});
