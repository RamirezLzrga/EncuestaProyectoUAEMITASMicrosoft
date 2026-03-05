@extends('layouts.editor')

@section('title', 'Configuración de Encuesta')

@section('content')
<div class="ph">
    <div>
        <div class="ph-label">Configuración</div>
        <h1 class="ph-title">{{ $survey->title ?: 'Encuesta sin título' }}</h1>
        <div class="ph-sub">Define fechas, acceso y opciones generales antes de compartir</div>
    </div>
    <div class="ph-actions">
        <a href="{{ route('editor.encuestas.editar', $survey) }}" class="btn btn-neu btn-sm">
            <i class="fas fa-pen"></i>
            Volver al editor
        </a>
    </div>
</div>

<form method="POST" action="{{ route('editor.encuestas.configuracion.update', $survey) }}">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="lg:col-span-1 space-y-6">
            <div class="nc space-y-4">
                <p class="text-[11px] uppercase tracking-widest text-[var(--text-muted)] font-bold">Secciones</p>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-[var(--text-dark)] font-bold text-sm">
                        <span class="flex items-center gap-2"><i class="fas fa-circle text-[var(--verde)] text-[8px]"></i> General</span>
                        <span class="text-[10px] text-[var(--text-muted)] uppercase tracking-wider">Activo</span>
                    </div>
                    <div class="flex items-center justify-between text-[var(--text-muted)] text-sm opacity-60">
                        <span class="flex items-center gap-2"><i class="fas fa-circle text-[var(--text-light)] text-[8px]"></i> Diseño</span>
                        <span class="text-[10px]">Próximamente</span>
                    </div>
                    <div class="flex items-center justify-between text-[var(--text-muted)] text-sm opacity-60">
                        <span class="flex items-center gap-2"><i class="fas fa-circle text-[var(--text-light)] text-[8px]"></i> Distribución</span>
                        <span class="text-[10px]">Próximamente</span>
                    </div>
                    <div class="flex items-center justify-between text-[var(--text-muted)] text-sm opacity-60">
                        <span class="flex items-center gap-2"><i class="fas fa-circle text-[var(--text-light)] text-[8px]"></i> Lógica</span>
                        <span class="text-[10px]">Próximamente</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-3 space-y-6">
            <div class="nc space-y-5">
                <h2 class="text-sm font-bold text-[var(--text-dark)] flex items-center gap-2 uppercase tracking-wide">
                    <i class="fas fa-info-circle text-[var(--verde)]"></i>
                    General
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-widest">Título</label>
                        <input type="text" name="title" value="{{ old('title', $survey->title) }}" class="fn-input w-full" required>
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-widest">Descripción</label>
                        <textarea name="description" rows="2" class="fn-input w-full rounded-2xl" style="min-height: 80px;">{{ old('description', $survey->description) }}</textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-widest">Fecha de inicio</label>
                        <input type="date" name="start_date" value="{{ optional($survey->start_date)->format('Y-m-d') }}" class="fn-input w-full" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-widest">Fecha de fin</label>
                        <input type="date" name="end_date" value="{{ optional($survey->end_date)->format('Y-m-d') }}" class="fn-input w-full" required>
                    </div>
                </div>
            </div>

            @php
                $settings = $survey->settings ?? [];
            @endphp

            <div class="nc space-y-5">
                <h2 class="text-sm font-bold text-[var(--text-dark)] flex items-center gap-2 uppercase tracking-wide">
                    <i class="fas fa-sliders-h text-[var(--oro)]"></i>
                    Opciones avanzadas
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-widest">Máximo de respuestas</label>
                        <input type="number" name="max_responses" value="{{ $settings['max_responses'] ?? '' }}" class="fn-input w-full" min="1">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-widest">Tema</label>
                        <input type="text" name="theme" value="{{ $settings['theme'] ?? '' }}" class="fn-input w-full" placeholder="Predeterminado">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-widest">Logo (URL)</label>
                        <input type="text" name="logo_url" value="{{ $settings['logo_url'] ?? '' }}" class="fn-input w-full" placeholder="https://...">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-widest">Página de agradecimiento</label>
                        <textarea name="thank_you_page" rows="2" class="fn-input w-full rounded-2xl">{{ $settings['thank_you_page'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="nc space-y-5">
                <h2 class="text-sm font-bold text-[var(--text-dark)] flex items-center gap-2 uppercase tracking-wide">
                    <i class="fas fa-link text-[var(--verde)]"></i>
                    Acceso y seguridad
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-widest">Enlace público</label>
                        <div class="relative">
                            <input type="text" name="public_link" value="{{ $settings['public_link'] ?? route('surveys.public', $survey->id) }}" class="fn-input w-full pr-10" readonly>
                            <button type="button" onclick="navigator.clipboard.writeText(this.previousElementSibling.value)" class="absolute right-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)] hover:text-[var(--verde)] transition">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-widest">Contraseña de acceso</label>
                        <input type="text" name="password" value="{{ $settings['password'] ?? '' }}" class="fn-input w-full" placeholder="Opcional">
                    </div>
                    
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                        <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-[var(--bg-light)] transition cursor-pointer select-none">
                            <input type="checkbox" name="one_response_per_ip" value="1" class="rounded border-[var(--neu-dark)] text-[var(--verde)] focus:ring-[var(--verde)]" {{ !empty($settings['one_response_per_ip']) ? 'checked' : '' }}>
                            <span class="text-xs font-bold text-[var(--text)]">Una respuesta por IP</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-[var(--bg-light)] transition cursor-pointer select-none">
                            <input type="checkbox" name="allow_edit_response" value="1" class="rounded border-[var(--neu-dark)] text-[var(--verde)] focus:ring-[var(--verde)]" {{ !empty($settings['allow_edit_response']) ? 'checked' : '' }}>
                            <span class="text-xs font-bold text-[var(--text)]">Permitir editar</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-[var(--bg-light)] transition cursor-pointer select-none">
                            <input type="checkbox" name="show_progress_bar" value="1" class="rounded border-[var(--neu-dark)] text-[var(--verde)] focus:ring-[var(--verde)]" {{ !empty($settings['show_progress_bar']) ? 'checked' : '' }}>
                            <span class="text-xs font-bold text-[var(--text)]">Barra de progreso</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="btn btn-solid">
                    <i class="fas fa-save"></i>
                    Guardar configuración
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
