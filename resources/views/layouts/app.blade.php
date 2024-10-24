<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPDC</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Agrega esto en la sección <head> de tu layout -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .navbar-toggler {
            border: none; /* Sin borde para un aspecto más limpio */
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='rgba%280, 0, 0, 0.5%29' stroke-width='2' d='M4 7h22M4 15h22M4 23h22' /%3E%3C/svg%3E");
            width: 30px;
            height: 30px;
        }

    </style>
    @yield('css')
</head>
<body class="bg-light">
    
    <!-- Menú de navegación -->{{--  navbar-expand-lg --}}
    <nav class="navbar navbar-light bg-white shadow-sm mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">SPDC - Cúa</a>
            @if(Auth::user())
            <div class="d-flex align-items-center">

                <!-- Botón cerrar session -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="button" class="btn btn-outline-default d-flex align-items-center justify-content-center me-2" style="cursor: pointer;" id="logout-button" onclick="logout()">
                        Cerrar Sesión
                    </button>
                </form>

                
                <!-- Botón rápido para asistencia -->
                <a href="{{ route('empleados.ingresar_cedula') }}" 
                class="btn btn-primary btn-sm d-flex align-items-center justify-content-center me-2" 
                style="width: 40px; height: 40px;">
                    <i class="fas fa-clipboard-check"></i>
                </a>


                <!-- Botón de menú hamburguesa -->
                <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
    
            </div>
    
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('empleados.index') }}">Empleados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('trabajos.index') }}">Solicitudes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cuadrillas.index') }}">Cuadrillas</a>
                    </li>
                </ul>
            </div>
            @else
            <div class="d-flex align-items-center">
                <a href="{{ route('login') }}" class="btn btn-outline-default d-flex align-items-center justify-content-center me-2">
                    Iniciar Sesión
                </a>
            </div>
            @endif
        </div>
    </nav>
       
    <div class="container mt-5">    
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @yield('content')

    </div>

    <!-- Bootstrap 5 JS & Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

    {{-- <script>

        // Función para establecer una cookie
        function setCookie(name, value, days) {
            try {
                const d = new Date();
                d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000)); // La cookie expira en 'days' días
                const expires = "expires=" + d.toUTCString();
                document.cookie = name + "=" + value + ";" + expires + ";path=/";
            } catch (e) {
                console.warn("No se pudo establecer la cookie:", e);
            }
        }

        // Función para obtener una cookie
        function getCookie(name) {
            try {
                const nameEQ = name + "=";
                const ca = document.cookie.split(';');
                for (let i = 0; i < ca.length; i++) {
                    let c = ca[i].trim();
                    if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
                }
            } catch (e) {
                console.warn("No se pudo obtener la cookie:", e);
            }
            return null;
        }

        // Función para guardar el `device_id` en `localStorage` si las cookies fallan
        function getDeviceId() {
            let deviceId = getCookie('device_id');
            if (!deviceId) {
                // Intentar obtener desde `localStorage` como fallback
                deviceId = localStorage.getItem('device_id');
                if (!deviceId) {
                    deviceId = 'device-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
                    try {
                        setCookie('device_id', deviceId, 365); // Guardar en cookie por 1 año
                    } catch (e) {
                        console.warn("No se pudo establecer la cookie, utilizando localStorage:", e);
                    }
                    localStorage.setItem('device_id', deviceId); // Guardar también en `localStorage`
                }
            }
            return deviceId;
        }

        // Función para enviar la ubicación al servidor
        function sendLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    const device_id = getDeviceId();

                    // Hacer la solicitud al servidor para guardar la ubicación
                    fetch('{{ route('g_ubi') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            latitude: lat,
                            longitude: lng,
                            device_id: device_id
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Guardada exitosamente:', data);
                    })
                    .catch(error => {
                        console.error('Error al guardar:', error);
                    });
                }, function (error) {
                    console.error('Error al obtener la ubicación:', error);
                });
            } else {
                console.log("La geolocalización no es soportada por este navegador.");
            }
        }

        // Ejecutar inmediatamente la primera vez
        sendLocation();

        // Configurar un intervalo para enviar la ubicación cada 10 minutos (600,000 ms)
        setInterval(sendLocation, 600000);


    </script> --}}
    <script>
        function disableButtons() {
            const forms = document.querySelectorAll('form');

            forms.forEach(form => {
                const buttons = form.querySelectorAll('button[type="submit"], button[type="button"]');
                buttons.forEach(button => {
                    button.addEventListener('click', function() {
                        button.disabled = true;
                        form.submit();
                    });
                });
            });
        }

        document.addEventListener('DOMContentLoaded', disableButtons);
    </script>

    @yield('script')
</body>
</html>
