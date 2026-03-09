@extends('layouts.editor')

@section('title', 'Mis Encuestas')

@section('content')

{{-- Page Header --}}
<div class="ph">
    <div>
        <div class="ph-label">Editor · Mis Encuestas</div>
        <h1 class="ph-title">Mis Encuestas</h1>
        <p class="ph-sub">Administra y filtra las encuestas que has creado</p>
    </div>
    <div class="ph-actions">
        <a href="{{ route('editor.encuestas.nueva') }}" class="btn btn-solid">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Crear encuesta
        </a>
    </div>
</div>

{{-- Filters --}}
<form action="{{ route('surveys.index') }}" method="GET" id="filtersForm">
    <div class="filter-neu">
        <div style="display: flex; align-items: center; gap: 8px;">
            <span class="fn-label">Desde:</span>
            <div style="position: relative;">
                <input type="text" id="datepicker" name="start_date" value="{{ request('start_date') }}" class="fn-input" placeholder="dd/mm/aaaa" style="width: 150px; padding-right: 30px;">
                <div style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none; color: var(--text-light); font-size: 14px;">📅</div>
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 8px;">
            <span class="fn-label">Estado:</span>
            <select name="status" onchange="this.form.submit()" class="fn-input" style="width: 140px;">
                <option value="Todas" {{ request('status') == 'Todas' ? 'selected' : '' }}>Todas</option>
                <option value="Activas" {{ request('status') == 'Activas' ? 'selected' : '' }}>Activas</option>
                <option value="Inactivas" {{ request('status') == 'Inactivas' ? 'selected' : '' }}>Inactivas</option>
            </select>
        </div>

        <div class="fn-search">
            <div class="fn-search-icon">🔍</div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar encuesta..." class="fn-input" style="width: 100%;">
        </div>

        <a href="{{ route('surveys.index') }}" class="btn btn-neu btn-sm" style="color: var(--text-dark);">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 12" /></svg>
            Resetear
        </a>
    </div>
</form>

{{-- Content --}}
<div style="margin-top: 24px;">
    @if(session('success'))
        <div style="background: var(--green-pale); color: var(--green); padding: 12px 20px; border-radius: var(--radius); margin-bottom: 20px; font-weight: 600; font-size: 13.5px; box-shadow: var(--neu-out);">
            {{ session('success') }}
        </div>
    @endif

    @if($surveys->count() > 0)
        <div class="surveys-grid">
            @foreach($surveys as $survey)
                <div class="survey-card" onclick="window.location='{{ route('editor.encuestas.editar', $survey) }}'">
                    <div class="sc-banner {{ $survey->is_active ? 'activa' : 'borrador' }}"></div>
                    <div class="sc-body">
                        <div class="sc-top">
                            <div class="sc-name">{{ $survey->title }}</div>
                            <div class="badge-neu {{ $survey->is_active ? 'bn-green' : 'bn-muted' }}">
                                {{ $survey->is_active ? 'ACTIVA' : 'BORRADOR' }}
                            </div>
                        </div>
                        <div class="sc-desc">{{ Str::limit($survey->description ?? 'Sin descripción', 50) }}</div>
                        
                        <div class="sc-stats">
                            <div class="sc-stat">
                                <div class="sc-stat-val">{{ $survey->responses()->count() }}</div>
                                <div class="sc-stat-lbl">Resp.</div>
                            </div>
                            <div class="sc-stat">
                                <div class="sc-stat-val">{{ count($survey->questions ?? []) }}</div>
                                <div class="sc-stat-lbl">Preg.</div>
                            </div>
                            <div class="sc-stat">
                                <div class="sc-stat-val">
                                    @php
                                        $approval = $survey->approval_status ?? 'pending';
                                        $icon = $approval === 'approved' ? '✅' : ($approval === 'rejected' ? '❌' : '⏳');
                                    @endphp
                                    {{ $icon }}
                                </div>
                                <div class="sc-stat-lbl">Estado</div>
                            </div>
                        </div>

                        <div class="sc-author">
                            <div style="display: flex; align-items: center; gap: 6px; flex: 1;">
                                📅 {{ $survey->created_at ? $survey->created_at->format('d/m/Y') : '--' }}
                            </div>
                            <div style="display: flex; gap: 6px;">
                                <a href="{{ route('surveys.public', $survey->id) }}" target="_blank" title="Ver pública" style="color: var(--text-muted); transition: color .2s;" onclick="event.stopPropagation()">🔗</a>
                                <a href="{{ route('editor.encuestas.respuestas', $survey) }}" title="Resultados" style="color: var(--text-muted); transition: color .2s;" onclick="event.stopPropagation()">📊</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">🔍</div>
            <h3 class="empty-title">No se encontraron encuestas</h3>
            <p class="empty-sub">Intenta ajustar los filtros de búsqueda o crea tu primera encuesta</p>
            <a href="{{ route('editor.encuestas.nueva') }}" class="btn btn-solid" style="margin-top: 16px;">
                + Crear encuesta
            </a>
        </div>
    @endif
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .flatpickr-calendar {
            background: var(--bg);
            box-shadow: var(--neu-out-lg);
            border: none;
            border-radius: var(--radius);
            font-family: 'Nunito', sans-serif;
        }
        .flatpickr-day.selected {
            background: var(--verde) !important;
            border-color: var(--verde) !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const surveyDates = @json($surveyDates ?? []);

            flatpickr("#datepicker", {
                locale: "es",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d/m/Y",
                allowInput: true,
                disableMobile: "true",
                onDayCreate: function(dObj, dStr, fp, dayElem) {
                    const date = dayElem.dateObj.toISOString().slice(0, 10);
                    if (surveyDates.includes(date)) {
                        dayElem.style.fontWeight = "bold";
                        dayElem.style.color = "var(--verde)";
                        dayElem.title = "Hay encuestas este día";
                    }
                },
                onChange: function(selectedDates, dateStr, instance) {
                    document.getElementById('filtersForm').submit();
                }
            });
        });
    </script>
@endpush