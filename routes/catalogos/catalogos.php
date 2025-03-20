<?php

use App\Enum\PermissionEnum;
use App\Helpers\Utils;
use App\Http\Controllers\Catalogos\CtlAduanaController;
use App\Http\Controllers\Catalogos\CtlCategoriaVisitaController;
use App\Http\Controllers\Catalogos\CtlClaseController;
use App\Http\Controllers\Catalogos\CtlDepartamentoController;
use App\Http\Controllers\Catalogos\CtlDistritoController;
use App\Http\Controllers\Catalogos\CtlEntidadController;
use App\Http\Controllers\Catalogos\CtlEstadoController;
use App\Http\Controllers\Catalogos\CtlFacturaController;
use App\Http\Controllers\Catalogos\CtlFiltroVisitaController;
use App\Http\Controllers\Catalogos\CtlFirmanteController;
use App\Http\Controllers\Catalogos\CtlInstitucionController;
use App\Http\Controllers\Catalogos\CtlIdentificadorGestionController;
use App\Http\Controllers\Catalogos\CtlMunicipioController;
use App\Http\Controllers\Catalogos\CtlOficialController;
use App\Http\Controllers\Franquicias\ClasificacionController;
use Dflydev\DotAccessData\Util;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function(){

    Route::prefix('catalogos')->group(function(){

        Route::controller(CtlAduanaController::class)->prefix('aduanas')->group(function(){
            Route::get('/', 'getAduanas')->middleware(Utils::permission([PermissionEnum::LISTAR_ADUANA]));
            Route::post('/crear', 'createAduana')->middleware(Utils::permission([PermissionEnum::CREAR_ADUANA]));
            Route::put('/actualizar/{id}', 'editAduana')->middleware(Utils::permission([PermissionEnum::ACTUALIZAR_ADUANA]));
            Route::patch('/cambiar-estado/{id}', 'changeState')->middleware(Utils::permission([PermissionEnum::ACTUALIZAR_ADUANA]));
        });

        Route::controller(CtlFacturaController::class)->prefix('facturas')->group(function(){
            Route::get('/', 'getFacturas')->middleware(Utils::permission([PermissionEnum::LISTAR_FACTURAS]));
            Route::post('/crear', 'createFactura')->middleware(Utils::permission([PermissionEnum::CREAR_FACTURA]));
            Route::put('/actualizar/{id}', 'editFactura')->middleware(Utils::permission([PermissionEnum::ACTUALIZAR_FACTURA]));
            Route::patch('/cambiar-estado/{id}', 'changeState')->middleware(Utils::permission([PermissionEnum::ACTUALIZAR_FACTURA]));
        });

        Route::controller(CtlOficialController::class)->prefix('oficial')->group(function(){
            Route::get('/', 'getOficiales')->middleware(Utils::permission([PermissionEnum::LISTAR_OFICIALES]));
            Route::post('/crear','createOficial')->middleware(Utils::permission([PermissionEnum::CREAR_OFICIAL]));
            Route::put('/actualizar/{id}','editOficial')->middleware(Utils::permission([PermissionEnum::ACTUALIZAR_OFICIAL]));
            Route::patch('/cambiar-estado/{id}','changeStateOficial')->middleware(Utils::permission([PermissionEnum::ACTUALIZAR_OFICIAL]));
        });

        Route::controller(CtlClaseController::class)->prefix('clases')->group(function(){
            Route::get('/', 'getClases')->middleware(Utils::permission([PermissionEnum::LISTAR_CLASES]));
            Route::post('/crear', 'createClase')->middleware(Utils::permission([PermissionEnum::CREAR_CLASE]));
            Route::put('/actualizar/{id}', 'editClase')->middleware(Utils::permission([PermissionEnum::ACTUALIZAR_CLASE]));
            Route::patch('/cambiar-estado/{id}', 'changeState')->middleware(Utils::permission([PermissionEnum::ACTUALIZAR_CLASE]));
        });

        Route::controller(CtlInstitucionController::class)->prefix('institucion')->group(function(){
            Route::get('/', 'getInstituciones')->middleware(Utils::permission([PermissionEnum::LISTAR_INSTITUCIONES]));
            Route::post('/crear','createInstitucion')->middleware(Utils::permission([PermissionEnum::CREAR_INSTITUCION]));
            Route::put('/actualizar/{id}','editInstitucion')->middleware(Utils::permission([PermissionEnum::ACTUALIZAR_INSTITUCION]));
            Route::patch('/cambiar-estado/{id}','changeStateInstitucion')->middleware(Utils::permission([PermissionEnum::ACTUALIZAR_INSTITUCION]));
        });

        Route::controller(CtlIdentificadorGestionController::class)->prefix('identificador-gestion')->group(function(){
            Route::get('/', 'getIdentifiacionGestion')->middleware(Utils::permission([PermissionEnum::LISTAR_IDENTIFICADOR_GESTION]));
            Route::post('/crear', 'createIndentificador')->middleware(Utils::permission([PermissionEnum::CREAR_IDENTIFICADOR_GESTION]));
            Route::put('/actualizar/{id}', 'editIdentificador')->middleware(Utils::permission([PermissionEnum::ACTUALIZAR_IDENTIFICADOR_GESTION]));
        });

        Route::controller(CtlFirmanteController::class)->prefix('firmante')->group(function () {
            Route::get('/', 'getFirmantes')->middleware(Utils::permission([PermissionEnum::LISTAR_FIRMANTES]));
            Route::post('/crear','createFirmante')->middleware(Utils::permission([PermissionEnum::CREAR_FIRMANTE]));
            Route::put('/actualizar/{id}','editFirmante')->middleware(Utils::permission([PermissionEnum::ACTUALIZAR_FIRMANTE]));
        });

        Route::controller(CtlEntidadController::class)->prefix('entidad')->group(function () {
            Route::get('/','getEntidades');
        });

        Route::controller(CtlEstadoController::class)->prefix('estado')->group(function () {
            Route::get('/','getEstados');
        });

        Route::controller(CtlDepartamentoController::class)->prefix('departamentos')->group(function (){
            Route::get('/', 'getDepartamentos');
        });

        Route::controller(CtlMunicipioController::class)->prefix('municipios')->group(function (){
            Route::get('/', 'getMunicipios');
        });

        Route::controller(CtlDistritoController::class)->prefix('distritos')->group(function(){
            Route::get('/','getDistritos');
        });

        Route::controller(ClasificacionController::class)->prefix('clasificaciones')->group(function(){
            Route::get('/listar-clasificaciones','listarClasificaciones')->middleware(Utils::permission([PermissionEnum::LISTAR_CLASIFICACIONES]));
        });


        Route::controller(CtlCategoriaVisitaController::class)->prefix('categoria-visita')->group(function(){
            Route::get('/','index')->middleware('auth');
        });

        Route::controller(CtlFiltroVisitaController::class)->prefix('filtro-visita/entidad')->group(function(){
            Route::get('/seguimiento', 'numeroSeguimiento')->middleware('auth');
            Route::get('/', 'entidades')->middleware('auth');
            Route::get('/codigos-franquicias', 'codigoFranquicias')->middleware('auth');
        });
    });
});


