@extends('layouts.editor')

@section('title', 'Estadísticas')

@section('content')
<div class="page-header">
    <div class="page-title-row">
        <div>
            <h1 class="page-title">Estadísticas</h1>
            <p class="page-subtitle">Analiza el rendimiento de tus encuestas</p>
        </div>
    </div>
</div>

<div class="space-y-6">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <form action="{{ route('statistics.index') }}" method="GET" class="flex flex-col lg:flex-row gap-4 lg:items-end">
            <div class="w-full lg:w-1/3 lg:max-w-md">
                <label for="survey_id" class="block text-sm font-bold text-gray-700 mb-2">Encuesta:</label>
                <select name="survey_id" id="survey_id" onchange="this.form.submit()" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-uaemex transition">
                    @foreach($surveys as $survey)
                        <option value="{{ $survey->id }}" {{ $selectedSurvey && $selectedSurvey->id == $survey->id ? 'selected' : '' }}>
                            {{ $survey->title }} ({{ \Carbon\Carbon::parse($survey->start_date)->year }})
                        </option>
                    @endforeach
                    @if($surveys->isEmpty())
                        <option value="">No hay encuestas disponibles</option>
                    @endif
                </select>
            </div>
            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="from_date" class="block text-xs font-bold text-gray-700 mb-1 uppercase tracking-wide">Desde</label>
                    <input type="date" id="from_date" name="from_date" value="{{ request('from_date') }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:border-uaemex transition">
                </div>
                <div>
                    <label for="to_date" class="block text-xs font-bold text-gray-700 mb-1 uppercase tracking-wide">Hasta</label>
                    <input type="date" id="to_date" name="to_date" value="{{ request('to_date') }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:border-uaemex transition">
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-uaemex text-white rounded-lg text-sm font-bold hover:bg-green-800 transition flex items-center gap-2">
                    <i class="fas fa-filter"></i> Aplicar
                </button>
                <a href="{{ route('statistics.index', ['survey_id' => optional($selectedSurvey)->id]) }}" class="px-3 py-2 border border-gray-300 text-gray-600 rounded-lg text-xs font-semibold hover:bg-gray-50 transition">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    @if($selectedSurvey)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:border-uaemex transition">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
                <i class="fas fa-poll text-6xl text-uaemex"></i>
            </div>
            <div class="flex items-center gap-4 mb-2">
                <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                    <i class="fas fa-chart-bar text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-700">Total Respuestas</h3>
            </div>
            <p class="text-4xl font-bold text-gray-900 mb-2">{{ $stats['total_responses'] }}</p>
            <span class="{{ $stats['responses_growth'] >= 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} text-xs font-bold px-2 py-1 rounded-full flex inline-flex items-center gap-1">
                <i class="fas fa-arrow-{{ $stats['responses_growth'] >= 0 ? 'up' : 'down' }}"></i>
                {{ abs($stats['responses_growth']) }}% vs año anterior
            </span>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:border-uaemex transition">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
                <i class="fas fa-check-circle text-6xl text-green-600"></i>
            </div>
            <div class="flex items-center gap-4 mb-2">
                <div class="p-3 bg-green-50 rounded-lg text-green-600">
                    <i class="fas fa-check text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-700">Tasa de Completado</h3>
            </div>
            <p class="text-4xl font-bold text-gray-900 mb-2">{{ $stats['completion_rate'] }}%</p>
            <span class="{{ $stats['completion_growth'] >= 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} text-xs font-bold px-2 py-1 rounded-full flex inline-flex items-center gap-1">
                <i class="fas fa-arrow-{{ $stats['completion_growth'] >= 0 ? 'up' : 'down' }}"></i>
                {{ abs($stats['completion_growth']) }}% vs año anterior
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mt-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between gap-2">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Evolución de respuestas</h3>
                    <p class="text-xs text-gray-500">Respuestas por día en el periodo seleccionado</p>
                </div>
            </div>
            <div class="p-6 h-72">
                <canvas id="evolutionChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between gap-2">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Distribución de respuestas</h3>
                    <p class="text-xs text-gray-500">Primera pregunta de opción múltiple o casillas</p>
                </div>
            </div>
            <div class="p-6 h-72">
                <canvas id="distributionChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <h3 class="font-bold text-gray-800 text-lg">Respuestas Individuales</h3>
            <div class="flex gap-2">
                <button class="px-4 py-2 border border-green-600 text-green-600 rounded-lg text-sm font-bold hover:bg-green-50 transition flex items-center gap-2">
                    <i class="fas fa-file-excel"></i> Exportar Excel
                </button>
                <button class="px-4 py-2 border border-red-600 text-red-600 rounded-lg text-sm font-bold hover:bg-red-50 transition flex items-center gap-2">
                    <i class="fas fa-file-pdf"></i> Exportar PDF
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-orange-50 text-gray-700 text-sm uppercase tracking-wider">
                        <th class="p-4 font-bold border-b border-orange-100">Fecha</th>
                        <th class="p-4 font-bold border-b border-orange-100">Respuestas (Resumen)</th>
                        <th class="p-4 font-bold border-b border-orange-100">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @forelse($stats['recent_responses'] as $response)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 text-gray-600 font-medium">{{ $response['date'] }}</td>
                            <td class="p-4 text-gray-500">{{ Str::limit($response['summary'], 50) }}</td>
                            <td class="p-4">
                                <button class="text-uaemex hover:text-green-800 font-bold text-xs uppercase">Ver detalle</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-8 text-center text-gray-400">
                                <i class="far fa-folder-open text-4xl mb-3 block opacity-50"></i>
                                No hay respuestas registradas para esta encuesta.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(count($stats['recent_responses']) > 0)
        <div class="p-4 border-t border-gray-100 text-center text-sm text-gray-500">
            Mostrando {{ count($stats['recent_responses']) }} respuestas recientes
        </div>
        @endif
    </div>
    @else
    <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 border-dashed">
        <i class="fas fa-chart-pie text-6xl text-gray-200 mb-4"></i>
        <h2 class="text-xl font-bold text-gray-400">Selecciona una encuesta para ver sus estadísticas</h2>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stats = @json($stats);

        Chart.defaults.font.family = "'Figtree', sans-serif";
        Chart.defaults.color = '#6b7280';
        
        const ctxDistribution = document.getElementById('distributionChart');
        if (ctxDistribution && stats.responses_distribution) {
            new Chart(ctxDistribution, {
                type: 'bar',
                data: {
                    labels: stats.responses_distribution.labels,
                    datasets: [{
                        label: 'Respuestas',
                        data: stats.responses_distribution.data,
                        backgroundColor: '#4ade80',
                        borderRadius: 4,
                        hoverBackgroundColor: '#22c55e'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [2, 2],
                                color: '#f3f4f6'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        const ctxEvolution = document.getElementById('evolutionChart');
        if (ctxEvolution && stats.responses_per_day) {
            new Chart(ctxEvolution, {
                type: 'line',
                data: {
                    labels: stats.responses_per_day.labels,
                    datasets: [{
                        label: 'Respuestas por periodo',
                        data: stats.responses_per_day.data,
                        borderColor: '#bca06d',
                        backgroundColor: 'rgba(188, 160, 109, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#bca06d',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [2, 2],
                                color: '#f3f4f6'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
