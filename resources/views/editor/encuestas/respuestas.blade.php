@extends('layouts.editor')

@section('title', 'Respuestas de Encuesta')

@section('content')
<div class="ph">
    <div>
        <div class="ph-label">Resultados</div>
        <h1 class="ph-title">{{ $survey->title }}</h1>
        <div class="ph-sub">Resumen por pregunta de las respuestas recibidas</div>
    </div>
    <div class="ph-actions">
        <a href="{{ route('editor.encuestas.editar', $survey) }}" class="btn btn-neu btn-sm">
            <i class="fas fa-pen"></i>
            Editor
        </a>
        <a href="{{ route('editor.encuestas.compartir', $survey) }}" class="btn btn-solid btn-sm">
            <i class="fas fa-share-alt"></i>
            Compartir
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
    <div class="kpi-card">
        <div class="kp-top">
            <div class="kp-icon text-[var(--verde)]"><i class="fas fa-inbox"></i></div>
        </div>
        <div>
            <div class="kp-value">{{ $totalResponses }}</div>
            <div class="kp-label">Total respuestas</div>
        </div>
    </div>
    
    <div class="kpi-card">
        <div class="kp-top">
            <div class="kp-icon text-[var(--blue)]"><i class="fas fa-percentage"></i></div>
        </div>
        <div>
            <div class="kp-value">{{ $completionRate }}%</div>
            <div class="kp-label">Tasa completado</div>
        </div>
    </div>

    <div class="kpi-card">
        <div class="kp-top">
            <div class="kp-icon text-[var(--oro)]"><i class="fas fa-clock"></i></div>
        </div>
        <div>
            <div class="kp-value">
                @if($avgTimeSeconds)
                    {{ $avgTimeSeconds }}s
                @else
                    --
                @endif
            </div>
            <div class="kp-label">Tiempo promedio</div>
        </div>
    </div>

    <div class="kpi-card cursor-not-allowed opacity-70">
        <div class="kp-top">
            <div class="kp-icon text-[var(--text-muted)]"><i class="fas fa-file-export"></i></div>
        </div>
        <div>
            <div class="kp-value text-xl mt-2 text-[var(--text-muted)]">CSV / PDF</div>
            <div class="kp-label">Próximamente</div>
        </div>
    </div>
</div>

<div class="nc">
    <div class="flex items-center gap-2 border-b border-[var(--neu-dark)]/10 pb-4 mb-6">
        <button class="btn btn-solid btn-sm">
            Resumen
        </button>
        <button class="btn btn-neu btn-sm opacity-60 cursor-not-allowed">
            Individuales
        </button>
        <button class="btn btn-neu btn-sm opacity-60 cursor-not-allowed">
            Análisis
        </button>
    </div>

    <div class="space-y-8">
        @if($totalResponses === 0)
            <div class="text-center py-10">
                <i class="fas fa-inbox text-4xl text-[var(--neu-dark)] mb-3"></i>
                <p class="text-sm text-[var(--text-muted)]">Aún no hay respuestas para esta encuesta.</p>
            </div>
        @else
            @foreach($survey->questions as $index => $question)
                <div class="nc-inset">
                    <p class="font-bold text-[var(--text-dark)] mb-4 text-sm flex items-start gap-2">
                        <span class="text-[var(--verde)]">{{ $index + 1 }}.</span>
                        {{ $question['text'] }}
                    </p>
                    
                    @if(in_array($question['type'], ['multiple_choice', 'checkboxes']) && !empty($question['options']))
                        @php
                            $counts = [];
                            foreach ($question['options'] as $opt) {
                                $counts[$opt] = 0;
                            }
                            foreach ($responses as $response) {
                                $answers = $response->answers[$question['text']] ?? null;
                                if (is_array($answers)) {
                                    foreach ($answers as $ans) {
                                        if (isset($counts[$ans])) {
                                            $counts[$ans]++;
                                        }
                                    }
                                } else {
                                    if ($answers !== null && isset($counts[$answers])) {
                                        $counts[$answers]++;
                                    }
                                }
                            }
                        @endphp
                        <div class="space-y-3">
                            @foreach($counts as $opt => $count)
                                @php
                                    $percent = $totalResponses > 0 ? round(($count / $totalResponses) * 100) : 0;
                                @endphp
                                <div>
                                    <div class="flex justify-between text-[11px] mb-1">
                                        <span class="text-[var(--text)] font-semibold">{{ $opt }}</span>
                                        <span class="text-[var(--text-muted)] font-mono">{{ $count }} ({{ $percent }}%)</span>
                                    </div>
                                    <div class="w-full h-2 rounded-full bg-[var(--bg)] shadow-[var(--neu-in-sm)] overflow-hidden">
                                        <div class="h-full rounded-full bg-[var(--verde)]" style="width: {{ $percent }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="nc p-4 flex items-center gap-3">
                            <i class="fas fa-align-left text-[var(--text-muted)]"></i>
                            <span class="text-[var(--text-muted)] text-xs italic">
                                Pregunta abierta o de texto. El detalle de respuestas se puede explorar en la pestaña Individuales.
                            </span>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
