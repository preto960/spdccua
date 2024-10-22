@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Editar Cuadrilla</h1>
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

    <form action="{{ route('cuadrillas.update', $cuadrilla->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la Cuadrilla</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $cuadrilla->nombre) }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion">{{ old('descripcion', $cuadrilla->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="estatus" class="form-label">Estatus</label>
            <select class="form-select @error('estatus') is-invalid @enderror" id="estatus" name="estatus" required>
                <option value="1" {{ $cuadrilla->estatus == '1' ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ $cuadrilla->estatus == '0' ? 'selected' : '' }}>Inactivo</option>
            </select>
            @error('estatus')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex">
            <!-- Empleados disponibles (solo los no asignados a esta cuadrilla) -->
            <div class="w-50 me-3">
                <label for="empleados_disponibles" class="form-label">Empleados Disponibles</label>
                <select id="empleados_disponibles" class="form-select" size="8" multiple>
                    @foreach ($empleadosDisponibles as $empleado)
                        @if (!$cuadrilla->empleados->contains($empleado->id))
                            <option value="{{ $empleado->id }}">{{ $empleado->nombre }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <!-- Botones para mover empleados -->
            <div class="d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-primary mb-2" id="agregarEmpleado">Agregar >></button>
                <button type="button" class="btn btn-danger" id="removerEmpleado"><< Remover</button>
            </div>

            <!-- Empleados asignados a la cuadrilla -->
            <div class="w-50 ms-3">
                <label for="empleados_asignados" class="form-label">Empleados Asignados</label>
                <select name="empleados[]" id="empleados_asignados" class="form-select @error('empleados') is-invalid @enderror" size="8" multiple>
                    @foreach ($cuadrilla->empleados as $empleadoAsignado)
                        <option value="{{ $empleadoAsignado->id }}">{{ $empleadoAsignado->nombre }}</option>
                    @endforeach
                </select>
                @error('empleados')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-4">Actualizar Cuadrilla</button>
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
