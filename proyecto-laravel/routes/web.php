<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

Route::get('/usuario/{id}/editar', [DashboardController::class, 'editarUsuario']);
Route::put('/usuario/{id}/actualizar', [DashboardController::class, 'actualizarUsuario'])->name('usuarios.update');

Route::delete('/usuario/{id}/eliminar', [DashboardController::class, 'eliminarUsuario'])->name('usuarios.eliminar');

Route::post('/usuario/crear', [DashboardController::class, 'storeUsuario'])->name('usuarios.store');


Route::get('/tareas', [TareaController::class, 'dashboard'])->name('tareas.dashboard');
Route::get('/tareas/crear', [TareaController::class, 'crearTarea'])->name('tarea.crear');
Route::post('/tareas', [TareaController::class, 'storeTarea'])->name('tarea.store');
Route::get('/tareas/{id}/editar', [TareaController::class, 'editarTarea'])->name('tarea.editar');
Route::put('/tareas/{id}', [TareaController::class, 'actualizarTarea'])->name('tarea.actualizar');
Route::delete('/tareas/{id}', [TareaController::class, 'eliminarTarea'])->name('tarea.eliminar');