@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Crear Cuadrilla</h1>
        <a href="{{ route('cuadrillas.index') }}" class="btn btn-success">
            <i class="fas fa-list"></i> Listado
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cuadrillas.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la Cuadrilla</label>
            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion">{{ old('descripcion') }}</textarea>
        </div>
        
        <div class="mb-3">
            <label for="estatus" class="form-label">Estatus</label>
            <select class="form-select @error('estatus') is-invalid @enderror" id="estatus" name="estatus" required>
                <option value="1" {{ old('estatus') == '1' ? 'selected' : '' }} selected>Activo</option>
                <option value="0" {{ old('estatus') == '0' ? 'selected' : '' }}>Inactivo</option>
            </select>
            @error('estatus')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="empleados_disponibles" class="form-label">Empleados Disponibles</label>
            <div class="d-flex">
                <select id="empleados_disponibles" class="form-select me-2" size="8" multiple>
                    @foreach ($empleadosDisponibles as $empleado)
                        <option value="{{ $empleado->id }}">{{ $empleado->nombre }}</option>
                    @endforeach
                </select>

                <div class="d-flex flex-column justify-content-center">
                    <button type="button" class="btn btn-primary mb-2" id="agregarEmpleado">Agregar >></button>
                    <button type="button" class="btn btn-danger" id="removerEmpleado"><< Remover</button>
                </div>

                <select name="empleados[]" id="empleados_asignados" class="form-select ms-2" size="8" multiple></select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Guardar</button>
    </form>

@endsection

@section('script')
    <script>
        document.getElementById('agregarEmpleado').addEventListener('click', function() {
            moverEmpleados('empleados_disponibles', 'empleados_asignados');
        });

        document.getElementById('removerEmpleado').addEventListener('click', function() {
            moverEmpleados('empleados_asignados', 'empleados_disponibles');
        });

        function moverEmpleados(origen, destino) {
            const origenSelect = document.getElementById(origen);
            const destinoSelect = document.getElementById(destino);
            const opcionesSeleccionadas = Array.from(origenSelect.selectedOptions);

            opcionesSeleccionadas.forEach(opcion => {
                destinoSelect.add(opcion);
            });
        }
    </script>
@endsection
