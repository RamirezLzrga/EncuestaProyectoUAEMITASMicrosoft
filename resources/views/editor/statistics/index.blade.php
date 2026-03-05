@extends('layouts.editor')

@section('title', 'Estadísticas')

@section('content')
<div class="ph">
    <div>
        <div class="ph-label">Análisis</div>
        <h1 class="ph-title">Estadísticas</h1>
        <div class="ph-sub">Analiza el rendimiento de tus encuestas y descarga reportes</div>
    </div>
</div>

<div class="surveys-layout">
    <div class="nc">
        <form action="{{ route('statistics.index') }}" method="GET" class="filter-neu shadow-none p-0 bg-transparent">
            <div class="fn-search max-w-md">
                <label for="survey_id" class="fn-label block mb-2">Encuesta</label>
                <div class="relative">
                    <select name="survey_id" id="survey_id" onchange="this.form.submit()" class="fn-input w-full">
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
            </div>

            <div class="flex gap-4 flex-1">
                <div>
                    <label for="from_date" class="fn-label block mb-2">Desde</label>
                    <input type="date" id="from_date" name="from_date" value="{{ request('from_date') }}" class="fn-input">
                </div>
                <div>
                    <label for="to_date" class="fn-label block mb-2">Hasta</label>
                    <input type="date" id="to_date" name="to_date" value="{{ request('to_date') }}" class="fn-input">
                </div>
            </div>

            <div class="flex gap-3 items-end pb-px">
                <button type="submit" class="btn btn-solid btn-sm">
                    <i class="fas fa-filter"></i> Aplicar
                </button>
                <a href="{{ route('statistics.index', ['survey_id' => optional($selectedSurvey)->id]) }}" class="btn btn-neu btn-sm">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    @if($selectedSurvey)
    <div class="kpi-row grid-cols-2">
        <div class="kpi-card">
            <div class="kp-top">
                <div class="kp-icon text-[var(--blue)]"><i class="fas fa-chart-bar"></i></div>
                <span class="kp-change {{ $stats['responses_growth'] >= 0 ? 'kp-up' : 'kp-down' }}">
                    {{ $stats['responses_growth'] >= 0 ? '↑' : '↓' }} {{ abs($stats['responses_growth']) }}%
                </span>
            </div>
            <div class="kp-value">{{ $stats['total_responses'] }}</div>
            <div class="kp-label">Total Respuestas</div>
            <div class="kp-desc">Comparado con el año anterior</div>
            <div class="kpi-card-bg bg-[var(--blue)]"></div>
        </div>

        <div class="kpi-card">
            <div class="kp-top">
                <div class="kp-icon text-[var(--verde)]"><i class="fas fa-check-circle"></i></div>
                <span class="kp-change {{ $stats['completion_growth'] >= 0 ? 'kp-up' : 'kp-down' }}">
                    {{ $stats['completion_growth'] >= 0 ? '↑' : '↓' }} {{ abs($stats['completion_growth']) }}%
                </span>
            </div>
            <div class="kp-value">{{ $stats['completion_rate'] }}%</div>
            <div class="kp-label">Tasa de Completado</div>
            <div class="kp-desc">Encuestas finalizadas vs iniciadas</div>
            <div class="kpi-card-bg bg-[var(--verde)]"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="nc">
            <div class="ph mb-5">
                <div>
                    <h3 class="ph-title text-base">Evolución de respuestas</h3>
                    <p class="ph-sub">Respuestas por día en el periodo seleccionado</p>
                </div>
            </div>
            <div class="h-[300px] w-full">
                <canvas id="evolutionChart"></canvas>
            </div>
        </div>

        <div class="nc">
            <div class="ph mb-5">
                <div>
                    <h3 class="ph-title text-base">Distribución de respuestas</h3>
                    <p class="ph-sub">Primera pregunta de opción múltiple</p>
                </div>
            </div>
            <div class="h-[300px] w-full">
                <canvas id="distributionChart"></canvas>
            </div>
        </div>
    </div>

    <div class="nc p-0 overflow-hidden">
        <div class="p-6 border-b border-[var(--neu-dark)]/20 flex flex-col md:flex-row justify-between items-center gap-4">
            <h3 class="font-bold text-[var(--text-dark)] text-lg">Respuestas Individuales</h3>
            <div class="flex gap-2">
                <button class="btn btn-neu btn-sm text-[var(--verde)]">
                    <i class="fas fa-file-excel"></i> Exportar Excel
                </button>
                <button class="btn btn-neu btn-sm text-[var(--red)]">
                    <i class="fas fa-file-pdf"></i> Exportar PDF
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[var(--bg-dark)] text-xs uppercase text-[var(--text-light)] font-bold tracking-wider">
                        <th class="px-6 py-4">Fecha</th>
                        <th class="px-6 py-4">Respuestas (Resumen)</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--neu-dark)]/20">
                    @forelse($stats['recent_responses'] as $response)
                        <tr class="hover:bg-[var(--bg-light)] transition">
                            <td class="px-6 py-4 text-[var(--text-dark)] font-medium">{{ $response['date'] }}</td>
                            <td class="px-6 py-4 text-[var(--text-muted)]">{{ Str::limit($response['summary'], 50) }}</td>
                            <td class="px-6 py-4 text-center">
                                <button class="btn btn-neu btn-sm text-[var(--verde)]">Ver detalle</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-[var(--text-muted)]">
                                <i class="far fa-folder-open text-4xl mb-3 block opacity-50"></i>
                                No hay respuestas registradas para esta encuesta.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(count($stats['recent_responses']) > 0)
        <div class="p-4 border-t border-[var(--neu-dark)]/20 text-center text-sm text-[var(--text-muted)]">
            Mostrando {{ count($stats['recent_responses']) }} respuestas recientes
        </div>
        @endif
    </div>
    @else
    <div class="nc text-center py-20">
        <div class="w-24 h-24 rounded-full bg-[var(--bg)] shadow-[var(--neu-in)] flex items-center justify-center mx-auto mb-6 text-[var(--text-light)] text-4xl">
            <i class="fas fa-chart-pie"></i>
        </div>
        <h2 class="text-xl font-bold text-[var(--text-dark)]">Selecciona una encuesta</h2>
        <p class="text-[var(--text-muted)] mt-2">Elige una encuesta del listado para ver sus estadísticas detalladas</p>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtenemos las variables CSS para usar en los charts
        const style = getComputedStyle(document.body);
        const colorVerde = style.getPropertyValue('--verde').trim();
        const colorOro = style.getPropertyValue('--oro').trim();
        const colorText = style.getPropertyValue('--text-muted').trim();
        const colorGrid = '#e0e5ec'; // Aproximación al color del borde neuomórfico

        const stats = @json($stats);

        Chart.defaults.font.family = "'Nunito', sans-serif";
        Chart.defaults.color = colorText;
        
        const ctxDistribution = document.getElementById('distributionChart');
        if (ctxDistribution && stats.responses_distribution) {
            new Chart(ctxDistribution, {
                type: 'bar',
                data: {
                    labels: stats.responses_distribution.labels,
                    datasets: [{
                        label: 'Respuestas',
                        data: stats.responses_distribution.data,
                        backgroundColor: colorVerde,
                        borderRadius: 8,
                        hoverBackgroundColor: '#3a6b1c'
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
                                borderDash: [4, 4],
                                color: colorGrid,
                                drawBorder: false
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
                        label: 'Respuestas',
                        data: stats.responses_per_day.data,
                        borderColor: colorOro,
                        backgroundColor: 'rgba(201, 154, 10, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: colorOro,
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
                                borderDash: [4, 4],
                                color: colorGrid,
                                drawBorder: false
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
