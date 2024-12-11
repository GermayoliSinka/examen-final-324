<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    

    public function dashboard() {
        $usuarios = DB::select('SELECT * FROM usuarios');
        return view('dashboard', compact('usuarios'));
    }

    public function editarUsuario($id) {
        $usuario = DB::select('SELECT * FROM usuarios WHERE id = ?', [$id]);
        return view('editar_usuario', compact('usuario'));
    }

    public function actualizarUsuario(Request $request, $id) {
        $request->validate([
            'nombre' => 'required|string',
            'correo' => 'required|email',
        ]);
    
        // Actualizar usuario
        DB::update('
            UPDATE usuarios 
            SET nombre = ?, correo = ?, updated_at = ? 
            WHERE id = ?
        ', [
            $request->nombre,
            $request->correo,
            now(),
            $id,
        ]);
    
        return redirect()->route('dashboard')->with('success', 'Usuario actualizado correctamente.');
    }

    public function eliminarUsuario($id) {
        DB::delete('DELETE FROM usuarios WHERE id = ?', [$id]);
        return redirect()->route('dashboard')->with('success', 'Usuario eliminado correctamente.');
    }

    public function storeUsuario(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'telefono' => 'nullable|string|max:15',  
            'direccion' => 'nullable|string|max:255',
        ]);

        DB::insert('
            INSERT INTO usuarios (nombre, correo, telefono, direccion, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?)
        ', [
            $validated['nombre'],
            $validated['correo'],
            $validated['telefono'] ?? null, 
            $validated['direccion'] ?? null,
            now(),  
            now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Usuario creado correctamente.');
    }
}
