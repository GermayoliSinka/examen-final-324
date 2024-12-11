@extends('app')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center">Gestión de Usuarios</h1>
        
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#crearModal">
            Agregar Usuario
        </button>

        <!-- Tabla de Usuarios -->
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->nombre }}</td>
                        <td>{{ $usuario->correo }}</td>
                        <td>{{ $usuario->telefono }}</td>
                        <td>{{ $usuario->direccion }}</td>
                        <td>
                            <!-- Botón para abrir modal de edición -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarModal{{ $usuario->id }}">
                                Editar
                            </button>

                            <!-- Modal de Edición -->
                            <div class="modal fade" id="editarModal{{ $usuario->id }}" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editarModalLabel">Editar Usuario</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="nombre" class="form-label">Nombre</label>
                                                    <input type="text" name="nombre" class="form-control" value="{{ $usuario->nombre }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="correo" class="form-label">Correo</label>
                                                    <input type="email" name="correo" class="form-control" value="{{ $usuario->correo }}" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary w-100">Actualizar Usuario</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botón para eliminar -->
                            <form action="{{ route('usuarios.eliminar', $usuario->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal para Crear Usuario -->
        <div class="modal fade" id="crearModal" tabindex="-1" aria-labelledby="crearModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearModalLabel">Crear Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('usuarios.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo</label>
                                <input type="email" name="correo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" name="telefono" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" name="direccion" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Crear Usuario</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
