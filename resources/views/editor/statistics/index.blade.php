@extends('layouts.editor')

@section('title', 'Estadísticas')

@section('content')
<div class="stats-container space-y-8 font-sans">
    
    <!-- Header -->
    <div>
        <div class="text-xs font-bold text-oro uppercase tracking-wider mb-1 font-mono">EDITOR · ANÁLISIS</div>
        <h1 class="text-4xl font-bold text-uaemex mb-2 font-display">Estadísticas</h1>
        <p class="text-gray-500">Analiza el rendimiento de tus encuestas</p>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-3xl shadow-sm border border-gray-100 flex flex-col lg:flex-row items-center gap-4 justify-between">
        <form action="{{ route('statistics.index') }}" method="GET" class="w-full flex flex-col lg:flex-row items-center gap-4">
            
            <!-- Survey Select -->
            <div class="flex items-center gap-3 w-full lg:w-auto flex-1">
                <span class="text-sm font-bold text-gray-500 whitespace-nowrap">Encuesta:</span>
                <div class="relative w-full">
                    <select name="survey_id" onchange="this.form.submit()" class="w-full bg-gray-100 border-none rounded-xl px-4 py-2.5 pr-10 text-gray-700 font-medium focus:ring-2 focus:ring-uaemex cursor-pointer appearance-none outline-none">
                        @foreach($surveys as $survey)
                            <option value="{{ $survey->id }}" {{ $selectedSurvey && $selectedSurvey->id == $survey->id ? 'selected' : '' }}>
                                {{ $survey->title }}
                            </option>
                        @endforeach
                        @if($surveys->isEmpty())
                            <option value="">No hay encuestas disponibles</option>
                        @endif
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                        <!-- Chevron Down Icon -->
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Date Range -->
            <div class="flex items-center gap-2 w-full lg:w-auto">
                <span class="text-sm font-bold text-gray-500 whitespace-nowrap">Desde:</span>
                <div class="relative">
                    <input type="date" name="from_date" value="{{ request('from_date') }}" class="bg-gray-100 border-none rounded-xl px-4 py-2.5 text-gray-700 font-medium text-sm focus:ring-2 focus:ring-uaemex w-full lg:w-40 outline-none">
                </div>
            </div>
            
            <div class="flex items-center gap-2 w-full lg:w-auto">
                <span class="text-sm font-bold text-gray-500 whitespace-nowrap">Hasta:</span>
                <div class="relative">
                    <input type="date" name="to_date" value="{{ request('to_date') }}" class="bg-gray-100 border-none rounded-xl px-4 py-2.5 text-gray-700 font-medium text-sm focus:ring-2 focus:ring-uaemex w-full lg:w-40 outline-none">
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2 w-full lg:w-auto justify-end lg:justify-start">
                <button type="submit" class="bg-uaemex text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-uaemex-light transition flex items-center gap-2 shadow-lg shadow-green-900/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Aplicar
                </button>
                <a href="{{ route('statistics.index', ['survey_id' => optional($selectedSurvey)->id]) }}" class="bg-gray-100 text-gray-600 px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-gray-200 transition">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    @if(!$selectedSurvey)
        <!-- Empty State -->
        <div class="bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200 p-12 text-center flex flex-col items-center justify-center min-h-[400px]">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-700 mb-2">Selecciona una encuesta para ver sus estadísticas</h3>
            <p class="text-gray-500 max-w-md">Cuando tus encuestas reciban respuestas, verás la evolución y distribución aquí</p>
        </div>
    @else
        <!-- KPIs -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Total Responses Card -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-8 relative overflow-hidden">
                <div class="relative w-32 h-32 flex-shrink-0 flex items-center justify-center">
                    <!-- Circular Background -->
                    <div class="absolute inset-0 rounded-full border-[6px] border-gray-100"></div>
                    <!-- Circular Progress (Static for Total - Visual Only) -->
                    <svg class="absolute inset-0 w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                         <circle cx="50" cy="50" r="46" stroke="currentColor" stroke-width="6" fill="transparent" class="text-uaemex" stroke-dasharray="289" stroke-dashoffset="72" stroke-linecap="round" />
                    </svg>
                    <div class="text-center z-10">
                        <span class="block text-3xl font-bold text-gray-800">{{ $stats['total_responses'] }}</span>
                        <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">RESP.</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-1">Total de Respuestas</h3>
                    <p class="text-sm text-gray-500 mb-3">Periodo seleccionado</p>
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-bold {{ $stats['responses_growth'] >= 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($stats['responses_growth'] >= 0)
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            @endif
                        </svg>
                        {{ abs($stats['responses_growth']) }}% vs año anterior
                    </span>
                </div>
            </div>

            <!-- Completion Rate Card -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-8 relative overflow-hidden">
                <div class="relative w-32 h-32 flex-shrink-0 flex items-center justify-center">
                    <!-- Circular Background -->
                    <div class="absolute inset-0 rounded-full border-[6px] border-gray-100"></div>
                    <!-- Circular Progress (Dynamic based on percentage) -->
                    <svg class="absolute inset-0 w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                        <circle cx="50" cy="50" r="46" stroke="currentColor" stroke-width="6" fill="transparent" class="text-gray-100" />
                        <circle cx="50" cy="50" r="46" stroke="currentColor" stroke-width="6" fill="transparent" class="text-uaemex" 
                            stroke-dasharray="289" 
                            stroke-dashoffset="{{ 289 - (289 * $stats['completion_rate'] / 100) }}" 
                            stroke-linecap="round" />
                    </svg>
                    <div class="text-center z-10">
                        <span class="block text-3xl font-bold text-gray-800">{{ $stats['completion_rate'] }}%</span>
                        <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">COMP.</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-1">Tasa de Completado</h3>
                    <p class="text-sm text-gray-500 mb-3">Formularios finalizados</p>
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-bold {{ $stats['completion_growth'] >= 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                         {{ $stats['completion_growth'] == 0 ? 'Sin variación' : abs($stats['completion_growth']) . '% vs año anterior' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Evolution Chart -->
            <div class="lg:col-span-2 bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Evolución de respuestas</h3>
                    <p class="text-sm text-gray-500">Por día en el periodo seleccionado</p>
                </div>
                <div class="h-64">
                    <canvas id="evolutionChart"></canvas>
                </div>
            </div>

            <!-- Distribution Chart -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Distribución</h3>
                </div>
                <div class="relative h-48 flex items-center justify-center">
                    <canvas id="distributionChart"></canvas>
                    <div class="absolute inset-0 flex items-center justify-center flex-col pointer-events-none">
                        <span class="text-2xl font-bold text-gray-800">{{ $stats['total_responses'] }}</span>
                        <span class="text-[10px] font-bold text-gray-400 uppercase">TOTAL</span>
                    </div>
                </div>
                <div class="mt-6 space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded bg-uaemex"></span>
                            <span class="text-gray-600 font-medium">Completadas</span>
                        </div>
                        <span class="font-bold text-gray-800">{{ $stats['response_status']['data'][0] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded bg-oro"></span>
                            <span class="text-gray-600 font-medium">En progreso</span>
                        </div>
                        <span class="font-bold text-gray-800">{{ $stats['response_status']['data'][1] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded bg-gray-300"></span>
                            <span class="text-gray-600 font-medium">Abandonadas</span>
                        </div>
                        <span class="font-bold text-gray-800">{{ $stats['response_status']['data'][2] ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Options Distribution -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-800">Distribución de opciones</h3>
                <p class="text-sm text-gray-500">Primera pregunta de opción múltiple</p>
            </div>
            
            <div class="space-y-6">
                @php
                    $maxVal = max($stats['responses_distribution']['data'] ?: [1]);
                @endphp
                @foreach($stats['responses_distribution']['labels'] as $index => $label)
                    @php
                        $value = $stats['responses_distribution']['data'][$index];
                        $percentage = $maxVal > 0 ? ($value / $maxVal) * 100 : 0;
                        $totalPercentage = array_sum($stats['responses_distribution']['data']) > 0 
                            ? round(($value / array_sum($stats['responses_distribution']['data'])) * 100, 1) 
                            : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="font-medium text-gray-600">{{ $label }}</span>
                            <span class="font-bold text-gray-800">{{ $totalPercentage }}%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                            <div class="bg-uaemex h-3 rounded-full transition-all duration-1000 ease-out" style="width: {{ $totalPercentage }}%"></div>
                        </div>
                    </div>
                @endforeach

                @if(empty($stats['responses_distribution']['labels']) || (count($stats['responses_distribution']['labels']) == 1 && $stats['responses_distribution']['labels'][0] == 'Sin preguntas cerradas'))
                    <div class="text-center py-8 text-gray-400 italic">
                        No hay datos de preguntas cerradas para mostrar.
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Global Configuration
        Chart.defaults.font.family = "'Nunito', sans-serif";
        Chart.defaults.color = '#6b7280';
        
        // Evolution Chart
        const ctxEvolution = document.getElementById('evolutionChart');
        if (ctxEvolution) {
            new Chart(ctxEvolution, {
                type: 'bar',
                data: {
                    labels: @json($stats['responses_per_day']['labels']),
                    datasets: [{
                        label: 'Respuestas',
                        data: @json($stats['responses_per_day']['data']),
                        backgroundColor: '#2D5016',
                        borderRadius: 4,
                        barThickness: 40,
                        hoverBackgroundColor: '#3a6b1c'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#2D5016',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [2, 4],
                                color: '#f3f4f6',
                                drawBorder: false
                            },
                            ticks: { font: { size: 11 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 } }
                        }
                    }
                }
            });
        }

        // Distribution Chart (Donut)
        const ctxDistribution = document.getElementById('distributionChart');
        if (ctxDistribution) {
            new Chart(ctxDistribution, {
                type: 'doughnut',
                data: {
                    labels: ['Completadas', 'En progreso', 'Abandonadas'],
                    datasets: [{
                        data: @json($stats['response_status']['data']),
                        backgroundColor: ['#2D5016', '#C99A0A', '#d1d5db'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    let value = context.raw;
                                    let total = context.chart._metasets[context.datasetIndex].total;
                                    let percentage = Math.round((value / total) * 100) + '%';
                                    return label + value + ' (' + percentage + ')';
                                }
                            },
                            backgroundColor: '#2D5016',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: true
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection