@extends('layouts.admin')

@section('title', 'Reportes Globales')

@section('content')
<div class="ph">
    <div class="ph-left">
        <div class="ph-label">ANÁLISIS</div>
        <h1 class="ph-title">Reportes Globales</h1>
        <div class="ph-sub">Genera y programa reportes del sistema</div>
    </div>
</div>

<div class="dash-grid">
    <!-- LEFT COLUMN -->
    <div style="grid-column: span 8;">
        <div class="nc">
            <div class="cc-header">
                <div class="cc-title">Configuración del Reporte</div>
            </div>

            <form method="GET" action="{{ route('admin.reportes') }}" class="fg">
                <div class="fg-row">
                    <div class="fg">
                        <label>Período</label>
                        <select name="period" class="fg-sel">
                            <option value="hoy" {{ $period === 'hoy' ? 'selected' : '' }}>Hoy</option>
                            <option value="semana" {{ $period === 'semana' ? 'selected' : '' }}>Esta semana</option>
                            <option value="mes" {{ $period === 'mes' ? 'selected' : '' }}>Este mes</option>
                            <option value="año" {{ $period === 'año' ? 'selected' : '' }}>Este año</option>
                        </select>
                    </div>

                    <div class="fg">
                        <label>Formato de Salida</label>
                        <div class="flex gap-3">
                            <button type="button" class="btn btn-neu btn-sm flex-1">
                                <i class="fas fa-file-pdf" style="color:var(--red);"></i> PDF
                            </button>
                            <button type="button" class="btn btn-neu btn-sm flex-1">
                                <i class="fas fa-file-excel" style="color:var(--green);"></i> Excel
                            </button>
                        </div>
                    </div>
                </div>

                <div class="fg" style="margin-top:16px;">
                    <label>Métricas a incluir</label>
                    <div class="uc-tags" style="justify-content:flex-start;">
                        @foreach($availableMetrics as $key => $label)
                            <div class="badge-neu bn-muted">
                                <i class="fas fa-check-circle" style="color:var(--verde);"></i> {{ $label }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <div style="display:flex; justify-content:flex-end; margin-top:24px;">
                    <button type="submit" class="btn btn-solid">
                        <i class="fas fa-sync-alt"></i> Actualizar Vista
                    </button>
                </div>
            </form>
        </div>

        <div class="nc" style="margin-top:22px;">
            <div class="cc-header">
                <div class="cc-title">Vista Previa</div>
                <div class="badge-neu bn-green">Datos actualizados</div>
            </div>

            <div class="kpi-row" style="grid-template-columns: 1fr 1fr;">
                <div class="kpi-card">
                    <div class="kp-top">
                        <div class="kp-icon"><i class="fas fa-paper-plane text-uaemex"></i></div>
                    </div>
                    <div class="kp-value">{{ $preview['summary']['encuestas_enviadas'] }}</div>
                    <div class="kp-label">ENCUESTAS ENVIADAS</div>
                </div>
                
                <div class="kpi-card">
                    <div class="kp-top">
                        <div class="kp-icon"><i class="fas fa-check-double text-uaemex"></i></div>
                        <div class="kp-change kp-up">
                            {{ $preview['summary']['tasa_respuesta'] }}%
                        </div>
                    </div>
                    <div class="kp-value">{{ $preview['summary']['encuestas_completadas'] }}</div>
                    <div class="kp-label">COMPLETADAS</div>
                </div>
            </div>

            <div class="gauge-card" style="margin-top:22px; justify-content:center;">
                <div class="gauge-circle">
                    <div class="gauge-inner">
                        <div class="gauge-val">{{ number_format($preview['summary']['satisfaccion_promedio'], 1) }}</div>
                    </div>
                </div>
                <div class="gauge-info">
                    <div class="gauge-name">Satisfacción Promedio</div>
                    <div class="gauge-sub">Escala de 1 a 5 basada en {{ $preview['summary']['encuestas_completadas'] }} respuestas</div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN -->
    <div style="grid-column: span 4;">
        <div class="nc">
            <div class="cc-header">
                <div class="cc-title">Programación</div>
            </div>
            
            <div class="fg" style="gap:16px;">
                <label class="flex items-center gap-3 cursor-pointer">
                    <div class="status-led"></div>
                    <span style="font-size:13px; color:var(--text);">Diario al correo institucional</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <div class="status-led" style="background:var(--bg-dark);"></div>
                    <span style="font-size:13px; color:var(--text);">Semanal a coordinadores</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <div class="status-led" style="background:var(--bg-dark);"></div>
                    <span style="font-size:13px; color:var(--text);">Mensual a dirección</span>
                </label>
            </div>

            <button class="btn btn-oro" style="width:100%; margin-top:24px; justify-content:center;">
                <i class="fas fa-clock"></i> Guardar Programación
            </button>
        </div>

        <div class="hist-neu" style="margin-top:22px;">
            <div class="hn-head">
                <div class="hn-title">Historial de Descargas</div>
            </div>
            <div class="hn-list">
                @foreach($history as $item)
                <div class="hn-item">
                    <div class="hn-name">{{ $item['name'] }}</div>
                    <div class="hn-meta">
                        <span>{{ $item['generated_at']->diffForHumans() }}</span>
                        <div class="badge-neu bn-muted" style="font-size:9px;">{{ $item['format'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
