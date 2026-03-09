@extends('layouts.admin')

@section('title', 'Reportes Globales')

@section('content')
    <div class="ph">
        <div class="ph-left">
            <div class="ph-label">Administración</div>
            <div class="ph-title">Reportes Globales</div>
            <div class="ph-sub">Genera y programa reportes del sistema</div>
        </div>
    </div>

    <div class="dash-grid">
        <!-- Config (Span 8) -->
        <div style="grid-column: span 8;">
            <div class="neu-card">
                <div class="cc-header">
                    <div>
                        <div class="cc-title">Configuración del Reporte</div>
                        <div class="cc-sub">Selecciona los parámetros para generar el reporte</div>
                    </div>
                </div>

                <form method="GET" action="{{ route('admin.reportes') }}">
                    <div class="grid-2" style="margin-bottom:22px;">
                        <div>
                            <label class="form-label">Período</label>
                            <div style="position:relative;">
                                <select name="period" class="form-input">
                                    <option value="hoy" {{ $period === 'hoy' ? 'selected' : '' }}>Hoy</option>
                                    <option value="semana" {{ $period === 'semana' ? 'selected' : '' }}>Esta semana</option>
                                    <option value="mes" {{ $period === 'mes' ? 'selected' : '' }}>Este mes</option>
                                    <option value="año" {{ $period === 'año' ? 'selected' : '' }}>Este año</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Formato</label>
                            <div style="display:flex; gap:12px;">
                                <button type="button" class="btn btn-neu btn-sm" style="flex:1; justify-content:center; color:var(--red);">
                                    <span>📄</span> PDF
                                </button>
                                <button type="button" class="btn btn-neu btn-sm" style="flex:1; justify-content:center; color:var(--green);">
                                    <span>📊</span> Excel
                                </button>
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom:22px;">
                        <label class="form-label">Métricas a incluir</label>
                        <div class="grid-2" style="gap:12px;">
                            @foreach($availableMetrics as $key => $label)
                                <label style="display:flex; align-items:center; gap:10px; cursor:pointer; user-select:none;">
                                    <input type="checkbox" checked disabled style="accent-color:var(--verde); width:16px; height:16px;">
                                    <span style="font-size:13px; color:var(--text);">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div style="display:flex; justify-content:flex-end;">
                        <button type="submit" class="btn btn-solid">
                            <span>↻</span> Actualizar Vista Previa
                        </button>
                    </div>
                </form>
            </div>

            <!-- Scheduled Reports (Below config) -->
            <div class="neu-card">
                <div class="cc-header">
                    <div>
                        <div class="cc-title">Reportes Programados</div>
                        <div class="cc-sub">Envíos automáticos configurados</div>
                    </div>
                    <button class="btn btn-neu btn-sm">+ Programar</button>
                </div>
                
                <div style="text-align:center; padding:20px; color:var(--text-muted); font-size:13px;">
                    No hay reportes programados actualmente.
                </div>
            </div>
        </div>

        <!-- Preview (Span 4) -->
        <div style="grid-column: span 4;">
            <div class="neu-card">
                <div class="cc-header">
                    <div>
                        <div class="cc-title">Vista Previa</div>
                        <div class="cc-sub">Resumen de datos</div>
                    </div>
                </div>

                <div style="display:flex; flex-direction:column; gap:16px;">
                    <div style="background:var(--bg-light); padding:16px; border-radius:var(--radius-sm); border:1px solid rgba(0,0,0,0.03);">
                        <div style="font-size:11px; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:8px;">Resumen General</div>
                        <div style="display:flex; justify-content:space-between; margin-bottom:6px; font-size:13px;">
                            <span style="color:var(--text);">Encuestas enviadas:</span>
                            <span style="font-weight:700; color:var(--text-dark);">{{ $preview['summary']['encuestas_enviadas'] }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; margin-bottom:6px; font-size:13px;">
                            <span style="color:var(--text);">Completadas:</span>
                            <span style="font-weight:700; color:var(--text-dark);">{{ $preview['summary']['encuestas_completadas'] }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:13px;">
                            <span style="color:var(--text);">Tasa respuesta:</span>
                            <span style="font-weight:700; color:var(--verde);">{{ $preview['summary']['tasa_respuesta'] }}%</span>
                        </div>
                    </div>

                    <div style="text-align:center; padding:20px; background:var(--bg); border-radius:var(--radius); box-shadow:var(--neu-in-sm);">
                        <div style="font-size:12px; color:var(--text-muted); margin-bottom:4px;">Satisfacción Promedio</div>
                        <div style="font-family:'Sora',sans-serif; font-size:42px; font-weight:700; color:var(--verde); line-height:1;">
                            {{ number_format($preview['summary']['satisfaccion_promedio'], 1) }}
                        </div>
                        <div style="font-size:10px; color:var(--text-light); margin-top:4px;">Escala 1 - 5</div>
                        <div style="display:flex; justify-content:center; gap:4px; margin-top:8px;">
                            @for($i=1; $i<=5; $i++)
                                <span style="color:{{ $i <= round($preview['summary']['satisfaccion_promedio']) ? 'var(--oro)' : 'var(--neu-dark)' }}">★</span>
                            @endfor
                        </div>
                    </div>

                    <button class="btn btn-oro" style="width:100%; justify-content:center;">
                        <span>⬇</span> Descargar Reporte
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
