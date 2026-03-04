@extends('layouts.editor')

@section('title', 'Mi Espacio')

@section('content')
<div class="page-header">
    <div class="page-title-row">
        <div>
            <h1 class="page-title">Panel de Control del Editor</h1>
            <p class="page-subtitle">
                Vista general de tus encuestas • Actualizado el
                <span id="editor-dashboard-updated-at"></span>
            </p>
        </div>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-label">Total de encuestas</div>
            <div class="stat-icon green">📋</div>
        </div>
        <div class="stat-value">{{ $totalSurveys }}</div>
        <div class="stat-change positive">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
            <span>+100% vs periodo anterior</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-label">Respuestas totales</div>
            <div class="stat-icon gold">📊</div>
        </div>
        <div class="stat-value">{{ $totalResponses }}</div>
        <div class="stat-change positive">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
            <span>Promedio {{ $avgResponses ?? '0.0' }} por encuesta</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-label">Tasa de completado</div>
            <div class="stat-icon blue">✓</div>
        </div>
        <div class="stat-value">{{ $completionRate }}%</div>
        <div class="stat-change positive">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
            <span>Completadas vs total de respuestas</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-label">Encuestas activas</div>
            <div class="stat-icon green">👥</div>
        </div>
        <div class="stat-value">{{ $activeSurveys }}</div>
        <div class="stat-change positive">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
            <span>Encuestas con estado activo</span>
        </div>
    </div>
</div>

<div class="content-grid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Mis encuestas recientes</h3>
            <a href="{{ route('surveys.index') }}" class="view-all-link">
                Ver todas
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <div class="survey-list">
            @forelse($recentSurveys as $survey)
                @php
                    $responsesCount = $survey->responses()->count();
                    $statusClass = $survey->is_active ? 'active' : 'draft';
                    $statusText = $survey->is_active ? 'Activa' : 'Borrador';
                @endphp
                <a href="{{ route('editor.encuestas.editar', $survey) }}" class="survey-item">
                    <div class="survey-header">
                        <div>
                            <div class="survey-title">{{ $survey->title ?: 'Encuesta sin título' }}</div>
                            <div class="survey-meta">
                                <span>
                                    📅 Creada:
                                    {{ optional($survey->created_at)->format('d M Y') }}
                                </span>
                                <span>
                                    🔗
                                    {{ $survey->is_public ? 'Pública' : 'Privada' }}
                                </span>
                            </div>
                        </div>
                        <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                    </div>
                    <div class="survey-stats-row">
                        <div class="survey-stat">
                            <div class="survey-stat-value">{{ $responsesCount }}</div>
                            <div class="survey-stat-label">Respuestas</div>
                        </div>
                        <div class="survey-stat">
                            <div class="survey-stat-value">
                                @if($responsesCount > 0)
                                    100%
                                @else
                                    --
                                @endif
                            </div>
                            <div class="survey-stat-label">Completado</div>
                        </div>
                    </div>
                </a>
            @empty
                <p class="text-sm text-gray-500">Aún no tienes encuestas recientes registradas.</p>
            @endforelse
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Actividad reciente</h3>
        </div>

        <div class="activity-item">
            <div class="activity-icon-box green">📊</div>
            <div class="activity-info">
                <div class="activity-title">{{ $totalResponses }} respuestas registradas</div>
                <div class="activity-description">En tus encuestas activas</div>
            </div>
            <div class="activity-time">Últimos días</div>
        </div>

        <div class="activity-item">
            <div class="activity-icon-box gold">✅</div>
            <div class="activity-info">
                <div class="activity-title">{{ $activeSurveys }} encuestas activas</div>
                <div class="activity-description">Disponibles para recibir respuestas</div>
            </div>
            <div class="activity-time">Ahora</div>
        </div>

        <div class="activity-item">
            <div class="activity-icon-box blue">📝</div>
            <div class="activity-info">
                <div class="activity-title">{{ $inactiveSurveys }} encuestas en borrador o cerradas</div>
                <div class="activity-description">Listas para ajustar o reactivar</div>
            </div>
            <div class="activity-time">Reciente</div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var el = document.getElementById('editor-dashboard-updated-at');
        if (!el) return;

        function pad(n) { return n.toString().padStart(2, '0'); }

        function updateTime() {
            var now = new Date();
            var day   = pad(now.getDate());
            var month = pad(now.getMonth() + 1);
            var year  = now.getFullYear();
            var hours = pad(now.getHours());
            var mins  = pad(now.getMinutes());
            var secs  = pad(now.getSeconds());
            el.textContent = day + '/' + month + '/' + year + ', ' + hours + ':' + mins + ':' + secs;
        }

        updateTime();
        setInterval(updateTime, 1000);
    });
</script>
@endpush

<div class="card" style="margin-bottom: 2rem;">
    <div class="card-header">
        <h3 class="card-title">Rendimiento de mis encuestas</h3>
        <div style="display: flex; gap: 0.5rem;">
            <button class="btn btn-primary">30D</button>
        </div>
    </div>
    <div class="chart-area">
        <canvas id="performanceChart"></canvas>
        @if(!$hasPerformanceData)
            <div class="chart-placeholder">
                <div class="chart-placeholder-icon">📈</div>
                <div style="font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem;">Aún no hay datos suficientes</div>
                <div style="font-size: 0.875rem;">Cuando tus encuestas reciban respuestas recientes verás la evolución aquí.</div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('performanceChart');
        const chartData = @json($performanceChart);

        if (!ctx || !chartData || !chartData.labels || chartData.labels.length === 0) {
            return;
        }

        Chart.defaults.font.family = "'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif";
        Chart.defaults.color = '#6b7280';

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Respuestas por día',
                    data: chartData.data,
                    borderColor: '#1a5c2a',
                    backgroundColor: 'rgba(26, 92, 42, 0.08)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#1a5c2a',
                    pointBorderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#111827',
                        titleColor: '#f9fafb',
                        bodyColor: '#e5e7eb',
                        borderColor: '#374151',
                        borderWidth: 1,
                        padding: 10,
                        displayColors: false,
                        callbacks: {
                            title: function(items) {
                                if (!items.length) {
                                    return '';
                                }
                                return 'Día ' + items[0].label;
                            },
                            label: function(context) {
                                var index = context.dataIndex;
                                var allSurveys = chartData.surveys || [];
                                var perDay = allSurveys[index] || [];

                                if (!perDay.length) {
                                    return 'Sin respuestas registradas';
                                }

                                var lines = [];
                                perDay.forEach(function(item) {
                                    var title = item.title || 'Encuesta sin título';
                                    lines.push(item.count + ' · ' + title);
                                });

                                return lines;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            borderDash: [4, 4],
                            color: '#e5e7eb'
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
    });
</script>
@endpush
