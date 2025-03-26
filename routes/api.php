<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


collect(glob(base_path('routes/api/*.php')))
    ->each(fn ($file) => require $file);

collect(glob(base_path('routes/catalogos/*.php')))
->each(fn ($file) => require $file);

collect(glob(base_path('routes/users/*.php')))
->each(fn ($file) => require $file);

collect(glob(base_path('routes/franquicias/*.php')))
->each(fn ($file) => require $file);

Route::get('prueba-v1', function () {
    $users = \App\Models\User::all();
    return response()->json($users);
});

Route::get('prueba-v2', function () {
    return response()->json([
        'message' => 'Hello World'
    ]);
});
