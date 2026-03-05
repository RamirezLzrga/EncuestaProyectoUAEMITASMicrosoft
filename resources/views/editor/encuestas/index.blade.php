@extends('layouts.editor')

@section('title', 'Mis Encuestas')

@section('content')
<!-- Include FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Custom Styles for this view since Tailwind is not available */
    .filter-pill {
        display: flex;
        align-items: center;
        gap: 12px;
        background: var(--bg);
        box-shadow: var(--neu-out);
        border-radius: 999px;
        padding: 6px 12px 6px 24px;
        margin-bottom: 32px;
        flex-wrap: wrap;
        min-height: 56px;
    }
    .filter-form {
        display: flex;
        align-items: center;
        gap: 16px;
        width: 100%;
        flex-wrap: wrap;
    }
    .filter-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .filter-divider {
        width: 2px;
        height: 24px;
        background: var(--neu-dark);
        opacity: 0.3;
        margin: 0 8px;
        border-radius: 99px;
    }
    .search-wrapper {
        flex: 1;
        position: relative;
        min-width: 200px;
    }
    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 13px;
        pointer-events: none;
    }
    
    /* Table Styles */
    .table-container {
        background: var(--bg);
        border-radius: var(--radius-lg);
        box-shadow: var(--neu-out);
        padding: 0;
        overflow: hidden;
    }
    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .custom-table th {
        text-align: left;
        padding: 18px 24px;
        font-size: 11px;
        color: var(--text-muted);
        text-transform: uppercase;
        font-family: 'JetBrains Mono', monospace;
        font-weight: 700;
        border-bottom: 2px solid rgba(0,0,0,0.03);
        background: rgba(0,0,0,0.015);
        letter-spacing: 0.5px;
    }
    .custom-table td {
        padding: 18px 24px;
        font-size: 13.5px;
        color: var(--text-dark);
        border-bottom: 1px solid rgba(0,0,0,0.05);
        vertical-align: middle;
        background: var(--bg);
        transition: background 0.2s;
    }
    .custom-table tr:last-child td {
        border-bottom: none;
    }
    .custom-table tr:hover td {
        background: rgba(255,255,255,0.3);
    }
    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        transition: all 0.2s;
        text-decoration: none;
        background: transparent;
        border: none;
        cursor: pointer;
        box-shadow: none;
    }
    .action-btn:hover {
        background: var(--bg);
        box-shadow: var(--neu-out);
        color: var(--verde);
        transform: translateY(-1px);
    }
    
    /* Responsive tweaks */
    @media (max-width: 992px) {
        .filter-pill {
            padding: 16px;
            border-radius: 24px;
            gap: 16px;
        }
        .filter-form {
            flex-direction: column;
            align-items: stretch;
        }
        .filter-divider { display: none; }
        .filter-group { flex-direction: column; align-items: stretch; }
        .filter-group .fn-label { margin-bottom: 4px; }
        .custom-table th, .custom-table td { padding: 12px 16px; }
        .table-container { overflow-x: auto; }
    }
</style>

<div class="ph">
    <div>
        <div class="ph-label">EDITOR · MIS ENCUESTAS</div>
        <h1 class="ph-title">Mis Encuestas</h1>
        <div class="ph-sub">Administra y filtra las encuestas que has creado</div>
    </div>
    <div class="ph-actions">
        <a href="{{ route('editor.encuestas.plantillas') }}" class="btn btn-solid">
            <i class="fas fa-plus"></i> CREAR ENCUESTA
        </a>
    </div>
</div>

<div class="filter-pill">
    <form action="{{ route('surveys.index') }}" method="GET" class="filter-form">
        <!-- Date Filter -->
        <div class="filter-group">
            <label class="fn-label" style="min-width: 45px;">DESDE:</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="fn-input" style="padding-right: 10px;">
        </div>

        <div class="filter-divider"></div>

        <!-- Status Filter -->
        <div class="filter-group">
            <label class="fn-label">ESTADO:</label>
            <div style="position: relative;">
                <select name="status" onchange="this.form.submit()" class="fn-input" style="min-width: 130px; cursor: pointer;">
                    <option value="Todas" {{ request('status') == 'Todas' ? 'selected' : '' }}>Todas</option>
                    <option value="Activas" {{ request('status') == 'Activas' ? 'selected' : '' }}>Activas</option>
                    <option value="Inactivas" {{ request('status') == 'Inactivas' ? 'selected' : '' }}>Inactivas</option>
                </select>
            </div>
        </div>

        <div class="filter-divider"></div>

        <!-- Search -->
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar encuesta..." class="fn-input" style="width: 100%; padding-left: 36px;">
        </div>

        <!-- Reset Button -->
        @if(request()->has('start_date') || request()->has('status') || request()->has('search'))
            <a href="{{ route('surveys.index') }}" class="btn btn-neu btn-sm" style="white-space: nowrap; margin-left: 8px;">
                <i class="fas fa-times"></i>
            </a>
        @endif
    </form>
</div>

<div class="table-container">
    @if($surveys->count() > 0)
        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th width="35%">Título</th>
                        <th width="15%">Creación</th>
                        <th width="10%" style="text-align: center;">Respuestas</th>
                        <th width="10%" style="text-align: center;">Preguntas</th>
                        <th width="10%" style="text-align: center;">Estado</th>
                        <th width="10%" style="text-align: center;">Aprobación</th>
                        <th width="10%" style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($surveys as $survey)
                        <tr>
                            <td>
                                <div style="font-weight: 700; color: var(--text-dark);">{{ $survey->title }}</div>
                                <div style="font-size: 12px; color: var(--text-muted); margin-top: 2px;">{{ \Illuminate\Support\Str::limit($survey->description, 60) }}</div>
                            </td>
                            <td>
                                <div style="font-weight: 600;">{{ $survey->created_at ? $survey->created_at->format('d/m/Y') : 'N/A' }}</div>
                                <div style="font-size: 11px; color: var(--text-muted);">{{ $survey->created_at ? $survey->created_at->format('h:i A') : '' }}</div>
                            </td>
                            <td style="text-align: center;">
                                <span class="badge-neu">{{ $survey->responses()->count() }}</span>
                            </td>
                            <td style="text-align: center;">
                                <span style="color: var(--text-muted); font-weight: 700; font-size: 12px;">{{ count($survey->questions ?? []) }}</span>
                            </td>
                            <td style="text-align: center;">
                                <span class="badge-neu {{ $survey->is_active ? 'bn-green' : 'bn-red' }}">
                                    {{ $survey->is_active ? 'Activa' : 'Inactiva' }}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                @php
                                    $approval = $survey->approval_status ?? 'pending';
                                    $statusClass = match($approval) {
                                        'approved' => 'bn-green',
                                        'rejected' => 'bn-red',
                                        default => 'bn-gold'
                                    };
                                    $statusLabel = match($approval) {
                                        'approved' => 'Aprobada',
                                        'rejected' => 'Rechazada',
                                        default => 'Pendiente'
                                    };
                                @endphp
                                <span class="badge-neu {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; align-items: center; justify-content: center; gap: 4px;">
                                    <a href="{{ route('surveys.public', $survey->id) }}" target="_blank" class="action-btn" title="Ver encuesta pública">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    <a href="{{ route('editor.encuestas.respuestas', $survey) }}" class="action-btn" title="Ver respuestas">
                                        <i class="fas fa-chart-pie"></i>
                                    </a>
                                    <a href="{{ route('editor.encuestas.editar', $survey) }}" class="action-btn" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('surveys.toggle-status', $survey->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="action-btn" title="{{ $survey->is_active ? 'Desactivar' : 'Activar' }}" style="color: {{ $survey->is_active ? 'var(--red)' : 'var(--verde)' }};">
                                            <i class="fas {{ $survey->is_active ? 'fa-ban' : 'fa-check-circle' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div style="text-align: center; padding: 60px 20px;">
            <div style="width: 80px; height: 80px; background: var(--verde-pale); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; color: var(--verde); font-size: 32px; box-shadow: var(--neu-out);">
                <i class="fas fa-search"></i>
            </div>
            <h3 style="font-family: 'Sora', sans-serif; font-weight: 700; font-size: 20px; color: var(--text-dark); margin-bottom: 8px;">No se encontraron encuestas</h3>
            <p style="color: var(--text-muted); margin-bottom: 32px; max-width: 400px; margin-left: auto; margin-right: auto;">
                @if(request()->has('search') || request()->has('status'))
                    No hay resultados para los filtros aplicados.
                @else
                    Aún no has creado ninguna encuesta. ¡Comienza ahora!
                @endif
            </p>
            @if(request()->has('search') || request()->has('status'))
                <a href="{{ route('surveys.index') }}" class="btn btn-neu">
                    <i class="fas fa-times-circle"></i> Limpiar filtros
                </a>
            @else
                <a href="{{ route('editor.encuestas.plantillas') }}" class="btn btn-solid">
                    <i class="fas fa-plus"></i> Crear encuesta
                </a>
            @endif
        </div>
    @endif
</div>

<div style="margin-top: 24px;">
    {{ $surveys->withQueryString()->links() }}
</div>

@endsection
