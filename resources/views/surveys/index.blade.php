@extends('layouts.admin')

@section('title', 'Encuestas')

@section('content')
    <div class="ph">
        <div class="ph-left">
            <div class="ph-label">Administración</div>
            <div class="ph-title">Encuestas</div>
            <div class="ph-sub">Administra y monitorea encuestas</div>
        </div>
        <div class="ph-actions">
            <a href="{{ route('surveys.create') }}" class="btn btn-solid">+ Nueva Encuesta</a>
        </div>
    </div>

    <div class="neu-card" style="padding:16px;">
        <form action="{{ route('surveys.index') }}" method="GET" id="filtersForm" style="display:flex; gap:16px; align-items:center; flex-wrap:wrap;">
            <div style="display:flex; align-items:center; gap:8px;">
                <span style="font-size:13px; font-weight:700; color:var(--text-muted);">Desde:</span>
                <input type="text" id="datepicker" name="start_date" value="{{ request('start_date') }}" class="form-input" placeholder="Seleccionar..." style="width:auto; min-width:170px;">
            </div>

            <div style="display:flex; align-items:center; gap:8px;">
                <span style="font-size:13px; font-weight:700; color:var(--text-muted);">Estado:</span>
                <select name="status" onchange="this.form.submit()" class="form-input" style="width:auto; min-width:160px; padding-right:34px;">
                    <option value="Todas" {{ request('status') == 'Todas' ? 'selected' : '' }}>Todas</option>
                    <option value="Activas" {{ request('status') == 'Activas' ? 'selected' : '' }}>Activas</option>
                    <option value="Inactivas" {{ request('status') == 'Inactivas' ? 'selected' : '' }}>Inactivas</option>
                </select>
            </div>

            <div style="flex:1; display:flex; align-items:center; gap:8px; background:var(--bg); border-radius:var(--radius); box-shadow:var(--neu-in-sm); padding:0 12px; min-width:260px;">
                <span style="font-size:16px;">🔍</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar encuesta..."
                       style="border:none; background:transparent; padding:12px 0; font-family:'Nunito',sans-serif; font-size:14px; width:100%; outline:none; color:var(--text);">
            </div>

            <button type="submit" class="btn btn-neu btn-sm">Filtrar</button>
            <a href="{{ route('surveys.index') }}" class="btn btn-neu btn-sm">↺ Limpiar</a>
        </form>
    </div>

    @if(session('success'))
        <div class="badge-neu bn-green" style="margin-bottom:22px;">{{ session('success') }}</div>
    @endif

    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap:22px;">
        @forelse ($surveys as $survey)
            <div class="neu-card" style="margin-bottom:0; padding:20px; position:relative; overflow:hidden; display:flex; flex-direction:column; gap:14px;">
                <div style="position:absolute; top:0; left:0; bottom:0; width:6px; background:{{ $survey->is_active ? 'var(--verde)' : 'var(--oro)' }};"></div>

                <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:12px; padding-left:6px;">
                    <div style="min-width:0;">
                        <div style="font-family:'Sora',sans-serif; font-weight:700; font-size:16px; color:var(--text-dark); line-height:1.2;">
                            {{ $survey->title }}
                        </div>
                        <div style="font-size:12px; color:var(--text-muted); margin-top:6px;">
                            {{ $survey->description ?: 'Sin descripción' }}
                        </div>
                    </div>

                    <span class="status-pill {{ $survey->is_active ? 'status-approved' : 'status-pending' }}" style="background:var(--bg); flex-shrink:0;">
                        {{ $survey->is_active ? '● Activa' : '○ Pendiente' }}
                    </span>
                </div>

                <div style="display:flex; gap:12px; padding-left:6px;">
                    <div style="flex:1; background:var(--bg-light); border-radius:var(--radius-sm); padding:10px; text-align:center;">
                        <div style="font-size:16px; font-weight:800; color:var(--text-dark);">{{ $survey->responses()->count() }}</div>
                        <div style="font-size:10px; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px;">Resp.</div>
                    </div>
                    <div style="flex:1; background:var(--bg-light); border-radius:var(--radius-sm); padding:10px; text-align:center;">
                        <div style="font-size:16px; font-weight:800; color:var(--text-dark);">{{ count($survey->questions ?? []) }}</div>
                        <div style="font-size:10px; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px;">Preg.</div>
                    </div>
                    <div style="flex:1; background:var(--bg-light); border-radius:var(--radius-sm); padding:10px; text-align:center;">
                        <div style="font-size:16px; font-weight:800; color:var(--text-dark);">
                            {{ $survey->limit_responses ? intval(($survey->responses()->count() / $survey->limit_responses) * 100) : '—' }}@if($survey->limit_responses)%@endif
                        </div>
                        <div style="font-size:10px; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px;">Comp.</div>
                    </div>
                </div>

                <div style="display:flex; align-items:center; gap:10px; padding-left:6px; color:var(--text-muted);">
                    <div style="width:34px; height:34px; border-radius:50%; background:var(--verde); color:var(--oro-bright); display:grid; place-items:center; font-family:'Sora',sans-serif; font-weight:700; box-shadow:var(--neu-out);">
                        {{ strtoupper(substr(optional($survey->user)->name ?? '?', 0, 1)) }}
                    </div>
                    <div style="font-size:12px;">
                        <span style="font-weight:700; color:var(--text);">{{ strtoupper(optional($survey->user)->name ?? 'Desconocido') }}</span>
                        · {{ $survey->created_at ? $survey->created_at->format('d/m/Y') : 'N/A' }}
                    </div>
                </div>

                <div style="display:flex; gap:10px; flex-wrap:wrap; padding-left:6px;">
                    <a href="{{ route('surveys.public', $survey->id) }}" target="_blank" class="btn btn-neu btn-sm">↗ Abrir</a>
                    <a href="{{ route('surveys.show', $survey->id) }}" class="btn btn-neu btn-sm">👁 Ver</a>
                    <a href="{{ route('surveys.edit', $survey->id) }}" class="btn btn-neu btn-sm">✏ Editar</a>
                    <form action="{{ route('surveys.toggle-status', $survey->id) }}" method="POST" style="margin:0;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn {{ $survey->is_active ? 'btn-danger' : 'btn-solid' }} btn-sm" title="{{ $survey->is_active ? 'Inhabilitar' : 'Habilitar' }}" style="padding:8px 14px;">
                            {{ $survey->is_active ? '✕' : '✔' }}
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="neu-card" style="margin-bottom:0; grid-column: 1 / -1; text-align:center; color:var(--text-muted);">
                No se encontraron encuestas
            </div>
        @endforelse
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        /* Personalización de Flatpickr */
        .flatpickr-day.has-survey {
            background: var(--verde-xpale);
            border-color: transparent;
            position: relative;
        }
        .flatpickr-day.has-survey::after {
            content: '';
            position: absolute;
            bottom: 4px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            background-color: var(--verde);
            border-radius: 50%;
        }
        .flatpickr-day.selected.has-survey {
            background: var(--verde);
            border-color: var(--verde);
            color: #fff;
        }
        .flatpickr-day.selected.has-survey::after {
            background-color: #fff;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fechas con encuestas pasadas desde el controlador
            const surveyDates = @json($surveyDates ?? []);

            flatpickr("#datepicker", {
                locale: "es",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d/m/Y",
                allowInput: true,
                onDayCreate: function(dObj, dStr, fp, dayElem) {
                    // Formatear la fecha del día actual en el loop
                    const date = dayElem.dateObj.toISOString().slice(0, 10);
                    
                    // Si la fecha está en nuestra lista, agregar clase
                    if (surveyDates.includes(date)) {
                        dayElem.classList.add('has-survey');
                        dayElem.title = "Hay encuestas este día";
                    }
                },
                onChange: function(selectedDates, dateStr, instance) {
                    // Enviar el formulario al seleccionar fecha
                    document.getElementById('filtersForm').submit();
                }
            });
        });
    </script>
@endpush
