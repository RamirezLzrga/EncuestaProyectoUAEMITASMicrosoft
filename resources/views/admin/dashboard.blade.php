@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<section class="page active" id="dashboard">
  <div class="ph">
    <div class="ph-left">
      <div class="ph-label">Vista General</div>
      <div class="ph-title">Panel de Control</div>
      <div class="ph-sub">Bienvenido de vuelta, {{ Auth::user()->name }} — {{ now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</div>
    </div>
    <div class="ph-actions">
      <button class="btn btn-neu">↓ Exportar</button>
      <button class="btn btn-oro">⬡ Generar Reporte</button>
    </div>
  </div>

  <div class="dash-grid">

    <!-- KPIs -->
    <div class="kpi-row">
      <div class="kpi-card">
        <div class="kp-top">
          <div class="kp-icon"><span>📋</span></div>
          <span class="kp-change kp-up">Total</span>
        </div>
        <div class="kp-value">{{ $totalSurveys }}</div>
        <div class="kp-label">Encuestas</div>
        <div class="kp-desc">Creadas en el sistema</div>
        <div class="kpi-card-bg" style="background:var(--verde)"></div>
      </div>
      <div class="kpi-card">
        <div class="kp-top">
          <div class="kp-icon"><span>📬</span></div>
          <span class="kp-change kp-up">Avg {{ $avgResponses }}</span>
        </div>
        <div class="kp-value">{{ $totalResponses }}</div>
        <div class="kp-label">Respuestas</div>
        <div class="kp-desc">Totales recibidas</div>
        <div class="kpi-card-bg" style="background:var(--oro)"></div>
      </div>
      <div class="kpi-card">
        <div class="kp-top">
          <div class="kp-icon"><span>✅</span></div>
          <span class="kp-change kp-flat">—</span>
        </div>
        <div class="kp-value">{{ $completionRate }}%</div>
        <div class="kp-label">Completado</div>
        <div class="kp-desc">Tasa de finalización</div>
        <div class="kpi-card-bg" style="background:var(--text-muted)"></div>
      </div>
      <div class="kpi-card">
        <div class="kp-top">
          <div class="kp-icon"><span>👤</span></div>
          <span class="kp-change kp-up">Activos</span>
        </div>
        <div class="kp-value">{{ $activeUsers }}</div>
        <div class="kp-label">Usuarios</div>
        <div class="kp-desc">Con acceso activo</div>
        <div class="kpi-card-bg" style="background:var(--verde)"></div>
      </div>
    </div>

    <!-- Welcome -->
    <div class="welcome-band">
      <div class="wb-circles"></div>
      <div class="wb-circles2"></div>
      <div>
        <div class="wb-tag">UAEMex · SIEI {{ date('Y') }}</div>
        <div class="wb-title">¡Buenas tardes, {{ Auth::user()->name }}! 👋</div>
        <div class="wb-sub">Tienes {{ $pendingApprovals }} encuesta(s) pendiente(s) de aprobación y el sistema está funcionando al 100%.</div>
        <div style="margin-top:16px; display:flex; gap:10px;">
          <a href="{{ route('admin.aprobaciones') }}" class="btn btn-oro btn-sm">Ver aprobaciones →</a>
        </div>
      </div>
      <div class="wb-date">
        <div class="wb-date-day">{{ now()->format('d') }}</div>
        <div class="wb-date-rest">{{ strtoupper(now()->locale('es')->isoFormat('MMM')) }} / {{ now()->format('Y') }}<br>{{ now()->format('h:i A') }}</div>
      </div>
    </div>

    <!-- Quick actions -->
    <div class="quick-actions">
      <div class="qa-title">Acciones Rápidas</div>
      <div class="qa-grid">
        <a href="{{ route('surveys.create') }}" class="qa-item">
          <div class="qa-emoji">📝</div>
          <div class="qa-label">Nueva Encuesta</div>
        </a>
        <a href="{{ route('users.create') }}" class="qa-item">
          <div class="qa-emoji">👥</div>
          <div class="qa-label">Añadir Usuario</div>
        </a>
        <a href="{{ route('statistics.index') }}" class="qa-item">
          <div class="qa-emoji">📊</div>
          <div class="qa-label">Ver Estadísticas</div>
        </a>
        <a href="{{ route('activity-logs.index') }}" class="qa-item">
          <div class="qa-emoji">📜</div>
          <div class="qa-label">Bitácora</div>
        </a>
      </div>
    </div>

    <!-- Chart -->
    <div class="chart-card">
      <div class="cc-header">
        <div>
          <div class="cc-title">Top Encuestas</div>
          <div class="cc-sub">Encuestas con mayor número de respuestas</div>
        </div>
        <div class="tab-group">
          <div class="tg-tab active">Top 5</div>
        </div>
      </div>
      <div class="chart-body">
        @if(count($chartData) > 0)
            @php $max = max($chartData); @endphp
            @foreach($chartLabels as $index => $label)
                @php 
                    $value = $chartData[$index];
                    $height = $max > 0 ? ($value / $max) * 100 : 0;
                    $shortLabel = substr($label, 0, 3) . '..';
                @endphp
                <div class="cb-bar-wrap" title="{{ $label }}: {{ $value }}">
                    <div class="cb-bar {{ $index % 2 == 0 ? 'verde' : 'oro' }}" style="height:{{ $height }}%"></div>
                    <span class="cb-month">{{ $shortLabel }}</span>
                </div>
            @endforeach
        @else
            <div style="width:100%; text-align:center; color:var(--text-muted); padding-bottom:20px;">
                Sin datos suficientes
            </div>
        @endif
      </div>
    </div>

  </div>
</section>
@endsection
