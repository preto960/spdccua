@extends('layouts.app')

@section('style')
    <style>
        .text-danger {
            color: red !important;
        }
        .form-container {
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Registrar Solicitud</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('solicitud.store') }}" method="POST" enctype="multipart/form-data" class="form-container bg-white p-4 rounded shadow-sm">
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

        <input type="hidden" id="fecha_desde" name="fecha_desde" class="form-control" value="{{ old('fecha_desde', \Carbon\Carbon::now()->format('Y-m-d')) }}">
        <input type="hidden" id="fecha_hasta" name="fecha_hasta" class="form-control" value="{{ old('fecha_hasta', \Carbon\Carbon::now()->format('Y-m-d')) }}">

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
                </select>
                @error('estatus')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="requerimiento" class="form-label fw-bold">Requerimiento:</label>
            <textarea id="requerimiento" name="requerimiento" class="form-control" rows="2" placeholder="Especifica tu requerimiento" required maxlength="400" oninput="updateCount()">{{ old('requerimiento') }}</textarea>
            <small id="charCount" class="form-text">0/400 caracteres</small>
            @error('requerimiento')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="fotos" class="form-label fw-bold">Fotos (1-5 imágenes):</label>
            <input type="file" id="fotos" name="fotos[]" class="form-control" accept="image/*" multiple required>
            @error('fotos')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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

        const maxChars = 400;

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
