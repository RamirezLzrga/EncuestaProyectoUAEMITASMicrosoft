@extends('layouts.admin')

@section('title', 'Monitoreo en Vivo')

@section('content')
<div class="ph">
    <div class="ph-left">
        <div class="ph-label">Administración</div>
        <div class="ph-title">Monitoreo en Vivo</div>
        <div class="ph-sub">Usuarios conectados y actividad en tiempo real</div>
    </div>
    <div class="ph-actions">
        <span class="status-pill status-approved" style="background:var(--bg);">
            <span style="width:8px; height:8px; border-radius:50%; background:var(--green); display:inline-block;"></span>
            Actualización cada 5s
        </span>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mt-6">
    <div class="space-y-6 xl:col-span-1">
        <div class="neu-card" style="margin-bottom:0; padding:22px;">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-users text-uaemex"></i>
                Usuarios conectados AHORA
            </h2>
            <div class="space-y-3">
                @foreach($usersOnline as $user)
                    <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; background:var(--bg); border-radius:var(--radius); box-shadow:var(--neu-in-sm); padding:12px;">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-uaemex text-white flex items-center justify-center text-xs font-semibold">
                                {{ substr($user['name'], 0, 2) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ $user['name'] }}</p>
                                <p class="text-xs text-gray-500">{{ $user['location'] }}</p>
                            </div>
                        </div>
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 font-semibold uppercase">
                            {{ strtoupper($user['role']) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="neu-card" style="margin-bottom:0; padding:22px;">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-stream text-uaemex"></i>
                Actividad reciente
            </h2>
            <div class="space-y-3 max-h-64 overflow-y-auto text-sm">
                @foreach($recentActivity as $item)
                    <div class="flex items-start gap-3">
                        <div style="width:24px; height:24px; border-radius:999px; background:var(--oro-pale); color:var(--verde); display:flex; align-items:center; justify-content:center; font-size:12px; box-shadow:var(--neu-out);">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div>
                            <p class="text-gray-800">{{ $item['description'] }}</p>
                            <p class="text-xs text-gray-500">{{ $item['time']->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="space-y-6 xl:col-span-2">
        <div class="neu-card" style="margin-bottom:0; padding:22px;">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-line text-uaemex"></i>
                Actividad por hora
            </h2>
            <div class="grid grid-cols-5 gap-3 text-center text-xs">
                @foreach($activityTimeline as $point)
                    <div class="flex flex-col items-center gap-2">
                        <div class="h-24 w-6 bg-gray-100 rounded-full flex items-end overflow-hidden">
                            <div class="w-full bg-uaemex rounded-full" style="height: {{ max(8, $point['count'] * 4) }}px;"></div>
                        </div>
                        <span class="font-semibold text-gray-700">{{ $point['hour'] }}</span>
                        <span class="text-[10px] text-gray-500">{{ $point['count'] }} eventos</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="neu-card" style="margin-bottom:0; padding:22px;">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-map-marker-alt text-uaemex"></i>
                Mapa de calor por ubicación
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                @foreach($heatmap as $point)
                    <div style="background:var(--bg); border-radius:var(--radius); box-shadow:var(--neu-in-sm); padding:12px; display:flex; flex-direction:column; gap:6px;">
                        <p class="font-semibold text-gray-800">{{ $point['location'] }}</p>
                        <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                            <div class="h-full rounded-full" style="background:var(--oro); width: {{ min(100, $point['count'] * 10) }}%;"></div>
                        </div>
                        <p class="text-xs text-gray-500">{{ $point['count'] }} usuarios conectados</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
