<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = DB::select('SELECT * FROM usuarios');
        return view('usuarios', compact('usuarios'));
    }

    public function editarUsuario($id) {
        $usuario = DB::selectOne('SELECT * FROM usuarios WHERE id = ?', [$id]);
        return view('editar_usuario', compact('usuario'));
    }

    public function actualizarUsuario(Request $request, $id) {
        $request->validate([
            'nombre' => 'required|string',
            'correo' => 'required|email',
        ]);
    
        DB::update('
            UPDATE usuarios 
            SET nombre = ?, correo = ?
            WHERE id = ?
        ', [
            $request->nombre,
            $request->correo,
            $id,
        ]);
    
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function eliminarUsuario($id) {
        DB::delete('DELETE FROM usuarios WHERE id = ?', [$id]);
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
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
            INSERT INTO usuarios (nombre, correo)
            VALUES (?, ?)
        ', [
            $validated['nombre'],
            $validated['correo'],
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }
}
