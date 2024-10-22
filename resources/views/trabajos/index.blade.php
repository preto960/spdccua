@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Lista de Solicitudes</h1>
        <a href="{{ route('trabajos.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nuevo
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 5px;">&nbsp;</th>
                    <th class="text-center">ID</th>
                    <th>Problema</th>
                    <th class="text-center">Eje</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trabajos as $trabajo)
                    <tr>
                        <td style="width: 5px;"><span class="badge rounded-pill {{ $trabajo->estatus == 1 ? 'bg-success' : ($trabajo->estatus == 2 ? 'bg-danger' : ($trabajo->estatus == 3 ? 'bg-warning' : ($trabajo->estatus == 4 ? 'bg-primary' : 'bg-secondary')))}}">&nbsp;</span></td>
                        <td class="text-center">{{ $trabajo->id }}</td>
                        <td>{{ $trabajo->problema }}</td>
                        <td class="text-center">{{ $trabajo->eje }}</td>                        
                        <td class="text-center">
                            @if($trabajo->imagenes->count())
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modal{{ $trabajo->id }}">
                                    <i class="fas fa-image"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="modal{{ $trabajo->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $trabajo->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel{{ $trabajo->id }}">Imágenes de Trabajo ID: {{ $trabajo->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body d-flex">
                                                <!-- Miniaturas -->
                                                <div class="col-4" style="height: 400px; overflow-y: auto; border-right: 1px solid #ccc;">
                                                    @foreach($trabajo->imagenes as $imagen)
                                                        <img src="{{ Storage::url($imagen->imagen_path) }}" alt="Imagen" class="img-fluid mb-2 border border-dark" style="cursor: pointer; width: 100px; max-height: 120px;" data-large="{{ Storage::url($imagen->imagen_path) }}" onclick="showLargeImage('{{ Storage::url($imagen->imagen_path) }}', '{{ $trabajo->id }}')">
                                                    @endforeach
                                                </div>

                                                <!-- Imagen grande -->
                                                <div class="col-8 text-center">
                                                    <img id="largeImage{{ $trabajo->id }}" src="" alt="Imagen Grande" class="img-fluid" style="max-height: 500px; display: none;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                No hay imágenes
                            @endif
                            <a href="{{ route('trabajos.edit', $trabajo->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('trabajos.destroy', $trabajo->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
        function showLargeImage(src, trabajoId) {
            const largeImage = document.getElementById(`largeImage${trabajoId}`);
            if (src) {
                largeImage.src = src;
                largeImage.style.display = 'block'; 
            } else {
                largeImage.style.display = 'none'; 
            }
        }
    </script>
@endsection
