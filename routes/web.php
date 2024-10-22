<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrabajoSecretariaController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CuadrillaController;
use App\Http\Controllers\LoginController;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [LoginController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [LoginController::class, 'register']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/trabajos', [TrabajoSecretariaController::class, 'index'])->name('trabajos.index');
Route::get('/trabajos/create', [TrabajoSecretariaController::class, 'create'])->name('trabajos.create');
Route::get('/trabajos/{id}/edit', [TrabajoSecretariaController::class, 'edit'])->name('trabajos.edit');
Route::put('/trabajos/{id}', [TrabajoSecretariaController::class, 'update'])->name('trabajos.update');
Route::post('/trabajos/store', [TrabajoSecretariaController::class, 'store'])->name('trabajos.store');
Route::delete('/trabajos/{id}', [TrabajoSecretariaController::class, 'destroy'])->name('trabajos.destroy');

Route::post('/g_ubi', [TrabajoSecretariaController::class, 'g_ubi'])->name('g_ubi');
Route::delete('/imagenes/{id}', [TrabajoSecretariaController::class, 'destroyImage'])->name('imagenes.destroy');

Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados.index');
Route::get('/empleados/{id}/edit', [EmpleadoController::class, 'edit'])->name('empleados.edit');
Route::put('/empleados/{id}', [EmpleadoController::class, 'update'])->name('empleados.update');
Route::get('/empleados/create', [EmpleadoController::class, 'create'])->name('empleados.create');
Route::post('/empleados/store', [EmpleadoController::class, 'store'])->name('empleados.store');
Route::get('/empleados/ingresar-cedula', [EmpleadoController::class, 'ingresarCedula'])->name('empleados.ingresar_cedula');
Route::post('/empleados/validar-cedula', [EmpleadoController::class, 'validarCedula'])->name('empleados.validar_cedula');
Route::delete('/empleados/{id}', [EmpleadoController::class, 'destroy'])->name('empleados.destroy');

Route::get('/cuadrillas', [CuadrillaController::class, 'index'])->name('cuadrillas.index');
Route::get('/cuadrillas/create', [CuadrillaController::class, 'create'])->name('cuadrillas.create');
Route::post('/cuadrillas', [CuadrillaController::class, 'store'])->name('cuadrillas.store');
Route::get('/cuadrillas/{id}/edit', [CuadrillaController::class, 'edit'])->name('cuadrillas.edit');
Route::put('/cuadrillas/{id}', [CuadrillaController::class, 'update'])->name('cuadrillas.update');
Route::delete('/cuadrillas/{id}', [CuadrillaController::class, 'destroy'])->name('cuadrillas.destroy');
