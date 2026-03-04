@extends('layouts.admin')

@section('title', 'Usuarios')

@section('content')
<div class="ph">
    <div>
        <div class="ph-label">Administración</div>
        <div class="ph-title">Usuarios</div>
        <div class="ph-sub">Gestión de accesos y roles del sistema</div>
    </div>
    <div class="ph-actions">
        <a href="{{ route('users.create') }}" class="btn btn-solid">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Nuevo Usuario
        </a>
    </div>
</div>

<div class="filter-neu mb-8" style="margin-bottom: 32px;">
    <form action="{{ route('users.index') }}" method="GET" class="contents" style="display: contents;">
        <div class="fn-label">Filtrar por:</div>
        <select name="role" class="fn-input fg-sel" onchange="this.form.submit()">
            <option value="Todos">Todos los roles</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
            <option value="editor" {{ request('role') == 'editor' ? 'selected' : '' }}>Editor</option>
            <option value="viewer" {{ request('role') == 'viewer' ? 'selected' : '' }}>Solo vista</option>
        </select>

        <select name="status" class="fn-input fg-sel" onchange="this.form.submit()">
            <option value="Todos">Todos los estados</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Activo</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactivo</option>
        </select>

        <div class="fn-search">
            <svg class="fn-search-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            <input type="text" name="search" value="{{ request('search') }}" class="fn-input" placeholder="Buscar usuario...">
        </div>
    </form>
</div>

<div class="users-grid">
    @forelse($users as $user)
    <div class="user-card">
        <div class="uc-avatar">
            {{ substr($user->name, 0, 1) }}
        </div>
        <div class="uc-name">{{ $user->name }}</div>
        <div class="uc-email">{{ $user->email }}</div>

        <div class="uc-tags">
            <!-- Role Badge -->
            @if($user->role === 'admin')
            <span class="badge-neu bn-green">Admin</span>
            @elseif($user->role === 'editor')
            <span class="badge-neu bn-gold">Editor</span>
            @else
            <span class="badge-neu bn-muted">{{ ucfirst($user->role) }}</span>
            @endif

            <!-- Status Badge -->
            @if($user->status === 'active')
            <span class="badge-neu bn-green">Activo</span>
            @else
            <span class="badge-neu bn-muted">Inactivo</span>
            @endif
        </div>

        <div class="uc-stats">
            <div class="uc-stat">
                <div class="uc-stat-val">{{ $user->surveys()->count() }}</div>
                <div class="uc-stat-label">Encuestas</div>
            </div>
            <div class="uc-stat">
                {{-- Validar si existe relación responses o calcular --}}
                <div class="uc-stat-val">0</div>
                <div class="uc-stat-label">Respuestas</div>
            </div>
        </div>

        <div class="uc-actions">
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-neu" style="flex:1;justify-content:center;">
                Editar
            </a>
            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');" style="display:contents;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-neu" style="color:var(--red);">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
    @empty
    <div style="grid-column: 1/-1; text-align:center; color:var(--text-muted); padding:40px;">
        No se encontraron usuarios que coincidan con los filtros.
    </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $users->links() }}
</div>
@endsection
