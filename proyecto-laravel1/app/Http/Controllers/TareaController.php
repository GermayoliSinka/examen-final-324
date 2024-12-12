<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TareaController extends Controller
{
    public function index()
    {
        $tareas = DB::select('
        SELECT 
            t.id, 
            t.descripcion, 
            t.fecha_limite, 
            t.usuario_id,
            t.estado_id,
            t.prioridad_id,
            u.nombre AS usuario_nombre, 
            e.nombre AS estado_nombre, 
            p.nombre AS prioridad_nombre
        FROM tarea t
        JOIN usuarios u ON t.usuario_id = u.id
        JOIN estadostarea e ON t.estado_id = e.id
        JOIN prioridad p ON t.prioridad_id = p.id
    ');

        $usuarios = DB::select('SELECT * FROM usuarios');
        $prioridades = DB::select('SELECT * FROM prioridad');
        $estados = DB::select('SELECT * FROM estadostarea');
        
        return view('tareas', compact('tareas', 'usuarios', 'prioridades', 'estados'));
    }

    public function crearTarea()
    {
        $usuarios = DB::select('SELECT * FROM usuarios');
        $estados = DB::select('SELECT * FROM estadostarea');
        $prioridades = DB::select('SELECT * FROM prioridad');

        return view('crear_tarea', compact('usuarios', 'estados', 'prioridades'));
    }

    public function storeTarea(Request $request)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255',
            'usuario_id' => 'required|exists:usuarios,id', 
            'estado_id' => 'required|exists:estadostarea,id',
            'prioridad_id' => 'required|exists:prioridad,id',
            'fecha_limite' => 'required|date',
        ]);

        DB::insert('
            INSERT INTO tarea (descripcion, usuario_id, estado_id, prioridad_id, fecha_limite)
            VALUES (?, ?, ?, ?, ?)
        ', [
            $validated['descripcion'],
            $validated['usuario_id'],
            $validated['estado_id'],
            $validated['prioridad_id'],
            $validated['fecha_limite'],
        ]);

        return redirect()->route('tareas.index')->with('success', 'Tarea creada correctamente.');
    }

    public function editarTarea($id)
    {
        
        $tarea = DB::selectOne('
            SELECT t.id, t.descripcion, t.fecha_limite, t.usuario_id, t.estado_id, t.prioridad_id, u.nombre AS usuario, e.nombre AS estado, p.nombre AS prioridad
            FROM tarea t
            JOIN usuarios u ON t.usuario_id = u.id
            JOIN estadostarea e ON t.estado_id = e.id
            JOIN prioridad p ON t.prioridad_id = p.id
            WHERE t.id = ?
        ', [$id]);

        $usuarios = DB::select('SELECT * FROM usuarios');
        $estados = DB::select('SELECT * FROM estadostarea');
        $prioridades = DB::select('SELECT * FROM prioridad');

        return view('editar_tarea', compact('tarea', 'usuarios', 'estados', 'prioridades'));
    }

    public function actualizarTarea(Request $request, $id)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255',
            'usuario_id' => 'required|exists:usuarios,id',
            'estado_id' => 'required|exists:estadostarea,id',
            'prioridad_id' => 'required|exists:prioridad,id',
            'fecha_limite' => 'required|date',
        ]);

        DB::update('
            UPDATE tarea 
            SET descripcion = ?, usuario_id = ?, estado_id = ?, prioridad_id = ?, fecha_limite = ?
            WHERE id = ?
        ', [
            $validated['descripcion'],
            $validated['usuario_id'],
            $validated['estado_id'],
            $validated['prioridad_id'],
            $validated['fecha_limite'],
            $id
        ]);

        return redirect()->route('tareas.index')->with('success', 'Tarea actualizada correctamente.');
    }

    public function eliminarTarea($id)
    {
        DB::delete('DELETE FROM tarea WHERE id = ?', [$id]);

        return redirect()->route('tareas.index')->with('success', 'Tarea eliminada correctamente.');
    }

    
}
