<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Models\Cliente;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');

Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');

Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');

Route::get('/clientes/{cliente}', [ClienteController::class, 'show'])->name('clientes.show');

Route::get('/clientes/{cliente}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');

Route::post('/clientes/{cliente}', [ClienteController::class, 'update'])->name('clientes.update');

Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

Route::prefix('productos')->group(function () {
    Route::get('/', [ProductoController::class, 'index']);
    Route::post('/', [ProductoController::class, 'store']);    
    Route::get('{producto}', [ProductoController::class, 'show']);  
    Route::post('{producto}', [ProductoController::class, 'update']); 
    Route::delete('{producto}', [ProductoController::class, 'destroy']); 
});

Route::post('/registrar', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/usuarios',[AuthController::class, 'index']);