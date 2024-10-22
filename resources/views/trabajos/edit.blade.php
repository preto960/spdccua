@extends('layouts.app')

@section('content')
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Editar Solicitud ID: {{ $trabajo->id }}</h1>
        <a href="{{ route('trabajos.index') }}" class="btn btn-success">
            <i class="fas fa-list"></i> Listado
        </a>
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

    <form action="{{ route('trabajos.update', $trabajo->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="problema" class="form-label fw-bold">Problema:</label>
            <input type="text" class="form-control" id="problema" name="problema" value="{{ $trabajo->problema }}" required>
            @error('problema')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="fecha_desde" class="form-label fw-bold">Fecha Desde:</label>
            <input type="date" id="fecha_desde" name="fecha_desde" class="form-control" value="{{ $trabajo->fecha_desde }}" required>
            @error('fecha_desde')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="fecha_hasta" class="form-label fw-bold">Fecha Hasta:</label>
            <input type="date" id="fecha_hasta" name="fecha_hasta" class="form-control" value="{{ $trabajo->fecha_hasta }}" required>
            @error('fecha_hasta')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="direccion" class="form-label fw-bold">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="{{ $trabajo->direccion }}" required>
            @error('direccion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="eje" class="form-label fw-bold">Eje:</label>
            <select id="eje" name="eje" class="form-select" required>
                <option value="">Seleccione un eje</option>
                @for ($i = 1; $i <= 30; $i++)
                    <option value="{{ $i }}" {{ old('eje') == $i || $i == $trabajo->eje ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
            @error('eje')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="estatus" class="form-label fw-bold">Estado:</label>
            <select class="form-select" id="estatus" name="estatus" required>
                <option value="1" {{ $trabajo->estatus == 1 ? 'selected' : '' }}>Solicitud</option>
                <option value="2" {{ $trabajo->estatus == 2 ? 'selected' : '' }}>Planificación</option>
                <option value="3" {{ $trabajo->estatus == 3 ? 'selected' : '' }}>Ejecución</option>
                <option value="3" {{ $trabajo->estatus == 4 ? 'selected' : '' }}>Realizado</option>
                <option value="3" {{ $trabajo->estatus == 5 ? 'selected' : '' }}>En Espera</option>
            </select>
            @error('estatus')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="requerimiento" class="form-label fw-bold">Requerimiento:</label>
            <textarea class="form-control" id="requerimiento" name="requerimiento" rows="3" required>{{ $trabajo->requerimientos }}</textarea>
            @error('requerimiento')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="fotos" class="form-label fw-bold">Cambiar Imágenes (opcional):</label>
            <input type="file" class="form-control" id="fotos" name="fotos[]" multiple accept="image/*">
            @error('fotos')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <h5>Imágenes Actuales:</h5>
            <div class="row">
                @foreach($trabajo->imagenes as $imagen)
                    <div class="col-3 mb-4 d-flex flex-column align-items-center">
                        <img src="{{ Storage::url($imagen->imagen_path) }}" 
                             alt="Imagen" 
                             class="img-fluid border border-dark mb-2" 
                             style="width: 100px; height: 120px; border-radius: 10px; opacity: 0.8;">
                        
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteImage('{{ route('imagenes.destroy', $imagen->id) }}', this)">Eliminar</button>
                    </div>
                @endforeach
            </div>
        </div>
        
        

        <div class="d-flex justify-content-between align-items-center mb-4">
            <button type="submit" class="btn btn-primary">Actualizar Trabajo</button>
            <a href="{{ route('trabajos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>

    </form>
@endsection

@section('script')
<script>
    function deleteImage(url, button) {
        if (confirm("¿Estás seguro de que deseas eliminar esta imagen?")) {
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Asegúrate de incluir el token CSRF
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    // Eliminar el elemento del DOM
                    const col = button.closest('.col-3');
                    col.remove();
                    alert('Imagen eliminada con éxito.');
                } else {
                    alert('Error al eliminar la imagen.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un problema al eliminar la imagen.');
            });
        }
    }
</script>

@endsection
