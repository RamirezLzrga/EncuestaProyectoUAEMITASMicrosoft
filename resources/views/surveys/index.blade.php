@extends('layouts.admin')

@section('title', 'Encuestas')

@section('content')
<div class="ph">
    <div>
        <div class="ph-label">Gestión</div>
        <div class="ph-title">Encuestas Globales</div>
        <div class="ph-sub">Gestiona todas tus encuestas</div>
    </div>
    <div class="ph-actions">
        <a href="{{ route('surveys.create') }}" class="btn btn-solid">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Nueva Encuesta
        </a>
    </div>
</div>

<div class="filter-neu mb-8" style="margin-bottom: 32px;">
    <form action="{{ route('surveys.index') }}" method="GET" class="contents" style="display: contents;">
        <div class="fn-label">Filtrar:</div>
        <select name="status" class="fn-input fg-sel" onchange="this.form.submit()">
            <option value="Todas" {{ request('status') == 'Todas' ? 'selected' : '' }}>Todas</option>
            <option value="Activas" {{ request('status') == 'Activas' ? 'selected' : '' }}>Activas</option>
            <option value="Inactivas" {{ request('status') == 'Inactivas' ? 'selected' : '' }}>Inactivas</option>
        </select>

        <input type="date" name="start_date" value="{{ request('start_date') }}" class="fn-input" style="width:auto; color:var(--text-muted);">

        <div class="fn-search">
            <svg class="fn-search-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            <input type="text" name="search" value="{{ request('search') }}" class="fn-input" placeholder="Buscar encuesta...">
        </div>
    </form>
</div>

<div class="surveys-grid">
    @forelse($surveys as $survey)
    <div class="survey-card" onclick="window.location='{{ route('surveys.show', $survey->id) }}'">
        <div class="sc-img">
            @if($survey->header_image)
            <img src="{{ asset('storage/' . $survey->header_image) }}" alt="{{ $survey->title }}">
            @else
            <div style="width:100%;height:100%;background:var(--verde);opacity:0.1;display:flex;align-items:center;justify-content:center;">
                <svg width="40" height="40" stroke="var(--verde)" fill="none" stroke-width="1" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            @endif
            <div class="sc-badge" style="color: {{ $survey->is_active ? 'var(--verde)' : 'var(--text-muted)' }}">
                {{ $survey->is_active ? 'ACTIVA' : 'INACTIVA' }}
            </div>
        </div>
        <div class="sc-body">
            <div class="sc-title">{{ $survey->title }}</div>
            <div class="sc-desc">{{ $survey->description }}</div>
            <div class="sc-meta">
                <div class="sc-meta-item">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    {{ $survey->user->name ?? 'Admin' }}
                </div>
                <div class="sc-meta-item">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                    {{ $survey->created_at->format('d M Y') }}
                </div>
            </div>
        </div>
        <div class="sc-foot">
            <div class="sc-meta-item" style="color:var(--text);">
                <span style="font-weight:700;">{{ $survey->responses->count() }}</span> Respuestas
            </div>
            <div style="display:flex; gap:8px;">
                <a href="{{ route('surveys.edit', $survey->id) }}" class="btn-icon-neu" title="Editar" onclick="event.stopPropagation();">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                </a>
                <a href="{{ route('surveys.statistics', $survey->id) }}" class="btn-icon-neu" title="Estadísticas" onclick="event.stopPropagation();">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M18 20V10" />
                        <path d="M12 20V4" />
                        <path d="M6 20v-6" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column: 1/-1; text-align:center; color:var(--text-muted); padding:40px;">
        No se encontraron encuestas con los filtros seleccionados.
    </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $surveys->links() }}
</div>
@endsection
