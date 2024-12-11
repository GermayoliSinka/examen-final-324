<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<style>
/* Colores Pastel */
:root {
    --color-fondo: #f7f8fa;  /* Fondo principal */
    --color-lateral: #a3c9f1; /* Menú lateral */
    --color-acento: #86c7d7;  /* Color de acento */
    --color-boton: #87a5d3;   /* Color de botones */
    --color-boton-hover: #a0c7e6; /* Hover en botones */
    --color-modal: #ffffff; /* Fondo del modal */
    --color-header: #6188a7; /* Header del modal */
    --color-text: #333; /* Color del texto */
}

/* Estilos generales */
body {
    font-family: 'Arial', sans-serif;
    background-color: var(--color-fondo);
    color: var(--color-text);
}

/* Menú Lateral */
.w-64 {
    background-color: var(--color-lateral);
    color: #fff;
}

.w-64 .text-xl {
    font-size: 1.5rem;
    font-weight: bold;
}


/* Estilos de la tabla */
.table-striped tbody tr:nth-child(odd) {
    background-color: #f9f9f9;
}

.table-bordered th, .table-bordered td {
    border: 1px solid #ddd;
}

.modal-content {
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: var(--color-modal);
}



.modal-body {
    background-color: var(--color-modal);
}

/* Estilos de los botones */
.btn-primary, .btn-success, .btn-warning, .btn-danger {
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 1rem;
    background-color: var(--color-boton);
    transition: background-color 0.3s ease;
}

.btn-primary:hover, .btn-success:hover, .btn-warning:hover, .btn-danger:hover {
    background-color: var(--color-boton-hover);
}

/* Botones específicos */
.btn-success {
    background-color: #a0d8b3;
}

.btn-warning {
    background-color: #f3d397;
}

.btn-danger {
    background-color: #f29797;
}

/* Espaciado de botones */
.mb-3 {
    margin-bottom: 1rem;
}

</style>
<body class="bg-gray-100">

    <div class="flex">
        <!-- Menú Lateral -->
        <div class="w-64 min-h-screen p-4">
            <div class="text-center text-xl font-bold mb-6">
                Sistema de Tareas
            </div>
            <ul>
                <li><a href="{{ route('dashboard') }}" class="block py-2 px-4 hover:bg-opacity-80">Dashboard</a></li>
                <li><a href="{{ route('tareas.dashboard') }}" class="block py-2 px-4 hover:bg-opacity-80">Tareas</a></li>
                <li><a href="#" class="block py-2 px-4 hover:bg-opacity-80">Otra opción</a></li>
            </ul>
        </div>

        <!-- Contenido Principal -->
        <div class="flex-1 p-6">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
