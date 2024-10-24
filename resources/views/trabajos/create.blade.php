@extends('layouts.app')

@section('style')
    <style>
        .text-danger {
            color: red !important;
        }
    </style>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Registrar Solicitud</h1>
        <a href="{{ route('trabajos.index') }}" class="btn btn-success">
            <i class="fas fa-list"></i> Listado
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('trabajos.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="problema" class="form-label fw-bold">Problema:</label>
                <input type="text" id="problema" name="problema" class="form-control" value="{{ old('problema') }}" placeholder="Describe el problema" maxlength="100" required>
                @error('problema')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="direccion" class="form-label fw-bold">Dirección:</label>
                <input type="text" id="direccion" name="direccion" class="form-control" value="{{ old('direccion') }}" placeholder="Ingresa la dirección" maxlength="100" required>
                @error('direccion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="fecha_desde" class="form-label fw-bold">Fecha Desde:</label>
                <input type="date" id="fecha_desde" name="fecha_desde" class="form-control" value="{{ old('fecha_desde') }}" placeholder="dd-mm-aaaa" required>
                @error('fecha_desde')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="fecha_hasta" class="form-label fw-bold">Fecha Hasta:</label>
                <input type="date" id="fecha_hasta" name="fecha_hasta" class="form-control" value="{{ old('fecha_hasta') }}" placeholder="dd-mm-aaaa" required>
                @error('fecha_hasta')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="eje" class="form-label fw-bold">Eje:</label>
                <select id="eje" name="eje" class="form-select" required>
                    <option value="">Seleccione un eje</option>
                    @for ($i = 1; $i <= 30; $i++)
                        <option value="{{ $i }}" {{ old('eje') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                @error('eje')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="estatus" class="form-label fw-bold">Estado:</label>
                <select id="estatus" name="estatus" class="form-select" required>
                    <option value="1" {{ old('estatus') == 1 ? 'selected' : '' }} selected>Solicitud</option>
                    <option value="2" {{ old('estatus') == 2 ? 'selected' : '' }}>Planificación</option>
                    <option value="3" {{ old('estatus') == 3 ? 'selected' : '' }}>Ejecución</option>
                    <option value="4" {{ old('estatus') == 4 ? 'selected' : '' }}>Realizado</option>
                    <option value="5" {{ old('estatus') == 5 ? 'selected' : '' }}>En Espera</option>
                </select>
                @error('estatus')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label for="requerimiento" class="form-label fw-bold">Requerimiento:</label>
                <textarea id="requerimiento" name="requerimiento" class="form-control" rows="3" placeholder="Describa el requerimiento" maxlength="250" required oninput="updateCount()">{{ old('requerimiento') }}</textarea>
                <small id="charCount" class="form-text">0/250 caracteres</small>
                @error('requerimiento')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label for="fotos" class="form-label fw-bold">Fotos (1-5 imágenes):</label>
                <input type="file" id="fotos" name="fotos[]" class="form-control" accept="image/*" multiple required>
                @error('fotos')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Crear Solicitud</button>
    </form>
@endsection

@section('script')
    <script>
        document.getElementById('fotos').addEventListener('change', function() {
            if (this.files.length > 5) {
                alert("Puedes subir un máximo de 5 imágenes.");
                this.value = '';
            }
        });

        const maxChars = 250;

        function updateCount() {
            const textArea = document.getElementById('requerimiento');
            const charCount = document.getElementById('charCount');
            const currentLength = textArea.value.length;

            charCount.textContent = `${currentLength}/${maxChars} caracteres`;

            if (currentLength > maxChars) {
                textArea.value = textArea.value.substring(0, maxChars);
                charCount.textContent = `${maxChars}/${maxChars} caracteres`;
            }

            if (currentLength > maxChars) {
                charCount.classList.add('text-danger');
            } else {
                charCount.classList.remove('text-danger');
            }
        }
    </script>
@endsection
