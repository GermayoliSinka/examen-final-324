@extends('.app')

@section('content')
    <div class="container mt-4">
        <h1>Lista de Tareas</h1>

        <!-- Tabla de Tareas -->
        <table class="table">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Usuario</th>
                    <th>Estado</th>
                    <th>Prioridad</th>
                    <th>Fecha Límite</th>
                    <th>Fecha Creación</th>
                    <th>Fecha Actualización</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tareas as $tarea)
                    <tr>
                        <td>{{ $tarea->descripcion }}</td>
                        <td>{{ $tarea->usuario }}</td>
                        <td>{{ $tarea->estado }}</td>
                        <td>{{ $tarea->prioridad }}</td>
                        <td>{{ $tarea->fecha_limite }}</td>
                        <td>{{ $tarea->fecha_creacion }}</td>
                        <td>{{ $tarea->fecha_actualizacion }}</td>
                        <td>
                            <!-- Botón de edición de tarea -->
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarModal{{ $tarea->id }}">Editar</button>

                            <!-- Formulario para eliminar tarea -->
                            <form action="{{ route('tarea.eliminar', $tarea->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Botón para agregar nueva tarea -->
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearModal">Crear Nueva Tarea</button>
    </div>

    <!-- Modal para editar tarea -->
@foreach($tareas as $tarea)
<div class="modal fade" id="editarModal{{ $tarea->id }}" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('tarea.actualizar', $tarea->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editarModalLabel">Editar Tarea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Campos de edición -->
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <input type="text" class="form-control" name="descripcion" value="{{ $tarea->descripcion }}" required>
                    </div>
                    <div class="form-group">
                        <label for="estado_id">Estado</label>
                        <select class="form-control" name="estado_id" required>
                            @foreach($estadosTarea as $estado)
                                <option value="{{ $estado->id }}" {{ $estado->id == $tarea->estado_id ? 'selected' : '' }}>
                                    {{ $estado->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
    <label for="prioridad_id">Prioridad</label>
    <select class="form-control" name="prioridad_id" required>
        @foreach($prioridades as $prioridad)
            <option value="{{ $prioridad->id }}" 
                {{ $tarea->prioridad_id == $prioridad->id ? 'selected' : '' }}>
                {{ $prioridad->nombre }}
            </option>
        @endforeach
    </select>
</div>
                    <div class="form-group">
                        <label for="fecha_limite">Fecha Límite</label>
                        <input type="date" class="form-control" name="fecha_limite" value="{{ $tarea->fecha_limite }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach


    <!-- Modal para crear nueva tarea -->
    <div class="modal fade" id="crearModal" tabindex="-1" aria-labelledby="crearModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('tarea.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearModalLabel">Crear Nueva Tarea</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Campos para crear tarea -->
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <input type="text" class="form-control" name="descripcion" required>
                        </div>
                        <div class="form-group">
                            <label for="usuario_id">Usuario</label>
                            <select class="form-control" name="usuario_id" required>
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}">{{ $usuario->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="estado_id">Estado</label>
                            <select class="form-control" name="estado_id" required>
                                @foreach($estadosTarea as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="prioridad_id">Prioridad</label>
                            <select class="form-control" name="prioridad_id" required>
                                @foreach($prioridades as $prioridad)
                                    <option value="{{ $prioridad->id }}">{{ $prioridad->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fecha_limite">Fecha Límite</label>
                            <input type="date" class="form-control" name="fecha_limite" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection