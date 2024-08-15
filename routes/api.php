<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Models\Cliente;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::resource('clientes', ClienteController::class);
Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');

// Formulario para crear un nuevo cliente (GET)
Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');

// Guardar un nuevo cliente (POST)
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');

// Mostrar un cliente específico (GET)
Route::get('/clientes/{cliente}', [ClienteController::class, 'show'])->name('clientes.show');

// Formulario para editar un cliente (GET)
Route::get('/clientes/{cliente}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');

// Actualizar un cliente existente (PATCH)
Route::post('/clientes/{cliente}', [ClienteController::class, 'update'])->name('clientes.update');

// Eliminar un cliente (DELETE)
Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

Route::post('/registrar', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/usuarios',[AuthController::class, 'index']);