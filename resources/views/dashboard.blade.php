@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <!-- Tarjeta de Empleados -->
    <div class="col-md-6">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Total de Empleados</div>
            <div class="card-body">
                <h5 class="card-title">{{ $empleadosCount }}</h5>
            </div>
        </div>
    </div>

    <!-- Tarjeta de Trabajos -->
    <div class="col-md-6">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">Total de Solicitudes</div>
            <div class="card-body">
                <h5 class="card-title">{{ $trabajosCount }}</h5>
            </div>
        </div>
    </div>
</div>

<!-- Gráfica de Estatus -->
<div class="card mb-4">
    <div class="card-header">Estatus de Solicitudes</div>
    <div class="card-body">
        <canvas id="estatusChart"></canvas>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    // Definir los estatus en el frontend (pasado desde el backend)
    const estatusLabels = @json([
        1 => 'Activo',
        2 => 'Resuelto',
        3 => 'No Resuelto'
    ]);

    // Datos para la gráfica de barras (estatus)
    const estatusCounts = @json($estatusCountsWithLabels);
    const colors = ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'];

    // Crear datasets separados para cada estatus
    const datasets = Object.keys(estatusCounts).map((estatus, index) => ({
        label: estatus, // Nombre de cada estatus
        data: [estatusCounts[estatus]], // El conteo de trabajos por estatus
        backgroundColor: colors[index],
        borderColor: colors[index].replace('1)', '0.8)'),
        borderWidth: 1
    }));

    const estatusData = {
        labels: ['Conteo de Trabajos'], // Etiqueta única para la gráfica
        datasets: datasets // Múltiples datasets
    };

    const estatusConfig = {
        type: 'bar',
        data: estatusData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: true, // Mostrar la leyenda
                    onClick: function(e, legendItem) {
                        const index = legendItem.datasetIndex;
                        const chart = this.chart;
                        const meta = chart.getDatasetMeta(index);

                        // Alternar la visibilidad del dataset
                        meta.hidden = meta.hidden === null ? !chart.data.datasets[index].hidden : null;
                        chart.update();
                    }
                }
            }
        }
    };

    new Chart(document.getElementById('estatusChart'), estatusConfig);
</script>
@endsection
