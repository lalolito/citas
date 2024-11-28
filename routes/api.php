<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitasController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/citas', [CitasController::class, 'index']);
    Route::get('/cita/{id}', [CitasController::class, 'show']);
    Route::post('/cita', [CitasController::class, 'store']);
    Route::put('/cita/{id}', [CitasController::class, 'update']);
    Route::delete('/cita/{id}', [CitasController::class, 'destroy']);
}); 

/*Route::get('/cita', function () {
    return'cliente lista';
});

Route::get('/cliente/{id}', function () {
    return 'un cliente   ';
});

Route::post('/cliente', function () {
    return 'creando un cliente';
});

Route::put('/cliente/{id}', function () {
    return 'actualizando uncliente ';
});
 
Route::delete('/cliente/{id}', function () {
    return 'eliminando cliente ';
});*/

