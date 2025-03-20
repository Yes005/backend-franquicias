<?php

use App\Http\Controllers\Auth\AuthenticationController;
use Illuminate\Support\Facades\Route;
use App\Enum\PermissionEnum;
use App\Helpers\Utils;

Route::controller(AuthenticationController::class)
    ->prefix('v1')->group(function () {
        Route::post('login', 'login');
        Route::get('/get-rutas', 'getRutas');
        Route::post('refresh', 'refresh');
        Route::post('logout', 'logout');
        Route::get('verify-user', 'verifyUser');
        Route::post('change-password', 'changePassword');
    });


Route::get('test', function () {
    return response()->json(['message' => 'Hello World']);
})->middleware(Utils::permission([
    PermissionEnum::DELETE,
    PermissionEnum::CREATE,
    PermissionEnum::READ,
]));
