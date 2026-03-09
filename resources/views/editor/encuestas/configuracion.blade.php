@extends('layouts.editor')

@section('title', 'Configuración de Encuesta')

@section('content')
<div class="welcome-section" style="margin-bottom: 1.5rem;">
    <div class="welcome-content flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <p class="greeting-eyebrow">Configuración de encuesta</p>
            <h2 class="greeting">{{ $survey->title ?: 'Encuesta sin título' }}</h2>
            <p class="greeting-subtitle">Define fechas, acceso y opciones generales antes de compartir</p>
        </div>
        <a href="{{ route('editor.encuestas.editar', $survey) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 text-gray-700 text-xs font-semibold hover:bg-gray-50 transition">
            <i class="fas fa-pen"></i>
            Volver al editor
        </a>
    </div>
</div>

<div class="flex items-center justify-between mb-4" style="display:none;">
    <div>
        <p class="text-xs uppercase tracking-widest text-gray-400 font-semibold">Configuración</p>
        <h1 class="text-2xl font-bold text-gray-100 mt-1">{{ $survey->title ?: 'Encuesta sin título' }}</h1>
    </div>
    <a href="{{ route('editor.encuestas.editar', $survey) }}" class="px-4 py-2 rounded-full border border-gray-500/40 text-gray-300 text-xs font-semibold hover:bg-white/5 transition flex items-center gap-2">
        <i class="fas fa-pen"></i>
        Volver al editor
    </a>
</div>

<form method="POST" action="{{ route('editor.encuestas.configuracion.update', $survey) }}">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">
        <div class="lg:col-span-1 space-y-3">
            <div class="bg-slate-900/60 border border-white/10 rounded-2xl p-4 space-y-2 text-xs">
                <p class="uppercase tracking-widest text-gray-400 font-semibold">Secciones</p>
                <p class="flex items-center justify-between text-gray-200">
                    <span class="flex items-center gap-2"><i class="fas fa-circle text-emerald-400 text-[8px]"></i> General</span>
                    <span class="text-[10px] text-gray-500">Activo</span>
                </p>
                <p class="flex items-center justify-between text-gray-500">
                    <span class="flex items-center gap-2"><i class="fas fa-circle text-gray-600 text-[8px]"></i> Diseño</span>
                    <span class="text-[10px]">Próximamente</span>
                </p>
                <p class="flex items-center justify-between text-gray-500">
                    <span class="flex items-center gap-2"><i class="fas fa-circle text-gray-600 text-[8px]"></i> Distribución</span>
                    <span class="text-[10px]">Próximamente</span>
                </p>
                <p class="flex items-center justify-between text-gray-500">
                    <span class="flex items-center gap-2"><i class="fas fa-circle text-gray-600 text-[8px]"></i> Lógica</span>
                    <span class="text-[10px]">Próximamente</span>
                </p>
            </div>
        </div>

        <div class="lg:col-span-3 space-y-5">
            <div class="bg-slate-900/60 border border-white/10 rounded-2xl p-5 space-y-4">
                <h2 class="text-sm font-semibold text-gray-100 flex items-center gap-2">
                    <i class="fas fa-info-circle text-emerald-400"></i>
                    General
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-xs font-semibold text-gray-400">Título</label>
                        <input type="text" name="title" value="{{ old('title', $survey->title) }}" class="w-full bg-slate-950/60 border border-white/10 rounded-xl px-3 py-2 text-gray-100 text-sm focus:outline-none focus:border-emerald-500" required>
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-xs font-semibold text-gray-400">Descripción</label>
                        <textarea name="description" rows="2" class="w-full bg-slate-950/60 border border-white/10 rounded-xl px-3 py-2 text-gray-100 text-sm focus:outline-none focus:border-emerald-500">{{ old('description', $survey->description) }}</textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-400">Fecha de inicio</label>
                        <input type="date" name="start_date" value="{{ optional($survey->start_date)->format('Y-m-d') }}" class="w-full bg-slate-950/60 border border-white/10 rounded-xl px-3 py-2 text-gray-100 text-sm focus:outline-none focus:border-emerald-500" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-400">Fecha de fin</label>
                        <input type="date" name="end_date" value="{{ optional($survey->end_date)->format('Y-m-d') }}" class="w-full bg-slate-950/60 border border-white/10 rounded-xl px-3 py-2 text-gray-100 text-sm focus:outline-none focus:border-emerald-500" required>
                    </div>
                </div>
            </div>

            @php
                $settings = $survey->settings ?? [];
            @endphp

            <div class="bg-slate-900/60 border border-white/10 rounded-2xl p-5 space-y-4">
                <h2 class="text-sm font-semibold text-gray-100 flex items-center gap-2">
                    <i class="fas fa-sliders-h text-sky-400"></i>
                    Opciones avanzadas
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-400">Máximo de respuestas</label>
                        <input type="number" name="max_responses" value="{{ $settings['max_responses'] ?? '' }}" class="w-full bg-slate-950/60 border border-white/10 rounded-xl px-3 py-2 text-gray-100 focus:outline-none focus:border-emerald-500" min="1">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-400">Tema</label>
                        <input type="text" name="theme" value="{{ $settings['theme'] ?? '' }}" class="w-full bg-slate-950/60 border border-white/10 rounded-xl px-3 py-2 text-gray-100 focus:outline-none focus:border-emerald-500" placeholder="Predeterminado">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-400">Logo</label>
                        <input type="text" name="logo_url" value="{{ $settings['logo_url'] ?? '' }}" class="w-full bg-slate-950/60 border border-white/10 rounded-xl px-3 py-2 text-gray-100 focus:outline-none focus:border-emerald-500" placeholder="URL de imagen">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-400">Página de agradecimiento</label>
                        <textarea name="thank_you_page" rows="2" class="w-full bg-slate-950/60 border border-white/10 rounded-xl px-3 py-2 text-gray-100 focus:outline-none focus:border-emerald-500">{{ $settings['thank_you_page'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900/60 border border-white/10 rounded-2xl p-5 space-y-4">
                <h2 class="text-sm font-semibold text-gray-100 flex items-center gap-2">
                    <i class="fas fa-link text-emerald-400"></i>
                    Acceso y seguridad
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-xs font-semibold text-gray-400">Enlace público</label>
                        <input type="text" name="public_link" value="{{ $settings['public_link'] ?? route('surveys.public', $survey->id) }}" class="w-full bg-slate-950/60 border border-white/10 rounded-xl px-3 py-2 text-gray-100 focus:outline-none focus:border-emerald-500">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-400">Contraseña de acceso</label>
                        <input type="text" name="password" value="{{ $settings['password'] ?? '' }}" class="w-full bg-slate-950/60 border border-white/10 rounded-xl px-3 py-2 text-gray-100 focus:outline-none focus:border-emerald-500">
                    </div>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-gray-300">
                            <input type="checkbox" name="one_response_per_ip" value="1" class="rounded border-gray-500 text-emerald-500 focus:ring-emerald-500" {{ !empty($settings['one_response_per_ip']) ? 'checked' : '' }}>
                            Una respuesta por IP
                        </label>
                    </div>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-gray-300">
                            <input type="checkbox" name="allow_edit_response" value="1" class="rounded border-gray-500 text-emerald-500 focus:ring-emerald-500" {{ !empty($settings['allow_edit_response']) ? 'checked' : '' }}>
                            Permitir editar respuesta
                        </label>
                    </div>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-gray-300">
                            <input type="checkbox" name="show_progress_bar" value="1" class="rounded border-gray-500 text-emerald-500 focus:ring-emerald-500" {{ !empty($settings['show_progress_bar']) ? 'checked' : '' }}>
                            Mostrar barra de progreso
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-emerald-500 text-xs font-semibold text-white hover:bg-emerald-600 transition">
                    <i class="fas fa-save"></i>
                    Guardar configuración
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
