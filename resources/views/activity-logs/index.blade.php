@extends('layouts.admin')

@section('title', 'Bitácora de Actividades')

@section('content')
    {{-- HEADER --}}
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:30px;">
        <div>
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:6px;">
                <div style="font-size:11px; font-weight:800; color:var(--oro); letter-spacing:1px; text-transform:uppercase;">AUDITORÍA</div>
                <div style="display:flex; align-items:center; gap:6px; background:var(--red-pale); padding:4px 10px; border-radius:999px;">
                    <div style="width:6px; height:6px; border-radius:50%; background:var(--red);"></div>
                    <span style="font-size:10px; font-weight:800; color:var(--red); text-transform:uppercase; letter-spacing:0.5px;">En vivo</span>
                </div>
            </div>
            <h1 style="font-family:'Sora',sans-serif; font-size:32px; font-weight:700; color:var(--text-dark); margin-bottom:8px;">Bitácora de Actividades</h1>
            <p style="color:var(--text-muted);">Registro completo de todas las acciones en el sistema</p>
        </div>
        <div>
            <a href="{{ route('activity-logs.export', request()->query()) }}" class="btn-neu" style="padding:10px 20px; font-weight:700; display:flex; align-items:center; gap:8px; color:var(--text-dark); text-decoration:none;">
                <span style="font-size:16px;">📥</span>
                Exportar
            </a>
        </div>
    </div>

    {{-- FILTERS --}}
    <div class="neu-card" style="padding:16px 24px; margin-bottom:30px; display:flex; align-items:center; gap:20px; flex-wrap:wrap;">
        <form action="{{ route('activity-logs.index') }}" method="GET" style="display:contents;">
            
            {{-- Period Filter --}}
            <div style="display:flex; align-items:center; gap:12px;">
                <label style="font-weight:700; color:var(--text-muted); font-size:13px; font-family:'JetBrains Mono',monospace;">Período:</label>
                <div style="position:relative;">
                    <select name="period" 
                        style="appearance:none; background:var(--bg); border:none; padding:10px 36px 10px 16px; border-radius:12px; font-size:13px; font-weight:600; color:var(--text-dark); box-shadow:var(--neu-in-sm); cursor:pointer; outline:none; min-width:140px;">
                        <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Hoy</option>
                        <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Última Semana</option>
                        <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Último Mes</option>
                        <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>Este Año</option>
                        <option value="all" {{ request('period') == 'all' ? 'selected' : '' }}>Todos</option>
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
    <div id="logs-container" style="display:flex; flex-direction:column; gap:16px;">
        @include('activity-logs.partials.list')
    </div>

    {{-- SCRIPT --}}
    <script>
        // Auto-refresh logic
        setInterval(function(){
            const url = window.location.href;
            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(html => {
                if(html.trim() !== '') {
                    document.getElementById('logs-container').innerHTML = html;
                }
            })
            .catch(err => console.error(err));
        }, 5000);
    </script>
@endsection
