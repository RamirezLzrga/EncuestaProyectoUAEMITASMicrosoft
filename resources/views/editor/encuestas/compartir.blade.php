@extends('layouts.editor')

@section('title', 'Compartir Encuesta')

@section('content')
<div class="welcome-section" style="margin-bottom: 1.5rem;">
    <div class="welcome-content flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <p class="greeting-eyebrow">Compartir encuesta</p>
            <h2 class="greeting">{{ $survey->title }}</h2>
            <p class="greeting-subtitle">Genera enlace y resumen de estado antes de difundirla</p>
        </div>
        <a href="{{ route('editor.encuestas.editar', $survey) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 text-gray-700 text-xs font-semibold hover:bg-gray-50 transition">
            <i class="fas fa-pen"></i>
            Volver al editor
        </a>
    </div>
</div>

    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-header">
            <div class="card-title">
                <div class="card-icon">
                    <i class="fas fa-paper-plane"></i>
                </div>
                Estado de publicación
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div class="flex flex-col gap-1">
                <span class="text-xs font-semibold text-gray-400">Estado de aprobación</span>
                @php $approval = $survey->approval_status ?? 'pending'; @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                    @if($approval === 'approved') bg-emerald-100 text-emerald-700
                    @elseif($approval === 'rejected') bg-red-100 text-red-700
                    @else bg-amber-50 text-amber-700 @endif">
                    @if($approval === 'approved')
                        Aprobada por administración
                    @elseif($approval === 'rejected')
                        Rechazada, revisa los comentarios
                    @else
                        Pendiente de revisión
                    @endif
                </span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-semibold text-gray-400">Estado de actividad</span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $survey->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                    {{ $survey->is_active ? 'Activa y recibiendo respuestas' : 'Inactiva, en preparación' }}
                </span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-semibold text-gray-400">Notificación</span>
                @if($approval === 'pending')
                    <span class="text-xs text-gray-600">
                        Encuesta enviada al administrador. Te avisaremos en la campana cuando sea aprobada o rechazada.
                    </span>
                @elseif($approval === 'approved')
                    <span class="text-xs text-gray-600">
                        Ya fue aprobada. Puedes empezar a compartir el enlace y monitorear respuestas.
                    </span>
                @else
                    <span class="text-xs text-gray-600">
                        Revisa la sección de comentarios en el sistema de aprobaciones y ajusta tu encuesta antes de reenviarla.
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    <div class="lg:col-span-2 space-y-5">
        <div class="bg-slate-900/60 border border-white/10 rounded-2xl p-5 space-y-4">
            <h2 class="text-sm font-semibold text-gray-100 flex items-center gap-2">
                <i class="fas fa-link text-emerald-400"></i>
                Enlace directo
            </h2>
            <div class="flex items-center gap-2 text-xs">
                <input type="text" readonly value="{{ $publicLink }}" class="flex-1 bg-slate-950/60 border border-white/10 rounded-xl px-3 py-2 text-gray-100 focus:outline-none">
                <button type="button" onclick="navigator.clipboard.writeText('{{ $publicLink }}')" class="px-3 py-2 rounded-xl bg-emerald-500 text-white font-semibold hover:bg-emerald-600 transition">
                    Copiar
                </button>
            </div>
            <p class="text-[11px] text-gray-500">Este es el enlace público que puedes compartir por cualquier canal.</p>
        </div>

        <div class="bg-slate-900/60 border border-white/10 rounded-2xl p-5 space-y-4">
            <h2 class="text-sm font-semibold text-gray-100 flex items-center gap-2">
                <i class="fas fa-envelope text-sky-400"></i>
                Invitación por correo
            </h2>
            <p class="text-xs text-gray-400">Puedes copiar este texto base para invitar a tus participantes. El envío masivo de correos se puede automatizar en una iteración posterior.</p>
            <textarea rows="4" class="w-full bg-slate-950/60 border border-white/10 rounded-xl px-3 py-2 text-gray-100 text-xs focus:outline-none">
Hola,

Te invitamos a responder la siguiente encuesta:
{{ $survey->title }}

Accede desde este enlace: {{ $publicLink }}

Gracias por tu participación.
            </textarea>
        </div>
    </div>

    <div class="space-y-5">
        <div class="bg-slate-900/60 border border-white/10 rounded-2xl p-5 space-y-3">
            <h2 class="text-sm font-semibold text-gray-100 flex items-center gap-2">
                <i class="fas fa-qrcode text-fuchsia-400"></i>
                Código QR
            </h2>
            <div class="bg-slate-950/80 border border-white/10 rounded-2xl aspect-square flex items-center justify-center">
                <p class="text-[11px] text-gray-500 px-4 text-center">La generación automática de QR se puede agregar integrando una librería como simplesoftwareio/simple-qrcode.</p>
            </div>
            <p class="text-[11px] text-gray-500">Escanea o imprime el QR para captar respuestas de forma presencial.</p>
        </div>

        <div class="bg-slate-900/60 border border-white/10 rounded-2xl p-5 space-y-3 text-xs">
            <h2 class="text-sm font-semibold text-gray-100 flex items-center gap-2">
                <i class="fas fa-bullhorn text-amber-400"></i>
                Resumen de estado
            </h2>
            <p class="flex items-center justify-between">
                <span class="text-gray-400">Estado de aprobación</span>
                <span class="text-gray-100 font-semibold">{{ strtoupper($survey->approval_status ?? 'PENDING') }}</span>
            </p>
            <p class="flex items-center justify-between">
                <span class="text-gray-400">Encuesta activa</span>
                <span class="text-gray-100 font-semibold">{{ $survey->is_active ? 'Sí' : 'No' }}</span>
            </p>
            <p class="text-[11px] text-gray-500 mt-2">El flujo completo de aprobación ya está gestionado desde el panel de administrador.</p>
        </div>
    </div>
</div>
@endsection
