<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\AutorController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('paises')->group(function () {
    Route::get('/', [PaisController::class, 'index']);
    Route::get('{id}', [PaisController::class, 'show']);
    Route::post('/', [PaisController::class, 'store']);
    Route::put('{id}', [PaisController::class, 'update']);
    Route::delete('{id}', [PaisController::class, 'destroy']);
});

////////////////////////////////////////////////////////////////////

Route::prefix('libros')->group(function () {
    Route::get('/', [LibroController::class, 'index']);
    Route::get('{id}', [LibroController::class, 'show']);
    Route::post('/', [LibroController::class, 'store']);
    Route::put('{id}', [LibroController::class, 'update']);
    Route::delete('{id}', [LibroController::class, 'destroy']);
});


//////////////////////////////////////////////////////////////////////

Route::prefix('autores')->group(function () {
    Route::get('/', [AutorController::class, 'index']);
    Route::get('{id}', [AutorController::class, 'show']);
    Route::post('/', [AutorController::class, 'store']);
    Route::put('{id}', [AutorController::class, 'update']);
    Route::delete('{id}', [AutorController::class, 'destroy']);
});
