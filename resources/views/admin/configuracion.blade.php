@extends('layouts.admin')

@section('title', 'Configuración del Sistema')

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-uaemex">Configuración del Sistema</h1>
        <p class="text-sm text-gray-500">Ajustes generales, apariencia y seguridad del sistema.</p>
    </div>
</div>

<div class="mt-6 bg-white rounded-xl shadow-sm">
    <form method="POST" action="{{ route('admin.configuracion.update') }}">
        @csrf
    <div class="border-b border-gray-200 px-6 pt-4">
        <nav class="flex gap-6 text-sm font-semibold text-gray-500">
            <span class="py-3 border-b-2 border-uaemex text-uaemex">General</span>
            <span class="py-3 border-b-2 border-transparent text-gray-400">Apariencia</span>
            <span class="py-3 border-b-2 border-transparent text-gray-400">Seguridad</span>
        </nav>
    </div>

    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-building text-uaemex"></i>
                General
            </h2>

            <div class="space-y-3 text-sm">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Nombre de la organización</label>
                    <input type="text" name="general[organization_name]" value="{{ $general['organization_name'] }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-uaemex">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Logo del sistema</label>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-gold flex items-center justify-center text-uaemex-dark font-bold">
                            UA
                        </div>
                        <button class="px-3 py-2 rounded-lg border border-gray-300 text-xs text-gray-700 hover:bg-gray-50">
                            Cambiar logo
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Color primario</label>
                        <input type="color" name="general[primary_color]" value="{{ $general['primary_color'] }}" class="w-16 h-9 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Color secundario</label>
                        <input type="color" name="general[secondary_color]" value="{{ $general['secondary_color'] }}" class="w-16 h-9 border rounded-lg">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Idioma por defecto</label>
                    <select name="general[default_language]" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-uaemex">
                        <option value="es" {{ $general['default_language'] === 'es' ? 'selected' : '' }}>Español</option>
                        <option value="en" {{ $general['default_language'] === 'en' ? 'selected' : '' }}>Inglés</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-moon text-uaemex"></i>
                Apariencia
            </h2>

            <div class="space-y-3 text-sm">
                <div>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="general[dark_mode]" value="1" class="rounded border-gray-300 text-uaemex focus:ring-uaemex" {{ !empty($general['dark_mode']) ? 'checked' : '' }}>
                        Activar modo oscuro por defecto
                    </label>
                    <p class="text-xs text-gray-500 mt-1">Aplica un tema oscuro en todo el sistema.</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Página de inicio</label>
                    <select name="general[homepage]" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-uaemex">
                        <option value="dashboard" {{ ($general['homepage'] ?? 'dashboard') === 'dashboard' ? 'selected' : '' }}>Dashboard</option>
                        <option value="surveys" {{ ($general['homepage'] ?? '') === 'surveys' ? 'selected' : '' }}>Listado de encuestas</option>
                        <option value="statistics" {{ ($general['homepage'] ?? '') === 'statistics' ? 'selected' : '' }}>Estadísticas</option>
                    </select>
                </div>
                <div>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="general[show_help_tips]" value="1" class="rounded border-gray-300 text-uaemex focus:ring-uaemex" {{ !empty($general['show_help_tips']) ? 'checked' : '' }}>
                        Mostrar tips de ayuda en el dashboard
                    </label>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-shield-alt text-uaemex"></i>
                Seguridad
            </h2>

            <div class="space-y-3 text-sm">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Política de contraseñas</label>
                    <p class="border rounded-lg px-3 py-2 text-xs text-gray-600 bg-gray-50">
                        {{ $security['password_policy'] }}
                    </p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Tiempo de sesión (minutos)</label>
                    <input type="number" name="security[session_time]" value="{{ $security['session_time'] }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-uaemex">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Intentos máximos de inicio de sesión</label>
                    <input type="number" name="security[max_login_attempts]" value="{{ $security['max_login_attempts'] }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-uaemex">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Vencimiento de contraseña (días)</label>
                    <input type="number" name="security[password_expiration_days]" value="{{ $security['password_expiration_days'] }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-uaemex">
                </div>
                <div>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="security[two_factor_enabled]" value="1" class="rounded border-gray-300 text-uaemex focus:ring-uaemex" {{ $security['two_factor_enabled'] ? 'checked' : '' }}>
                        Activar autenticación de 2 factores
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="px-6 pb-4 flex justify-end border-t border-gray-100">
        <button type="submit" class="mt-4 px-6 py-2 rounded-lg bg-uaemex text-white text-sm font-semibold hover:bg-emerald-700 transition flex items-center gap-2">
            <i class="fas fa-save"></i>
            Guardar cambios
        </button>
    </div>
    </form>
</div>
@endsection
