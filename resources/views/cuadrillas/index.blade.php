@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Listado de Cuadrillas</h1>
        <a href="{{ route('cuadrillas.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nueva
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 5px;">&nbsp;</th>
                    <th class="text-center">ID</th>
                    <th>Nombre</th>
                    <th class="text-center">Empleados</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cuadrillas as $cuadrilla)
                    <tr>
                        <td style="width: 5px;"><span class="badge rounded-pill {{ $cuadrilla->estatus == 1 ? 'bg-success' : 'bg-danger'}}">&nbsp;</span></td>
                        <td class="text-center">{{ $cuadrilla->id }}</td>
                        <td>{{ $cuadrilla->nombre }}</td>
                        <td class="text-center">
                            {{count($cuadrilla->empleados)}}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('cuadrillas.edit', $cuadrilla->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('cuadrillas.destroy', $cuadrilla->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
