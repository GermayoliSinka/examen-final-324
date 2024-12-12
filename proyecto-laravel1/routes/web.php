<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\UsuarioController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
Route::post('usuarios/crear', [UsuarioController::class, 'storeUsuario'])->name('usuarios.store');
Route::get('/usuarios/{id}/editar', [UsuarioController::class, 'editarUsuario'])->name('usuarios.edit');
Route::put('/usuarios/{id}/actualizar', [UsuarioController::class, 'actualizarUsuario'])->name('usuarios.update');
Route::delete('/usuarios/{id}/eliminar', [UsuarioController::class, 'eliminarUsuario'])->name('usuarios.eliminar');

Route::get('tareas', [TareaController::class, 'index'])->name('tareas.index');  
Route::get('tareas/crear', [TareaController::class, 'crearTarea'])->name('tareas.create'); 
Route::post('tareas/crear', [TareaController::class, 'storeTarea'])->name('tareas.store'); 
Route::get('tareas/{id}/editar', [TareaController::class, 'editarTarea'])->name('tareas.edit'); 
Route::put('tareas/{id}/actualizar', [TareaController::class, 'actualizarTarea'])->name('tareas.update'); 
Route::delete('tareas/{id}/eliminar', [TareaController::class, 'eliminarTarea'])->name('tareas.eliminar');

