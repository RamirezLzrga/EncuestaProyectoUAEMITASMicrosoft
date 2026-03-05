@extends('layouts.editor')

@section('content')
<section class="page active" id="dashboard">
  <div class="ph">
    <div>
      <div class="ph-label">Editor · Mi Espacio</div>
      <div class="ph-title">Panel de Control del Editor</div>
      <div class="ph-sub">Vista general de tus encuestas · Actualizado el {{ now()->format('d/m/Y, H:i') }}</div>
    </div>
    <div class="ph-actions">
      <!-- <button class="btn btn-neu btn-sm">↓ Exportar</button> -->
      <a href="{{ route('editor.encuestas.nueva') }}" class="btn btn-oro">+ Crear encuesta</a>
    </div>
  </div>

  <div class="dash-grid">

    <!-- Welcome -->
    <div class="welcome-editor">
      <div class="we-circle1"></div><div class="we-circle2"></div>
      <div>
        <div class="we-tag">UAEMex · SIEI {{ date('Y') }} · Rol Editor</div>
        <div class="we-title">¡Bienvenido de vuelta, {{ Auth::user()->name }}! 👋</div>
        <div class="we-sub">Gestiona tus encuestas, revisa estadísticas y crea nuevos formularios desde aquí.</div>
        <div style="margin-top:16px;display:flex;gap:10px;">
          <a href="{{ route('surveys.index') }}" class="btn btn-oro btn-sm">Mis encuestas →</a>
          <a href="{{ route('editor.encuestas.plantillas') }}" class="btn btn-neu btn-sm">Ver plantillas</a>
        </div>
      </div>
      <div class="we-right">
        <div class="we-day">{{ now()->format('d') }}</div>
        <div class="we-date">{{ strtoupper(now()->format('M / Y')) }}<br>{{ now()->format('H:i A') }}</div>
      </div>
    </div>

    <!-- KPIs -->
    <div class="kpi-row">
      <div class="kpi-card">
        <div class="kp-top"><div class="kp-icon">📋</div><span class="kp-change kp-up">↑ +100%</span></div>
        <div class="kp-value">{{ $totalSurveys }}</div>
        <div class="kp-label">Total Encuestas</div>
        <div class="kp-desc">Creadas por ti</div>
        <div class="kpi-card-bg bg-[var(--verde)]"></div>
      </div>
      <div class="kpi-card">
        <div class="kp-top"><div class="kp-icon">📬</div><span class="kp-change kp-flat">— Promedio {{ $avgResponses ?? '0.0' }}</span></div>
        <div class="kp-value">{{ $totalResponses }}</div>
        <div class="kp-label">Respuestas Totales</div>
        <div class="kp-desc">En tus encuestas activas</div>
        <div class="kpi-card-bg bg-[var(--oro)]"></div>
      </div>
      <div class="kpi-card">
        <div class="kp-top"><div class="kp-icon">✅</div><span class="kp-change kp-flat">— Sin datos</span></div>
        <div class="kp-value">{{ $completionRate }}%</div>
        <div class="kp-label">Tasa de Completado</div>
        <div class="kp-desc">Completadas vs total</div>
        <div class="kpi-card-bg bg-[var(--text-muted)]"></div>
      </div>
    </div>

    <!-- Quick actions -->
    <div class="quick-actions">
      <div class="qa-title">Acciones Rápidas</div>
      <div class="qa-grid">
        <a href="{{ route('editor.encuestas.nueva') }}" class="qa-item" style="text-decoration:none">
          <div class="qa-emoji">✍️</div><div class="qa-label">Nueva Encuesta</div>
        </a>
        <a href="{{ route('editor.encuestas.plantillas') }}" class="qa-item" style="text-decoration:none">
          <div class="qa-emoji">📐</div><div class="qa-label">Plantillas</div>
        </a>
        <a href="{{ route('statistics.index') }}" class="qa-item" style="text-decoration:none">
          <div class="qa-emoji">📊</div><div class="qa-label">Estadísticas</div>
        </a>
        <a href="{{ route('surveys.index') }}" class="qa-item" style="text-decoration:none">
          <div class="qa-emoji">📁</div><div class="qa-label">Mis Encuestas</div>
        </a>
      </div>
    </div>

    <!-- Encuestas recientes -->
    <div class="recent-surveys">
      <div class="rs-header">
        <div class="rs-title">Mis encuestas recientes</div>
        <a href="{{ route('surveys.index') }}" class="rs-link">Ver todas →</a>
      </div>
      
      @forelse($recentSurveys as $survey)
          <a href="{{ route('editor.encuestas.editar', $survey) }}" class="rc-item">
            <div class="rc-top">
                <div class="rc-name">{{ $survey->title }}</div>
                <div class="rc-num">{{ $survey->responses_count ?? 0 }} respuestas</div>
            </div>
            <div class="rc-bar-wrap">
                <div class="rc-mini-bar">
                    <div class="rc-mini-fill" style="width: {{ rand(20, 90) }}%"></div>
                </div>
            </div>
          </a>
      @empty
          <div class="rs-empty">
            <div class="rs-empty-icon">📋</div>
            <div style="font-weight:700;color:var(--text);font-size:14px;margin-bottom:6px">Aún no tienes encuestas</div>
            <div style="font-size:12.5px;color:var(--text-muted)">Crea tu primera encuesta desde plantillas o desde cero</div>
            <a href="{{ route('editor.encuestas.plantillas') }}" class="btn btn-solid btn-sm" style="margin-top:18px; text-decoration:none;">Explorar plantillas</a>
          </div>
      @endforelse
    </div>

    <!-- Performance chart -->
    <div class="perf-card">
      <div class="cc-header">
        <div><div class="cc-title">Rendimiento de mis encuestas</div><div class="cc-sub">Respuestas recibidas por día</div></div>
        <div class="tab-group">
          <div class="tg-tab">7D</div><div class="tg-tab active">30D</div><div class="tg-tab">90D</div>
        </div>
      </div>
      <div class="chart-bars">
        <div class="cb-wrap"><div class="cb-bar verde" style="height:5%"></div><span class="cb-month">03/02</span></div>
        <div class="cb-wrap"><div class="cb-bar oro"   style="height:15%"></div><span class="cb-month">06/02</span></div>
        <div class="cb-wrap"><div class="cb-bar verde" style="height:25%"></div><span class="cb-month">09/02</span></div>
        <div class="cb-wrap"><div class="cb-bar oro"   style="height:10%"></div><span class="cb-month">12/02</span></div>
        <div class="cb-wrap"><div class="cb-bar verde" style="height:45%"></div><span class="cb-month">15/02</span></div>
        <div class="cb-wrap"><div class="cb-bar oro"   style="height:30%"></div><span class="cb-month">18/02</span></div>
        <div class="cb-wrap"><div class="cb-bar verde" style="height:60%"></div><span class="cb-month">21/02</span></div>
        <div class="cb-wrap"><div class="cb-bar oro"   style="height:20%"></div><span class="cb-month">24/02</span></div>
        <div class="cb-wrap"><div class="cb-bar verde" style="height:40%"></div><span class="cb-month">27/02</span></div>
        <div class="cb-wrap"><div class="cb-bar oro"   style="height:80%"></div><span class="cb-month">03/03</span></div>
      </div>
    </div>

  </div>
</section>
@endsection