<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/v1/docs', function () {

    $debugMode = env('APP_DEBUG', false);

    if (!$debugMode) abort(404);

    return view('swagger.index');
});


Route::get('/docs-api/{name}', function ($name) {


    $path  = env('PATH_SWAGGER') ?? 'resources/api-docs';

    $file =  base_path($path) . '/output/' . $name . '.json';

    $debugMode = env('APP_DEBUG', false);

    if (!$file ||  !$debugMode) abort(404);


    return response()->file($file);
});

Route::get('/preview-email-credenciales', function () {
    $usuario = [
        'nombreUsuario' => 'Alfonso Aguirre',
        'apellidoUsuario' => 'Salazar Gutiérrez',
    ];
    $temp_password = 'YLkz5DkuU3grW7VFHUm3';
    $url = 'https://example.com';

    return view('mails.UserCredentials', compact('usuario', 'url', 'temp_password'));
});

Route::get('/preview-email-reset-password', function () {
    $usuario = [
        'nombreUsuario' => 'Alfonso Aguirre',
        'apellidoUsuario' => 'Salazar Gutiérrez',
    ];
    $temp_password = 'YLkz5DkuU3grW7VFHUm3';
    $url = 'https://example.com';

    return view('mails.UserResetPassword', compact('usuario', 'url', 'temp_password'));
});

Route::get('/preview-email-blocked-user', function () {
    $usuario = [
        'nombreUsuario' => 'Alfonso Aguirre',
        'apellidoUsuario' => 'Salazar Gutiérrez',
    ];
    $url = 'https://example.com';

    return view('mails.UserBlocked', compact('usuario', 'url'));
});

Route::get('/preview-email-unblocked-user', function () {
    $usuario = [
        'nombreUsuario' => 'Alfonso Aguirre',
        'apellidoUsuario' => 'Salazar Gutiérrez',
    ];
    $temp_password = 'YLkz5DkuU3grW7VFHUm3';
    $url = 'https://example.com';

    return view('mails.UserUnblocked', compact('usuario', 'url', 'temp_password'));
});

Route::get('/preview-email-new-request', function () {
    $usuario = [
        'nombreUsuario' => 'Juan Carlos',
        'apellidoUsuario' => 'Pérez Ramírez',
    ];
    
    $codigoProvisional = 'PROV-2024-015';
    
    $url = 'https://example.com';
    
    return view('mails.UserBossNewRequest', compact('usuario', 'codigoProvisional', 'url'));
});

Route::get('/preview-email-observation', function () {
    $usuario = [
        'nombreUsuario' => 'Juan Carlos',
        'apellidoUsuario' => 'Pérez Ramírez',
    ];
    
    $codigoProvisional = 'PROV-2024-015';
    
    $url = 'https://example.com';

    return view('mails.UserAuxObservation', compact('usuario', 'codigoProvisional', 'url'));
});

Route::get('/preview-email-resolve', function () {
    $usuario = [
        'nombreUsuario' => 'Juan Carlos',
        'apellidoUsuario' => 'Pérez Ramírez',
    ];
    
    $codigoProvisional = 'PROV-2024-015';
    
    $url = 'https://example.com';

    return view('mails.UserBossSolvedNotication', compact('usuario', 'codigoProvisional', 'url'));
});

Route::get('/preview-email-aux-aprobed', function () {
    $usuario = [
        'nombreUsuario' => 'Juan Carlos',
        'apellidoUsuario' => 'Pérez Ramírez',
    ];

    $codigoProvisional = 'PROV-2024-015';

    $codigoFranquicia = '2024-002-001-001';

    $url = 'https://example.com';

    return view('mails.UserAuxAprobed', compact('usuario', 'codigoProvisional', 'codigoFranquicia', 'url'));
});

Route::get('/preview-email-aux-canceled', function () {
    $usuario = [
        'nombreUsuario' => 'Juan Carlos',
        'apellidoUsuario' => 'Pérez Ramírez',
    ];

    $codigoProvisional = 'PROV-2024-015';

    $codigoFranquicia = '2024-002-001-001';

    $url = 'https://example.com';

    return view('mails.UserAuxCanceled', compact('usuario', 'codigoProvisional', 'codigoFranquicia', 'url'));
});




