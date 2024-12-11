<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TareaController extends Controller
{
    public function dashboard() 
    {
        $tareas = DB::table('tareas')
            ->join('usuarios', 'tareas.usuario_id', '=', 'usuarios.id')
            ->join('estadostarea', 'tareas.estado_id', '=', 'estadostarea.id')
            ->join('prioridades', 'tareas.prioridad_id', '=', 'prioridades.id')
            ->select('tareas.*', 'usuarios.nombre as usuario', 'estadostarea.nombre as estado', 'prioridades.nombre as prioridad')
            ->get();

        $usuarios = DB::table('usuarios')->get();
        $estadosTarea = DB::table('estadostarea')->get();
        $prioridades = DB::table('prioridades')->get();

        return view('tareas', compact('tareas', 'usuarios', 'estadosTarea', 'prioridades'));
    }
    
    public function crearTarea()
    {
        $usuarios = DB::table('usuarios')->get();
        $estadosTarea = DB::table('estadostarea')->get();
        $prioridades = DB::table('prioridades')->get();

        return view('crear_tarea', compact('usuarios', 'estadosTarea', 'prioridades'));
    }

    public function editarTarea($id)
    {
        $tarea = DB::table('tareas')
            ->join('usuarios', 'tareas.usuario_id', '=', 'usuarios.id')
            ->join('estadostarea', 'tareas.estado_id', '=', 'estadostarea.id')
            ->join('prioridades', 'tareas.prioridad_id', '=', 'prioridades.id')
            ->select('tareas.*', 'usuarios.nombre as usuario', 'estadostarea.nombre as estado', 'prioridades.nombre as prioridad')
            ->where('tareas.id', $id)
            ->first();

        if (!$tarea) {
            return redirect()->route('tareas.dashboard')->with('error', 'Tarea no encontrada.');
        }

        $usuarios = DB::table('usuarios')->get();
        $estadosTarea = DB::table('estadostarea')->get();
        $prioridades = DB::table('prioridades')->get();

        return view('editar_tarea', compact('tarea', 'usuarios', 'estadosTarea', 'prioridades'));
    }

    public function storeTarea(Request $request)
{
    $validated = $request->validate([
        'descripcion' => 'required|string',
        'usuario_id' => 'required|exists:usuarios,id',
        'estado_id' => 'required|exists:estadostarea,id',
        'prioridad_id' => 'required|exists:prioridades,id',
        'fecha_limite' => 'required|date',
    ]);

    DB::table('tareas')->insert([
        'usuario_id' => $validated['usuario_id'],
        'descripcion' => $validated['descripcion'],
        'estado_id' => $validated['estado_id'],
        'prioridad_id' => $validated['prioridad_id'],
        'fecha_limite' => $validated['fecha_limite'],
    ]);

    return redirect()->back()->with('success', 'Tarea creada correctamente.');
}

public function actualizarTarea(Request $request, $id)
{
    $validated = $request->validate([
        'descripcion' => 'required|string',
        'estado_id' => 'required|exists:estadostarea,id',
        'prioridad_id' => 'required|exists:prioridades,id',
        'fecha_limite' => 'required|date',
    ]);

    DB::table('tareas')
        ->where('id', $id)
        ->update([
            'descripcion' => $validated['descripcion'],
            'estado_id' => $validated['estado_id'],
            'prioridad_id' => $validated['prioridad_id'],
            'fecha_limite' => $validated['fecha_limite'],
        ]);

    return redirect()->back()->with('success', 'Tarea actualizada correctamente.');
}
    public function eliminarTarea($id)
    {
        DB::table('tareas')->where('id', $id)->delete();

        return redirect()->route('tareas.dashboard')->with('success', 'Tarea eliminada correctamente.');
    }
}