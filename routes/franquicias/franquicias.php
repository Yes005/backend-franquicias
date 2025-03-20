<?php

use App\Enum\PermissionEnum;
use App\Helpers\Utils;
use App\Http\Controllers\Franquicias\FranquiciaController;
use App\Http\Controllers\Franquicias\VisitaCampoController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::controller(FranquiciaController::class)->prefix('franquicias')->group(function () {

        Route::post('/borrador', 'createBorrador')->middleware(Utils::permission([PermissionEnum::CREAR_BORRADOR]));
        Route::put('/borrador-update/{id}', 'editBorrador')->middleware(Utils::permission([PermissionEnum::ACTUALIZAR_FRANQUICIA]));
        Route::get('ver-detalle/{id}', 'getDetalleFranquicia')->middleware(Utils::permission([PermissionEnum::VER_DETALLE_FRANQUICIA]));
        Route::get('/', 'getFranquicias')->middleware(Utils::permission([PermissionEnum::LISTAR_FRANQUICIAS]));
        Route::put('/crear/{id}', 'createFranquicia')->middleware(Utils::permission([PermissionEnum::CREAR_FRANQUICIA]));
        Route::patch('/observar/{id}', 'sendFranquiciaObservacion')->middleware(Utils::permission([PermissionEnum::OBSERVAR_FRANQUICIA]));
        Route::post('/crear', 'createFranquiciaRevision')->middleware(Utils::permission([PermissionEnum::ENVIAR_FRANQUICIA_REVISION]));
        Route::put('/solventar/{id}', 'resolveFranquicia')->middleware(Utils::permission([PermissionEnum::SOLVENTAR_FRANQUICIA]));
        Route::get('/validar-unicidad', 'compareFranquicia');
        Route::post('/subir-archivo', 'uploadFile')->middleware(Utils::permission([PermissionEnum::SUBIR_ARCHIVOS_FRANQUICIA]));
        Route::get('/ver-archivos-franquicia/{id}', 'getFiles')->middleware(Utils::permission([PermissionEnum::LISTAR_ARCHIVOS_FRANQUICIA]));
        Route::get('/ver-archivo/{id}', 'previewFile')->middleware(Utils::permission([PermissionEnum::VER_ARCHIVOS_FRANQUICIA]));
        Route::patch('/eliminar-archivo/{id}', 'deleteFile')->middleware(Utils::permission([PermissionEnum::ELIMINAR_ARCHIVOS_FRANQUICIA]));
        Route::patch('/anular/{id}', 'cancelFranquicia')->middleware(Utils::permission([PermissionEnum::ANULAR_FRANQUICIA]));
        Route::put('/aprobar/{id}', 'approveFranquicia')->middleware(Utils::permission([PermissionEnum::APROBAR_FRANQUICIA]));
        Route::patch('actualizar-fechas/{id}', 'editFechasFranquicias')->middleware(Utils::permission([PermissionEnum::GESTIONAR_FECHAS]));
        Route::get('/institucion/verificar-expiracion/{id}', 'expiredInstitucion');



        Route::prefix('visitas-campos')->controller(VisitaCampoController::class)->group(function () {
            Route::get('/', 'index')->middleware('auth')
                ->middleware(Utils::permission([PermissionEnum::LISTAR_VISITAS_CAMPOS]));
            Route::post('/', 'store')->middleware('auth')
                ->middleware(Utils::permission([PermissionEnum::CREAR_VISITA_CAMPO]));
            Route::get('/seguimiento', 'seguimiento')->middleware('auth')
                ->middleware(Utils::permission([PermissionEnum::LISTAR_SEGUIMIENTOS_VISITA_CAMPO]));
            Route::post('/{id}', 'update')->middleware('auth')
                ->middleware(Utils::permission([PermissionEnum::EDITAR_VISITA_CAMPO]));
            Route::delete('/{id}', 'delete')->middleware('auth')
                ->middleware(Utils::permission([PermissionEnum::ELIMINAR_VISITA_CAMPO]));
            Route::get('/detalle-visita/{id}', 'detalleVisitaCampo')->middleware('auth')
                ->middleware(Utils::permission([PermissionEnum::DETALLE_VISITA_CAMPO]));
            Route::get('/detalle-seguimiento/{id}', 'detalleSeguimiento')->middleware('auth')
                ->middleware(Utils::permission([PermissionEnum::DETALLE_SEGUIMIENTO_VISITA_CAMPO]));
            Route::get('/generar-reporte/{id}', 'generarReporteVisita')->middleware('auth')
                ->middleware(Utils::permission([PermissionEnum::GENERAR_REPORTE_VISITA_CAMPO]));
            Route::get('/generar-reportes-franquicia/{franquiciaId}', 'generarReportesVisita')->middleware('auth')
                ->middleware(Utils::permission([PermissionEnum::GENERAR_REPORTES_VISITA_CAMPO]));
                
        });
    });
});
