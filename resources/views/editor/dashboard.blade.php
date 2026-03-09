@extends('layouts.editor')

@section('title', 'Mi Espacio')

@section('content')

{{-- Page Header --}}
<div class="ph">
    <div>
        <div class="ph-label">Editor · Mi Espacio</div>
        <h1 class="ph-title">Panel de Control del Editor</h1>
        <p class="ph-sub">Vista general de tus encuestas · Actualizado el <span id="editor-dashboard-updated-at">--/--/----</span></p>
    </div>
    <div class="ph-actions">
        <button class="btn btn-neu">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Exportar
        </button>
        <a href="{{ route('editor.encuestas.nueva') }}" class="btn btn-oro">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Crear encuesta
        </a>
    </div>
</div>

<div class="dash-grid">
    {{-- Welcome Banner --}}
    <div class="welcome-editor">
        <div class="we-circle1"></div>
        <div class="we-circle2"></div>
        <div style="position: relative; z-index: 2;">
            <div class="we-tag">UAEMex · SIEI 2026 · Rol Editor</div>
            <h2 class="we-title">¡Bienvenido de vuelta, {{ Auth::user()->name }}! 👋</h2>
            <p class="we-sub">Gestiona tus encuestas, revisa estadísticas y crea nuevos formularios desde aquí.</p>
            <div style="display: flex; gap: 12px; margin-top: 24px;">
                <a href="{{ route('surveys.index') }}" class="btn btn-oro btn-sm">Mis encuestas →</a>
            </div>
        </div>
        <div class="we-right">
            <div class="we-day" id="banner-day">--</div>
            <div class="we-date">
                <div id="banner-month-year" style="margin-bottom: 2px;">-- / ----</div>
                <div id="realtime-clock" style="font-variant-numeric: tabular-nums;">--:--:-- --</div>
            </div>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="kpi-row">
        {{-- Total Encuestas --}}
        <div class="kpi-card">
            <div class="kpi-card-bg" style="background: var(--verde); opacity: 0.05;"></div>
            <div class="kp-top">
                <div class="kp-icon" style="color: var(--verde);">📋</div>
                <div class="kp-change kp-up">↑ +100%</div>
            </div>
            <div>
                <div class="kp-value">{{ $totalSurveys }}</div>
                <div class="kp-label">Total Encuestas</div>
                <div class="kp-desc">Creadas por ti</div>
            </div>
        </div>

        {{-- Respuestas Totales --}}
        <div class="kpi-card">
            <div class="kpi-card-bg" style="background: var(--oro); opacity: 0.05;"></div>
            <div class="kp-top">
                <div class="kp-icon" style="color: var(--oro-bright);">📬</div>
                <div class="kp-change kp-flat">– Promedio {{ $avgResponses ?? '0' }}</div>
            </div>
            <div>
                <div class="kp-value">{{ $totalResponses }}</div>
                <div class="kp-label">Respuestas Totales</div>
                <div class="kp-desc">En tus encuestas activas</div>
            </div>
        </div>

        {{-- Tasa de Completado --}}
        <div class="kpi-card">
            <div class="kpi-card-bg" style="background: var(--blue); opacity: 0.05;"></div>
            <div class="kp-top">
                <div class="kp-icon" style="color: var(--blue);">☑</div>
                <div class="kp-change kp-flat">– Sin datos</div>
            </div>
            <div>
                <div class="kp-value">{{ $completionRate }}%</div>
                <div class="kp-label">Tasa de Completado</div>
                <div class="kp-desc">Completadas vs total</div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="quick-actions">
        <h3 class="qa-title">Acciones Rápidas</h3>
        <div class="qa-grid">
            <a href="{{ route('editor.encuestas.nueva') }}" class="qa-item">
                <div class="qa-emoji">✍️</div>
                <div class="qa-label">Nueva Encuesta</div>
            </a>
            <a href="#" class="qa-item">
                <div class="qa-emoji">📊</div>
                <div class="qa-label">Estadísticas</div>
            </a>
            <a href="{{ route('surveys.index') }}" class="qa-item">
                <div class="qa-emoji">📁</div>
                <div class="qa-label">Mis Encuestas</div>
            </a>
        </div>
    </div>

    {{-- Recent Surveys --}}
    <div class="recent-surveys">
        <div class="rs-header">
            <h3 class="rs-title">Mis encuestas recientes</h3>
            <a href="{{ route('surveys.index') }}" class="rs-link">Ver todas →</a>
        </div>

        @if($recentSurveys->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 10px;">
                @foreach($recentSurveys->take(3) as $survey)
                    @php
                        $respCount = $survey->responses()->count();
                        $isActive = $survey->is_active;
                        // Calculate percentage for progress bar (mock logic or real if available)
                        // Assuming target is 100 for demo, or 100% if no target
                        $percent = 0; // Default
                        if($respCount > 0) $percent = min(100, ($respCount * 10)); // Just visual mock
                    @endphp
                    <a href="{{ route('editor.encuestas.editar', $survey) }}" class="rc-item" style="text-decoration: none; display: block;">
                        <div class="rc-top">
                            <div class="rc-name">{{ $survey->title ?: 'Sin título' }}</div>
                            <div style="font-size: 11px; font-weight: 700; color: {{ $isActive ? 'var(--green)' : 'var(--text-muted)' }}">
                                {{ $isActive ? 'ACTIVA' : 'BORRADOR' }}
                            </div>
                        </div>
                        <div class="rc-bar-wrap">
                            <div class="rc-mini-bar">
                                <div class="rc-mini-fill" style="width: {{ $percent }}%"></div>
                            </div>
                            <div class="rc-num">{{ $respCount }} resp</div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="rs-empty">
                <div class="rs-empty-icon">📋</div>
                <div style="font-weight: 700; color: var(--text-dark); margin-bottom: 6px;">Aún no tienes encuestas</div>
                <p>Comienza creando una nueva encuesta para tus usuarios</p>
                <a href="{{ route('editor.encuestas.nueva') }}" class="btn btn-solid btn-sm" style="margin-top: 16px;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-right:6px"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Crear nueva encuesta
                </a>
            </div>
        @endif
    </div>

    {{-- Performance Chart --}}
    <div class="perf-card">
        <div class="cc-header">
            <div>
                <h3 class="cc-title">Rendimiento de mis encuestas</h3>
                <div class="cc-sub">Respuestas recibidas por día</div>
            </div>
            <div class="tab-group">
                <div class="tg-tab">7D</div>
                <div class="tg-tab active">30D</div>
                <div class="tg-tab">90D</div>
            </div>
        </div>
        <div class="chart-area" style="position: relative; height: 250px; width: 100%;">
            <canvas id="performanceChart"></canvas>
        </div>
    </div>

    {{-- Activity --}}
    <div class="activity-card">
        <h3 class="qa-title">Actividad Reciente</h3>
        <div class="act-list">
            <div class="act-item">
                <div class="act-icon" style="background: var(--green-pale); color: var(--green);">📊</div>
                <div>
                    <div class="act-text">{{ $totalResponses }} respuestas registradas</div>
                    <div class="act-meta">En tus encuestas activas</div>
                </div>
            </div>
            <div class="act-item">
                <div class="act-icon" style="background: var(--verde-xpale); color: var(--verde);">✅</div>
                <div>
                    <div class="act-text">{{ $activeSurveys }} encuestas activas</div>
                    <div class="act-meta">Disponibles ahora</div>
                </div>
            </div>
            <div class="act-item">
                <div class="act-icon" style="background: var(--bg-dark); color: var(--text-muted);">📝</div>
                <div>
                    <div class="act-text">{{ $inactiveSurveys }} borradores</div>
                    <div class="act-meta">Reciente</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Participation by Survey --}}
    <div class="progress-card">
        <h3 class="qa-title">Participación por Encuesta</h3>
        <div class="cc-sub">Respuestas vs. límite configurado</div>

        <div class="pw-items">
            @forelse($recentSurveys->take(3) as $survey)
                @php
                    $count = $survey->responses()->count();
                    // Mock limit or calculate meaningful percentage
                    $limit = 100; // Mock limit
                    $pct = min(100, ($count / $limit) * 100);
                @endphp
                <div class="pw-item">
                    <div class="pw-item-top">
                        <div class="pw-name">{{ $survey->title }}</div>
                        <div class="pw-pct">{{ $count }} resp</div>
                    </div>
                    <div class="pw-track">
                        <div class="pw-fill verde" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 20px; color: var(--text-muted); font-size: 13px;">
                    Crea encuestas para ver datos aquí
                </div>
            @endforelse
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Clock
        const timeEl = document.getElementById('editor-dashboard-updated-at');
        if(timeEl) {
            const now = new Date();
            timeEl.textContent = now.toLocaleDateString() + ', ' + now.toLocaleTimeString();
        }

        // Real-time Clock
        const clockEl = document.getElementById('realtime-clock');
        const dayEl = document.getElementById('banner-day');
        const monthYearEl = document.getElementById('banner-month-year');
        const headerDateEl = document.getElementById('editor-dashboard-updated-at');
        
        if (clockEl && dayEl && monthYearEl) {
            function updateClock() {
                const now = new Date();
                
                // Time
                let hours = now.getHours();
                const ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; 
                const minutes = now.getMinutes().toString().padStart(2, '0');
                const seconds = now.getSeconds().toString().padStart(2, '0');
                clockEl.textContent = `${hours.toString().padStart(2, '0')}:${minutes}:${seconds} ${ampm}`;

                // Date
                const day = now.getDate().toString().padStart(2, '0');
                dayEl.textContent = day;
                
                const monthName = now.toLocaleString('es-ES', { month: 'short' }).replace('.', '');
                const month = monthName.charAt(0).toUpperCase() + monthName.slice(1);
                const year = now.getFullYear();
                monthYearEl.textContent = `${month.toUpperCase()} / ${year}`;

                if (headerDateEl) {
                    headerDateEl.textContent = `${day} ${month} ${year}`;
                }
            }
            setInterval(updateClock, 1000);
            updateClock();
        }

        // Chart
        const ctx = document.getElementById('performanceChart');
        // Ensure chartData is correctly parsed
        const chartData = @json($performanceChart);

        if (ctx && chartData && chartData.labels) {
            Chart.defaults.font.family = "'Nunito', system-ui, sans-serif";
            Chart.defaults.color = '#7a8f6a';

            // Check if all data is zero to adjust scale
            const allZeros = chartData.data.every(val => val === 0);
            const suggestedMax = allZeros ? 5 : undefined;

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Respuestas',
                        data: chartData.data,
                        borderColor: '#2D5016', 
                        backgroundColor: (context) => {
                            const ctx = context.chart.ctx;
                            if (!ctx) return 'rgba(45,80,22,0.1)';
                            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                            gradient.addColorStop(0, 'rgba(45,80,22,0.2)');
                            gradient.addColorStop(1, 'rgba(45,80,22,0.0)');
                            return gradient;
                        },
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#2D5016',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e2d14',
                            titleColor: '#fff',
                            bodyColor: '#e8ede2',
                            borderColor: '#3a6b1c',
                            borderWidth: 1,
                            padding: 10,
                            displayColors: false,
                            callbacks: {
                                title: (items) => 'Día ' + items[0].label,
                                label: (context) => {
                                    const index = context.dataIndex;
                                    const surveys = chartData.surveys ? chartData.surveys[index] : [];
                                    const total = context.raw;
                                    
                                    if (total === 0) return 'Sin actividad';
                                    
                                    let lines = [`Total: ${total}`];
                                    if (surveys && surveys.length) {
                                        surveys.forEach(s => {
                                            lines.push(`• ${s.title}: ${s.count}`);
                                        });
                                    }
                                    return lines;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMax: suggestedMax,
                            ticks: { 
                                precision: 0,
                                font: { size: 11 }
                            },
                            grid: { 
                                borderDash: [4, 4], 
                                color: '#e0e0e0',
                                drawBorder: false 
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { size: 10 },
                                maxRotation: 0,
                                autoSkip: true,
                                maxTicksLimit: 8
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                }
            });
        }
    });
</script>
@endpush
