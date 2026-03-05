@extends('layouts.editor')

@section('title', 'Compartir Encuesta')

@section('content')
<div class="ph">
    <div>
        <div class="ph-label">Difusión</div>
        <h1 class="ph-title">{{ $survey->title }}</h1>
        <div class="ph-sub">Genera enlace y resumen de estado antes de compartir</div>
    </div>
    <div class="ph-actions">
        <a href="{{ route('editor.encuestas.editar', $survey) }}" class="btn btn-neu btn-sm">
            <i class="fas fa-pen"></i>
            Volver al editor
        </a>
    </div>
</div>

<div class="nc mb-6">
    <div class="flex items-center gap-3 mb-4">
        <div class="w-10 h-10 rounded-xl bg-[var(--bg)] shadow-[var(--neu-out)] flex items-center justify-center text-[var(--verde)]">
            <i class="fas fa-paper-plane"></i>
        </div>
        <h2 class="text-sm font-bold text-[var(--text-dark)] uppercase tracking-wide">Estado de publicación</h2>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="flex flex-col gap-2">
            <span class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-widest">Aprobación</span>
            @php $approval = $survey->approval_status ?? 'pending'; @endphp
            <div>
                @if($approval === 'approved')
                    <span class="badge-neu bn-green">
                        <i class="fas fa-check-circle"></i> Aprobada
                    </span>
                @elseif($approval === 'rejected')
                    <span class="badge-neu bn-red">
                        <i class="fas fa-times-circle"></i> Rechazada
                    </span>
                @else
                    <span class="badge-neu bn-gold">
                        <i class="fas fa-clock"></i> Pendiente
                    </span>
                @endif
            </div>
            <p class="text-[11px] text-[var(--text-muted)] mt-1">
                @if($approval === 'approved')
                    Lista para compartir.
                @elseif($approval === 'rejected')
                    Revisa los comentarios.
                @else
                    Esperando revisión admin.
                @endif
            </p>
        </div>
        
        <div class="flex flex-col gap-2">
            <span class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-widest">Actividad</span>
            <div>
                <span class="badge-neu {{ $survey->is_active ? 'bn-green' : 'bn-muted' }}">
                    <i class="fas fa-power-off"></i>
                    {{ $survey->is_active ? 'Activa' : 'Inactiva' }}
                </span>
            </div>
            <p class="text-[11px] text-[var(--text-muted)] mt-1">
                {{ $survey->is_active ? 'Recibiendo respuestas.' : 'En modo borrador.' }}
            </p>
        </div>
        
        <div class="flex flex-col gap-2">
            <span class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-widest">Info</span>
            <p class="text-xs text-[var(--text)] leading-relaxed">
                @if($approval === 'pending')
                    Te avisaremos en la campana cuando sea aprobada o rechazada.
                @elseif($approval === 'approved')
                    Ya puedes distribuir el enlace público.
                @else
                    Corrige y vuelve a enviar para revisión.
                @endif
            </p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="nc space-y-4">
            <h2 class="text-sm font-bold text-[var(--text-dark)] flex items-center gap-2 uppercase tracking-wide">
                <i class="fas fa-link text-[var(--verde)]"></i>
                Enlace directo
            </h2>
            <div class="flex items-center gap-3">
                <input type="text" readonly value="{{ $publicLink }}" class="fn-input flex-1 text-xs">
                <button type="button" onclick="navigator.clipboard.writeText('{{ $publicLink }}')" class="btn btn-solid btn-sm">
                    Copiar
                </button>
            </div>
            <p class="text-[11px] text-[var(--text-muted)]">Este es el enlace público que puedes compartir por cualquier canal.</p>
        </div>

        <div class="nc space-y-4">
            <h2 class="text-sm font-bold text-[var(--text-dark)] flex items-center gap-2 uppercase tracking-wide">
                <i class="fas fa-envelope text-[var(--blue)]"></i>
                Invitación por correo
            </h2>
            <p class="text-xs text-[var(--text-muted)]">Texto base sugerido para invitar a tus participantes.</p>
            <textarea rows="6" class="nc-inset w-full font-mono text-xs leading-relaxed border-none focus:outline-none resize-none bg-[var(--bg-light)] text-[var(--text)]" readonly>
Hola,

Te invitamos a responder la siguiente encuesta:
{{ $survey->title }}

Accede desde este enlace:
{{ $publicLink }}

Gracias por tu participación.
            </textarea>
        </div>
    </div>

    <div class="space-y-6">
        <div class="nc space-y-4 text-center">
            <h2 class="text-sm font-bold text-[var(--text-dark)] flex items-center justify-center gap-2 uppercase tracking-wide">
                <i class="fas fa-qrcode text-[var(--oro)]"></i>
                Código QR
            </h2>
            <div class="aspect-square bg-white rounded-xl flex items-center justify-center shadow-[var(--neu-in)] p-4 mx-auto max-w-[200px]">
                <!-- Placeholder for QR -->
                <i class="fas fa-qrcode text-6xl text-[var(--neu-dark)] opacity-20"></i>
            </div>
            <p class="text-[11px] text-[var(--text-muted)]">
                Escanea para acceder.<br>
                (Librería QR pendiente)
            </p>
        </div>

        <div class="nc space-y-3">
            <h2 class="text-sm font-bold text-[var(--text-dark)] flex items-center gap-2 uppercase tracking-wide">
                <i class="fas fa-info-circle text-[var(--text-light)]"></i>
                Resumen
            </h2>
            <div class="flex items-center justify-between text-xs border-b border-[var(--neu-dark)]/10 pb-2">
                <span class="text-[var(--text-muted)]">Estado</span>
                <span class="font-bold text-[var(--text-dark)]">{{ strtoupper($survey->approval_status ?? 'PENDING') }}</span>
            </div>
            <div class="flex items-center justify-between text-xs pt-1">
                <span class="text-[var(--text-muted)]">Visible</span>
                <span class="font-bold text-[var(--text-dark)]">{{ $survey->is_active ? 'Sí' : 'No' }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
