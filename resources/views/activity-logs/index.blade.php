@extends('layouts.admin')

@section('title', 'Bitácora de Actividades')

@push('styles')
    <style>
        body { overflow: hidden; }
        .wrapper { height: 100vh; overflow: hidden; }
        #activity-logs-page { height: 100%; display: flex; flex-direction: column; max-width: 1100px; margin: 0 auto; }
        #activity-logs-list { flex: 1; min-height: 0; overflow: hidden; display: flex; flex-direction: column; }
        #activity-logs-scroll { flex: 1; min-height: 0; overflow: auto; padding: 16px; }
    </style>
@endpush

@section('content')
    <div id="activity-logs-page">
        {{-- HEADER --}}
        <div style="display:flex; justify-content:center; align-items:flex-end; margin-bottom:22px; text-align:center;">
            <div>
                <div style="display:flex; align-items:center; justify-content:center; gap:12px; margin-bottom:6px;">
                </div>
                <h1 style="font-family:'Sora',sans-serif; font-size:32px; font-weight:700; color:var(--text-dark); margin-bottom:8px;">Bitácora de Actividades</h1>
                <p style="color:var(--text-muted);">Registro completo de todas las acciones en el sistema</p>
            </div>
        </div>

        {{-- FILTERS --}}
        <div class="neu-card" style="padding:16px 24px; margin-bottom:18px; display:flex; align-items:center; justify-content:center; gap:20px; flex-wrap:wrap;">
            <form action="{{ route('activity-logs.index') }}" method="GET" style="display:contents;">
                {{-- Period Filter --}}
                <div style="display:flex; align-items:center; gap:12px;">
                    <label style="font-weight:700; color:var(--text-muted); font-size:13px; font-family:'JetBrains Mono',monospace;">Período:</label>
                    <div style="position:relative;">
                        <select name="period"
                            style="appearance:none; background:var(--bg); border:none; padding:10px 36px 10px 16px; border-radius:12px; font-size:13px; font-weight:600; color:var(--text-dark); box-shadow:var(--neu-in-sm); cursor:pointer; outline:none; min-width:140px;">
                            <option value="last5" {{ request('period', 'last5') == 'last5' ? 'selected' : '' }}>Últimos 5 días</option>
                            <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Hoy</option>
                        </select>
                        <div style="position:absolute; right:12px; top:50%; transform:translateY(-50%); pointer-events:none; color:var(--text-muted); font-size:10px;">▼</div>
                    </div>
                </div>

                {{-- Type Filter --}}
                <div style="display:flex; align-items:center; gap:12px;">
                    <label style="font-weight:700; color:var(--text-muted); font-size:13px; font-family:'JetBrains Mono',monospace;">Tipo:</label>
                    <div style="position:relative;">
                        <select name="type"
                            style="appearance:none; background:var(--bg); border:none; padding:10px 36px 10px 16px; border-radius:12px; font-size:13px; font-weight:600; color:var(--text-dark); box-shadow:var(--neu-in-sm); cursor:pointer; outline:none; min-width:160px;">
                            <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>Todas</option>
                            <option value="auth" {{ request('type') == 'auth' ? 'selected' : '' }}>Autenticación</option>
                            <option value="survey" {{ request('type') == 'survey' ? 'selected' : '' }}>Encuestas</option>
                            <option value="user" {{ request('type') == 'user' ? 'selected' : '' }}>Usuarios</option>
                        </select>
                        <div style="position:absolute; right:12px; top:50%; transform:translateY(-50%); pointer-events:none; color:var(--text-muted); font-size:10px;">▼</div>
                    </div>
                </div>

                <button type="submit" style="background:var(--uaemex); color:white; border:none; padding:10px 24px; border-radius:999px; font-weight:700; font-size:13px; cursor:pointer; box-shadow:var(--neu-out); transition:transform 0.2s;">
                    Aplicar
                </button>
            </form>
        </div>

        {{-- LOGS LIST --}}
        <div id="activity-logs-list" class="neu-card">
            <div id="activity-logs-scroll">
                <div id="logs-container" style="display:flex; flex-direction:column; gap:16px;">
                    @include('activity-logs.partials.list')
                </div>
            </div>
            <div style="padding:14px 16px 12px; background:var(--bg); box-shadow:0 -10px 18px rgba(0,0,0,0.06);">
                {{ $logs->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
