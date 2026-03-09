@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="ph">
        <div class="ph-left">
            <div class="ph-label">Vista General</div>
            <div class="ph-title">Panel de Control</div>
            <div class="ph-sub">
                Bienvenido de vuelta, {{ strtok(Auth::user()->name ?? 'Usuario',' ') }} —
                <span id="dashboard-updated-at">{{ now()->format('d M Y') }}</span>
            </div>
        </div>
        <div class="ph-actions">
            <a href="{{ route('activity-logs.export') }}" class="btn btn-neu">↓ Exportar</a>
            <a href="{{ route('admin.reportes') }}" class="btn btn-oro">⬡ Generar Reporte</a>
        </div>
    </div>

    <div class="dash-grid">
        <div class="kpi-row">
            <div class="kpi-card">
                <div class="kp-top">
                    <div class="kp-icon"><span>📋</span></div>
                    <span class="kp-change kp-up">↑ +{{ $totalSurveys }}</span>
                </div>
                <div class="kp-value">{{ $totalSurveys }}</div>
                <div class="kp-label">Encuestas</div>
                <div class="kp-desc">Totales en sistema</div>
                <div class="kpi-card-bg" style="background:var(--verde)"></div>
            </div>
            <div class="kpi-card">
                <div class="kp-top">
                    <div class="kp-icon"><span>📬</span></div>
                    <span class="kp-change {{ $avgResponses > 0 ? 'kp-up' : 'kp-flat' }}">
                        {{ $avgResponses > 0 ? '↑' : '—' }} {{ $avgResponses }}/enc
                    </span>
                </div>
                <div class="kp-value">{{ $totalResponses }}</div>
                <div class="kp-label">Respuestas</div>
                <div class="kp-desc">Totales recibidas</div>
                <div class="kpi-card-bg" style="background:var(--oro)"></div>
            </div>
            <div class="kpi-card">
                <div class="kp-top">
                    <div class="kp-icon"><span>✅</span></div>
                    <span class="kp-change {{ $completionRate > 50 ? 'kp-up' : 'kp-flat' }}">
                        {{ $completionRate > 0 ? ($completionRate > 50 ? '↑' : '↓') : '—' }} {{ $completionRate }}%
                    </span>
                </div>
                <div class="kp-value">{{ $completionRate }}%</div>
                <div class="kp-label">Completado</div>
                <div class="kp-desc">Tasa de finalización</div>
                <div class="kpi-card-bg" style="background:var(--text-muted)"></div>
            </div>
            <div class="kpi-card">
                <div class="kp-top">
                    <div class="kp-icon"><span>👤</span></div>
                    <span class="kp-change kp-up">↑ Activos</span>
                </div>
                <div class="kp-value">{{ $activeUsers }}</div>
                <div class="kp-label">Usuarios</div>
                <div class="kp-desc">Con acceso activo</div>
                <div class="kpi-card-bg" style="background:var(--verde)"></div>
            </div>
        </div>

        <div class="welcome-band">
            <div class="wb-circles"></div>
            <div class="wb-circles2"></div>
            <div>
                <div class="wb-tag">UAEMex · SIEI</div>
                <div class="wb-title">¡Bienvenido, {{ strtok(Auth::user()->name ?? 'Usuario',' ') }}! 👋</div>
                <div class="wb-sub">
                    @if($pendingApprovals > 0)
                        Tienes {{ $pendingApprovals }} encuesta{{ $pendingApprovals===1?'':'s' }} pendiente{{ $pendingApprovals===1?'':'s' }} de aprobación.
                    @else
                        No hay encuestas pendientes de aprobación.
                    @endif
                </div>
                <div style="margin-top:16px;display:flex;gap:10px">
                    <a href="{{ route('admin.aprobaciones') }}" class="btn btn-oro btn-sm">Ver aprobaciones →</a>
                </div>
            </div>
            <div class="wb-date">
                <div class="wb-date-day" id="admin-clock-day">{{ now()->format('d') }}</div>
                <div class="wb-date-rest">
                    <span id="admin-clock-month-year">{{ strtoupper(now()->format('M')) }} / {{ now()->format('Y') }}</span><br>
                    <span id="admin-clock-time">{{ now()->format('h:i A') }}</span>
                </div>
            </div>
        </div>

        <div class="quick-actions">
            <div class="qa-title">Acciones Rápidas</div>
            <div class="qa-grid">
                <a class="qa-item" href="{{ route('surveys.create') }}"><div class="qa-emoji">📝</div><div class="qa-label">Nueva Encuesta</div></a>
                <a class="qa-item" href="{{ route('users.create') }}"><div class="qa-emoji">👥</div><div class="qa-label">Añadir Usuario</div></a>
                <a class="qa-item" href="{{ route('statistics.index') }}"><div class="qa-emoji">📊</div><div class="qa-label">Ver Estadísticas</div></a>
                <a class="qa-item" href="{{ route('activity-logs.index') }}"><div class="qa-emoji">📜</div><div class="qa-label">Bitácora</div></a>
            </div>
        </div>

        <div class="chart-card">
            <div class="cc-header">
                <div>
                    <div class="cc-title">Respuestas por Mes</div>
                    <div class="cc-sub">Actividad acumulada del año actual</div>
                </div>
            </div>
            <div class="chart-body">
                @php
                    $maxMonthly = collect($monthlyActivity)->max('count') ?: 1;
                @endphp
                @foreach($monthlyActivity as $ma)
                    <div class="cb-bar-wrap">
                        <div class="cb-bar {{ $loop->iteration % 2 == 0 ? 'oro' : 'verde' }}" 
                             style="height: {{ ($ma['count'] / $maxMonthly) * 100 }}%"
                             title="{{ $ma['count'] }} respuestas"></div>
                        <span class="cb-month">{{ $ma['month'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="donut-card">
            <div class="cc-title">Estado de Encuestas</div>
            <div class="cc-sub" style="font-size:12px;color:var(--text-muted);margin-top:2px">Distribución actual</div>
            <div class="donut-wrap">
                <div class="donut-svg-wrap">
                    @php
                        $activePct = $totalSurveys > 0 ? ($activeSurveys / $totalSurveys) * 100 : 0;
                        $inactivePct = $totalSurveys > 0 ? ($inactiveSurveys / $totalSurveys) * 100 : 0;
                    @endphp
                    <svg class="donut-svg" viewBox="0 0 42 42">
                        <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="#dde3d6" stroke-width="5"/>
                        <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="var(--verde)" stroke-width="5" 
                                stroke-dasharray="{{ $activePct }} {{ 100 - $activePct }}" stroke-dashoffset="25"/>
                    </svg>
                    <div class="donut-center">
                        <div class="donut-pct">{{ $totalSurveys }}</div>
                        <div class="donut-pct-label">Total</div>
                    </div>
                </div>
                <div class="donut-legend">
                    <div class="dl-row"><div class="dl-dot" style="background:var(--verde)"></div>Activas<div class="dl-val">{{ $activeSurveys }}</div></div>
                    <div class="dl-row"><div class="dl-dot" style="background:var(--bg-dark)"></div>Inactivas<div class="dl-val">{{ $inactiveSurveys }}</div></div>
                </div>
            </div>
        </div>

        <div class="progress-card">
            <div class="cc-title">Top Encuestas</div>
            <div class="cc-sub" style="font-size:12px;color:var(--text-muted);margin-top:2px">Más respuestas recibidas</div>
            <div class="pw-items">
                @php
                    $maxResponses = $surveysWithResponses->max('responses_count') ?: 1;
                @endphp
                @forelse($surveysWithResponses as $survey)
                    <div class="pw-item">
                        <div class="pw-item-top">
                            <span class="pw-name" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:180px;">{{ $survey['title'] }}</span>
                            <span class="pw-pct">{{ $survey['responses_count'] }}</span>
                        </div>
                        <div class="pw-track">
                            <div class="pw-fill {{ $loop->iteration % 2 == 0 ? 'oro' : 'verde' }}" 
                                 style="width:{{ ($survey['responses_count'] / $maxResponses) * 100 }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="pw-item"><span class="pw-name" style="color:var(--text-muted)">Sin datos disponibles</span></div>
                @endforelse
            </div>
        </div>

        <div class="heatmap-card">
            <div class="cc-title">Actividad (30 Días)</div>
            <div class="cc-sub" style="font-size:12px;color:var(--text-muted);margin-top:2px">Respuestas por día</div>
            <div class="hm-grid">
                <div class="hm-day-label">L</div><div class="hm-day-label">M</div><div class="hm-day-label">X</div><div class="hm-day-label">J</div><div class="hm-day-label">V</div><div class="hm-day-label">S</div><div class="hm-day-label">D</div>
                @foreach($activityByDay as $day)
                    @php
                        $level = 0;
                        if ($day['responses'] > 0) $level = 1;
                        if ($day['responses'] > 5) $level = 2;
                        if ($day['responses'] > 10) $level = 3;
                        if ($day['responses'] > 20) $level = 4;
                    @endphp
                    <div class="hm-cell hm-{{ $level }}" title="{{ $day['label'] }}: {{ $day['responses'] }} respuestas"></div>
                @endforeach
            </div>
        </div>

        <div class="table-card">
            <div class="cc-title">Encuestas Recientes</div>
            <div class="rc-list">
                @forelse($recentSurveys as $survey)
                    <div class="rc-item" onclick="window.location='{{ route('surveys.show', $survey->id) }}'">
                        <div class="rc-top">
                            <span class="rc-name" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px;">{{ $survey->title }}</span>
                            @if($survey->is_active)
                                <span class="badge-neu bn-green">● Activa</span>
                            @else
                                <span class="badge-neu bn-muted">○ Inactiva</span>
                            @endif
                        </div>
                        <div class="rc-bar-wrap">
                            <div class="rc-mini-bar">
                                @php
                                    $respCount = $survey->responses()->count();
                                    $width = $respCount > 0 ? min($respCount, 100) : 0; 
                                @endphp
                                <div class="rc-mini-fill" style="width:{{ $width }}%"></div>
                            </div>
                            <span class="rc-num">{{ $respCount }} resp.</span>
                        </div>
                    </div>
                @empty
                    <div class="rc-item"><span class="rc-name" style="color:var(--text-muted)">Sin encuestas recientes</span></div>
                @endforelse
            </div>
        </div>

        <div class="timeline-card">
            <div class="cc-title">Actividad Reciente</div>
            <div class="tl-list">
                <div class="tl-line"></div>
                @forelse($recentActivity as $activity)
                    <div class="tl-item">
                        <div class="tl-dot">{{ $activity['icon'] }}</div>
                        <div class="tl-content">
                            <div class="tl-action">{{ $activity['title'] }}</div>
                            <div class="tl-meta">{{ $activity['description'] }} · {{ $activity['time'] }}</div>
                        </div>
                    </div>
                @empty
                    <div class="tl-item">
                        <div class="tl-dot">📋</div>
                        <div class="tl-content">
                            <div class="tl-action">Sin actividad reciente</div>
                            <div class="tl-meta">—</div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Admin Dashboard Real-time Clock
        const dayEl = document.getElementById('admin-clock-day');
        const monthYearEl = document.getElementById('admin-clock-month-year');
        const timeEl = document.getElementById('admin-clock-time');
        const headerDateEl = document.getElementById('dashboard-updated-at');
        
        if (dayEl && monthYearEl && timeEl) {
            function updateAdminClock() {
                const now = new Date();
                
                // Date
                const day = now.getDate().toString().padStart(2, '0');
                dayEl.textContent = day;
                
                const monthName = now.toLocaleString('es-ES', { month: 'short' }).replace('.', '');
                const month = monthName.charAt(0).toUpperCase() + monthName.slice(1);
                const year = now.getFullYear();
                monthYearEl.textContent = `${month.toUpperCase()} / ${year}`;
                
                // Update header date if exists
                if (headerDateEl) {
                    headerDateEl.textContent = `${day} ${month} ${year}`;
                }
                
                // Time
                let hours = now.getHours();
                const ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; 
                const minutes = now.getMinutes().toString().padStart(2, '0');
                const seconds = now.getSeconds().toString().padStart(2, '0');
                // No seconds as requested
                timeEl.textContent = `${hours.toString().padStart(2, '0')}:${minutes}:${seconds} ${ampm}`;
            }
            setInterval(updateAdminClock, 1000);
            updateAdminClock();
        }
    });
</script>
@endpush
