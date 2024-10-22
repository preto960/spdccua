@extends('layouts.app')

@section('content')
    <h1 class="text-center mb-4">Ingresar Cédula</h1>

    <!-- Mensajes de éxito -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Mensajes de error -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="cedulaForm" action="{{ route('empleados.validar_cedula') }}" method="POST">
        @csrf
        <div class="mb-3">
            <input type="text" id="cedulaInput" name="cedula" class="form-control text-center @error('cedula') is-invalid @enderror" maxlength="10" placeholder="Ingrese su cédula" readonly required value="{{ old('cedula') }}">
            @error('cedula')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Teclado numérico -->
        <div class="text-center mb-3">
            <div class="grid-container">
                @for ($i = 1; $i <= 9; $i++)
                    <button type="button" class="btn btn-outline-secondary asisten" onclick="appendNumber({{ $i }})">{{ $i }}</button>
                @endfor
                <button type="button" class="btn btn-outline-secondary asisten" onclick="clearInput()">Borrar</button>
                <button type="button" class="btn btn-outline-secondary asisten" onclick="appendNumber(0)">0</button>
                <button type="submit" class="btn btn-outline-primary asisten">Entrar</button>
            </div>
        </div>
    </form>
@endsection

@section('script')
<script>
    function appendNumber(num) {
        const cedulaInput = document.getElementById('cedulaInput');
        if (cedulaInput.value.length < 10) {
            cedulaInput.value += num;
        }
    }

    function clearInput() {
        document.getElementById('cedulaInput').value = '';
    }
</script>

<style>
    .grid-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        max-width: 300px;
        margin: 0 auto;
    }

    .asisten{
        height: 70px;
        width: 100%;
        font-size: 1.5rem;
    }
</style>
@endsection
