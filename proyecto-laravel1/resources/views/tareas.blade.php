<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tareas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin-top: 30px;
        }

        h1 {
            color: #007bff;
            text-align: center;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .table {
            margin-top: 20px;
            background-color: white;
            border-radius: 10px;
        }

        .modal-content {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        @include('menu')
        <h1 class="text-center mb-4">Gestión de Tareas</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#crearModal">
            Agregar Tarea
        </button>

        <div class="modal fade" id="crearModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Nueva Tarea</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('tareas.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <input type="text" name="descripcion" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Usuario</label>
                                <select name="usuario_id" class="form-control" required>
                                    <option value="">Seleccionar Usuario</option>
                                    @foreach($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}">{{ $usuario->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Fecha Límite</label>
                                <input type="date" name="fecha_limite" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Prioridad</label>
                                <select name="prioridad_id" class="form-control" required>
                                    @foreach($prioridades as $prioridad)
                                        <option value="{{ $prioridad->id }}">{{ $prioridad->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Estado</label>
                                <select name="estado_id" class="form-control" required>
                                    @foreach($estados as $estado)
                                        <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar Tarea</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Fecha Límite</th>
                    <th>Usuario</th>
                    <th>Prioridad</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tareas as $tarea)
                    <tr>
                        <td>{{ $tarea->descripcion }}</td>
                        <td>{{ $tarea->fecha_limite }}</td>
                        <td>{{ $tarea->usuario_nombre }}</td>
                        <td>{{ $tarea->prioridad_nombre }}</td>
                        <td>{{ $tarea->estado_nombre }}</td>
                        <td>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $tarea->id }}">
                                Editar
                            </button>
                            <div class="modal fade" id="editModal{{ $tarea->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Tarea</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('tareas.update', $tarea->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label class="form-label">Descripción</label>
                                                    <input type="text" name="descripcion" class="form-control" value="{{ $tarea->descripcion }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Usuario</label>
                                                    <select name="usuario_id" class="form-control" required>
                                                        @foreach($usuarios as $usuario)
                                                            <option value="{{ $usuario->id }}" 
                                                                {{ $tarea->usuario_id == $usuario->id ? 'selected' : '' }}>
                                                                {{ $usuario->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Fecha Límite</label>
                                                    <input type="date" name="fecha_limite" class="form-control" value="{{ $tarea->fecha_limite }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Prioridad</label>
                                                    <select name="prioridad_id" class="form-control" required>
                                                        @foreach($prioridades as $prioridad)
                                                            <option value="{{ $prioridad->id }}" 
                                                                {{ $tarea->prioridad_id == $prioridad->id ? 'selected' : '' }}>
                                                                {{ $prioridad->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Estado</label>
                                                    <select name="estado_id" class="form-control" required>
                                                        @foreach($estados as $estado)
                                                            <option value="{{ $estado->id }}" 
                                                                {{ $tarea->estado_id == $estado->id ? 'selected' : '' }}>
                                                                {{ $estado->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <form id="delete-form-{{ $tarea->id }}" action="{{ route('tareas.eliminar', $tarea->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(taskId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción eliminará la tarea',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + taskId).submit();
                }
            });
        }
    </script>
</body>
</html>
