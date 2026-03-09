@foreach($logs as $log)
    @php
        // Default values
        $icon = 'fa-info-circle';
        $iconColor = 'var(--text-muted)';
        $badgeText = 'INFO';
        $badgeBg = 'var(--bg-dark)';
        $badgeColor = 'var(--text-muted)';
        $iconBg = 'var(--bg)';

        if ($log->type == 'auth') {
            $icon = 'fa-lock';
            $iconColor = '#e67e22'; // Orange/Gold
            $badgeText = 'AUTH';
            $badgeBg = '#fef3c7'; // Light amber
            $badgeColor = '#d97706'; // Amber 600
            $iconBg = 'rgba(230, 126, 34, 0.1)';
        } elseif ($log->type == 'survey') {
            $icon = 'fa-clipboard-list';
            $iconColor = 'var(--uaemex)';
            $badgeText = 'SURVEY';
            $badgeBg = 'var(--verde-pale)';
            $badgeColor = 'var(--uaemex)';
            $iconBg = 'rgba(45, 80, 22, 0.1)';
        } elseif ($log->type == 'user') {
            $icon = 'fa-user';
            $iconColor = '#8e44ad'; // Purple
            $badgeText = 'USER';
            $badgeBg = '#f3e8ff'; // Light purple
            $badgeColor = '#7e22ce'; // Purple 700
            $iconBg = 'rgba(142, 68, 173, 0.1)';
        }
    @endphp

    <div class="neu-card" style="padding:20px; margin-bottom:0; display:flex; align-items:center; gap:20px; transition:transform 0.2s;">
        {{-- Icon --}}
        <div style="width:50px; height:50px; border-radius:14px; background:{{ $iconBg }}; display:grid; place-items:center; flex-shrink:0; box-shadow:var(--neu-in-sm);">
            <i class="fas {{ $icon }}" style="font-size:20px; color:{{ $iconColor }};"></i>
        </div>

        {{-- Content --}}
        <div style="flex:1;">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:4px;">
                <span style="background:{{ $badgeBg }}; color:{{ $badgeColor }}; padding:3px 8px; border-radius:6px; font-size:10px; font-weight:800; font-family:'JetBrains Mono',monospace; letter-spacing:0.5px;">
                    {{ $badgeText }}
                </span>
                <h3 style="font-size:15px; font-weight:700; color:var(--text-dark); margin:0;">{{ $log->description }}</h3>
            </div>
            <div style="font-size:13px; color:var(--text-muted); font-family:'JetBrains Mono',monospace;">
                <span style="font-weight:600; color:var(--text);">{{ $log->user ? $log->user->name : 'Sistema/Desconocido' }}</span>
                <span style="margin:0 6px;">•</span>
                {{ $log->user_email ?? 'N/A' }}
                <span style="margin:0 6px;">•</span>
                IP: {{ $log->ip_address }}
            </div>
        </div>

        {{-- Time --}}
        <div style="text-align:right; flex-shrink:0;">
            <div style="font-size:13px; font-weight:700; color:var(--text-light); font-family:'JetBrains Mono',monospace;">
                {{ $log->created_at->format('d/m/Y') }}
            </div>
            <div style="font-size:12px; color:var(--text-muted); font-family:'JetBrains Mono',monospace;">
                {{ $log->created_at->format('h:i a') }}
            </div>
        </div>
    </div>
@endforeach

@if($logs->count() == 0)
    <div style="padding:60px 20px; text-align:center;">
        <div style="width:80px; height:80px; border-radius:50%; background:var(--bg); box-shadow:var(--neu-out); display:grid; place-items:center; margin:0 auto 20px; font-size:32px; color:var(--text-muted);">
            📭
        </div>
        <h3 style="font-size:18px; font-weight:700; color:var(--text-dark); margin-bottom:8px;">No hay actividades registradas</h3>
        <p style="color:var(--text-muted); font-size:14px;">Intenta cambiar los filtros o el período de búsqueda.</p>
    </div>
@endif

<div style="margin-top:20px;">
    {{ $logs->appends(request()->query())->links() }}
</div>
