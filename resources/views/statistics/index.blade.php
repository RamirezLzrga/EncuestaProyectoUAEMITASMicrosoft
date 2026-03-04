@extends('layouts.admin')

@section('title', 'Estadísticas')

@section('content')
<div class="ph">
    <div>
        <div class="ph-label">Análisis</div>
        <div class="ph-title">Estadísticas</div>
        <div class="ph-sub">Métricas y rendimiento de encuestas</div>
    </div>
</div>

<div class="filter-neu mb-8" style="margin-bottom: 32px;">
    <form action="{{ route('statistics.index') }}" method="GET" class="contents" style="display: contents;">
        <div class="fn-label">Encuesta:</div>
        <select name="survey_id" onchange="this.form.submit()" class="fn-input fg-sel" style="width: auto; min-width: 200px;">
            @foreach($surveys as $survey)
            <option value="{{ $survey->id }}" {{ $selectedSurvey && $selectedSurvey->id == $survey->id ? 'selected' : '' }}>
                {{ $survey->title }} ({{ \Carbon\Carbon::parse($survey->start_date)->year }})
            </option>
            @endforeach
            @if($surveys->isEmpty())
            <option value="">No hay encuestas disponibles</option>
            @endif
        </select>

        <div class="fn-label" style="margin-left: 16px;">Desde:</div>
        <input type="date" name="from_date" value="{{ request('from_date') }}" class="fn-input" style="width:auto; color:var(--text-muted);">

        <div class="fn-label">Hasta:</div>
        <input type="date" name="to_date" value="{{ request('to_date') }}" class="fn-input" style="width:auto; color:var(--text-muted);">

        <button type="submit" class="btn btn-sm btn-solid" style="margin-left:auto;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            Aplicar
        </button>
    </form>
</div>

@if($selectedSurvey)
<div class="stats-layout">
    <div class="stats-top">
        <!-- Total Responses Gauge -->
        <div class="gauge-card">
            <div class="gauge-circle">
                <div class="gauge-inner">
                    <div class="gauge-val">{{ $stats['total_responses'] }}</div>
                    <div class="gauge-unit">TOTAL</div>
                </div>
            </div>
            <div class="gauge-info">
                <div class="gauge-name">Respuestas Totales</div>
                <div class="gauge-sub">
                    <span style="color: {{ $stats['responses_growth'] >= 0 ? 'var(--verde)' : 'var(--red)' }}; font-weight:700;">
                        {{ $stats['responses_growth'] >= 0 ? '+' : '' }}{{ $stats['responses_growth'] }}%
                    </span>
                    vs periodo anterior
                </div>
            </div>
        </div>

        <!-- Completion Rate Gauge -->
        <div class="gauge-card">
            <div class="gauge-circle">
                <div class="gauge-inner">
                    <div class="gauge-val">{{ $stats['completion_rate'] }}</div>
                    <div class="gauge-unit">%</div>
                </div>
            </div>
            <div class="gauge-info">
                <div class="gauge-name">Tasa de Completado</div>
                <div class="gauge-sub">
                    <span style="color: {{ $stats['completion_growth'] >= 0 ? 'var(--verde)' : 'var(--red)' }}; font-weight:700;">
                        {{ $stats['completion_growth'] >= 0 ? '+' : '' }}{{ $stats['completion_growth'] }}%
                    </span>
                    vs periodo anterior
                </div>
            </div>
        </div>
    </div>

    <div class="stats-bottom">
        <div class="scatter-card" style="grid-column: 1 / -1;">
            <!-- Use full width for main chart -->
            <div class="sc-head" style="display:flex; justify-content:space-between; align-items:center;">
                <div class="sc-title" style="font-size:16px; font-weight:700; color:var(--text-dark);">Evolución de Respuestas</div>
            </div>
            <div class="sc-dots" style="height: 300px;">
                <canvas id="evolutionChart" style="width:100%; height:100%;"></canvas>
            </div>
        </div>

        <div class="scatter-card">
            <div class="sc-head" style="display:flex; justify-content:space-between; align-items:center;">
                <div class="sc-title" style="font-size:16px; font-weight:700; color:var(--text-dark);">Distribución</div>
            </div>
            <div class="sc-dots" style="height: 250px;">
                <canvas id="distributionChart" style="width:100%; height:100%;"></canvas>
            </div>
        </div>

        <div class="scatter-card">
            <div class="sc-head" style="display:flex; justify-content:space-between; align-items:center;">
                <div class="sc-title" style="font-size:16px; font-weight:700; color:var(--text-dark);">Respuestas Recientes</div>
                <div class="sc-actions" style="display:flex; gap:8px;">
                    <!-- Export buttons could go here -->
                </div>
            </div>
            <div class="table-neu-container" style="margin-top:16px;">
                <table style="width:100%; border-collapse:collapse; font-size:13px;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--neu-shadow-dark);">
                            <th style="text-align:left; padding:12px; color:var(--text-muted);">Fecha</th>
                            <th style="text-align:left; padding:12px; color:var(--text-muted);">Resumen</th>
                            <th style="text-align:right; padding:12px; color:var(--text-muted);">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stats['recent_responses'] as $response)
                        <tr style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                            <td style="padding:12px; color:var(--text);">{{ $response['date'] }}</td>
                            <td style="padding:12px; color:var(--text-muted);">{{ Str::limit($response['summary'], 40) }}</td>
                            <td style="padding:12px; text-align:right;">
                                <a href="#" style="color:var(--verde); font-weight:700; text-decoration:none;">VER</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="padding:20px; text-align:center; color:var(--text-muted);">No hay respuestas recientes.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@else
<div style="text-align:center; padding:60px; color:var(--text-muted);">
    <svg width="64" height="64" fill="none" stroke="var(--neu-shadow-dark)" stroke-width="2" viewBox="0 0 24 24" style="margin-bottom:16px;">
        <path d="M12 20V10" />
        <path d="M18 20V4" />
        <path d="M6 20v-6" />
    </svg>
    <div style="font-size:18px; font-weight:700; color:var(--text-light);">Selecciona una encuesta para ver sus estadísticas</div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stats = @json($stats ?? []);

        if (!stats || Object.keys(stats).length === 0) return;

        Chart.defaults.font.family = "'Nunito', sans-serif";
        Chart.defaults.color = '#6e7a70';

        // Evolution Chart
        const ctxEvolution = document.getElementById('evolutionChart');
        if (ctxEvolution && stats.responses_evolution) {
            new Chart(ctxEvolution, {
                type: 'line',
                data: {
                    labels: stats.responses_evolution.labels,
                    datasets: [{
                        label: 'Respuestas',
                        data: stats.responses_evolution.data,
                        borderColor: '#2d5016',
                        backgroundColor: 'rgba(45, 80, 22, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#2d5016',
                        pointBorderColor: '#fff',
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
                                color: 'rgba(0,0,0,0.05)'
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

        // Distribution Chart
        const ctxDistribution = document.getElementById('distributionChart');
        if (ctxDistribution && stats.responses_distribution) {
            new Chart(ctxDistribution, {
                type: 'bar',
                data: {
                    labels: stats.responses_distribution.labels,
                    datasets: [{
                        label: 'Respuestas',
                        data: stats.responses_distribution.data,
                        backgroundColor: '#7a8f6a',
                        borderRadius: 6,
                        hoverBackgroundColor: '#2d5016'
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
                                color: 'rgba(0,0,0,0.05)'
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
@endsection
