@extends('layouts.admin')

@section('title', 'Usuarios')

@section('content')
    <div class="ph">
        <div class="ph-left">
            <div class="ph-label">Administración</div>
            <div class="ph-title">Usuarios del Sistema</div>
            <div class="ph-sub">Gestiona roles, estados y permisos</div>
        </div>
        <div class="ph-actions">
            <a href="{{ route('users.create') }}" class="btn btn-solid">+ Nuevo Usuario</a>
        </div>
    </div>

    <div class="neu-card" style="padding:16px;">
        <form method="GET" action="{{ route('users.index') }}" style="display:flex; gap:16px; align-items:center; flex-wrap:wrap;">
            <div style="display:flex; align-items:center; gap:8px;">
                <span style="font-size:13px; font-weight:700; color:var(--text-muted);">Rol:</span>
                <div style="position:relative;">
                    <select name="role" class="form-input" style="padding-right:30px; width:auto; min-width:140px;">
                        <option value="Todos" {{ request('role') == 'Todos' ? 'selected' : '' }}>Todos</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                        <option value="editor" {{ request('role') == 'editor' ? 'selected' : '' }}>Editor</option>
                        <option value="viewer" {{ request('role') == 'viewer' ? 'selected' : '' }}>Solo vista</option>
                    </select>
                </div>
            </div>

            <div style="display:flex; align-items:center; gap:8px;">
                <span style="font-size:13px; font-weight:700; color:var(--text-muted);">Estado:</span>
                <div style="position:relative;">
                    <select name="status" class="form-input" style="padding-right:30px; width:auto; min-width:140px;">
                        <option value="Todos" {{ request('status') == 'Todos' ? 'selected' : '' }}>Todos</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Activo</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
            </div>

            <div style="flex:1; display:flex; align-items:center; gap:8px; background:var(--bg); border-radius:var(--radius); box-shadow:var(--neu-in-sm); padding:0 12px;">
                <span style="font-size:16px;">🔍</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar usuario..." 
                       style="border:none; background:transparent; padding:12px 0; font-family:'Nunito',sans-serif; font-size:14px; width:100%; outline:none; color:var(--text);">
            </div>

            <button type="submit" class="btn btn-neu btn-sm">Filtrar</button>
        </form>
    </div>

    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap:22px; margin-top:22px;">
        @forelse($users as $u)
            <div class="neu-card" style="display:flex; flex-direction:column; gap:14px; margin-bottom:0; align-items:center; text-align:center;">
                <div style="width:64px; height:64px; border-radius:50%; background:var(--verde); color:var(--oro-bright); display:grid; place-items:center; font-family:'Sora',sans-serif; font-weight:700; font-size:24px; box-shadow:var(--neu-out);">
                    {{ strtoupper(substr($u->name,0,1)) }}
                </div>
                
                <div>
                    <div style="font-family:'Sora',sans-serif; font-weight:700; font-size:16px; color:var(--text-dark);">{{ $u->name }}</div>
                    <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">{{ $u->email }}</div>
                </div>

                <div style="display:flex; gap:8px;">
                    <span class="status-pill" style="background:var(--bg); color:{{ $u->role==='admin' ? 'var(--verde)' : ($u->role==='editor' ? 'var(--blue)' : 'var(--text)') }}; font-size:10px; padding:4px 10px;">
                        {{ ucfirst($u->role) }}
                    </span>
                    <span class="status-pill" style="background:var(--bg); color:{{ $u->status==='active' ? 'var(--green)' : 'var(--red)' }}; font-size:10px; padding:4px 10px;">
                        {{ $u->status==='active' ? '● Activo' : '○ Inactivo' }}
                    </span>
                </div>

                <div style="display:flex; gap:12px; width:100%; margin-top:4px;">
                    <div style="flex:1; background:var(--bg-light); border-radius:var(--radius-sm); padding:8px;">
                        <div style="font-size:14px; font-weight:700; color:var(--text-dark);">—</div>
                        <div style="font-size:10px; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px;">Encuestas</div>
                    </div>
                    <div style="flex:1; background:var(--bg-light); border-radius:var(--radius-sm); padding:8px;">
                        <div style="font-size:14px; font-weight:700; color:var(--text-dark);">—</div>
                        <div style="font-size:10px; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px;">Acciones</div>
                    </div>
                </div>

                <div style="display:flex; gap:8px; width:100%; margin-top:6px;">
                    <a href="{{ route('users.edit', $u->id) }}" class="btn btn-neu btn-sm" style="flex:1; justify-content:center;">✏ Editar</a>
                    <form action="{{ route('users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('¿Eliminar usuario?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" style="padding:8px 12px;">🗑</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="neu-card" style="grid-column: 1 / -1; text-align:center; color:var(--text-muted);">
                No se encontraron usuarios.
            </div>
        @endforelse
    </div>

    <div style="margin-top:22px;">{{ $users->appends(request()->query())->links() }}</div>
@endsection
